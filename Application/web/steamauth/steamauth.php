<?php
ob_start();
session_start();
require ('openid.php');

function logoutbutton() {
    echo "<form action=\"steamauth/logout.php\" method=\"post\"><input value=\"Logout\" type=\"submit\" /></form>"; //logout button
}

function steamlogin()
{
try {
    require("settings.php");
    $openid = new LightOpenID($steamauth['domainname']);

    $button['small'] = "small";
    $button['large_no'] = "large_noborder";
    $button['large'] = "large_border";
    $button = $button[$steamauth['buttonstyle']];
    
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
			exit();
        }
	$link='?login';
	if(isset($_GET['id']))
	{
		$id=$_GET['id'];
		$id=mysql_escape_string($id);
		$link="?id=$id&login";
	}
		
    return "<form action=\"$link\" method=\"post\"> <input type=\"image\" src=\"http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_".$button.".png\"></form>";
    }

     elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) { 
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
              
                $_SESSION['steamid'] = $matches[1]; 
				$steamid= $_SESSION['steamid'];
				$ip=getRealIpAddr();
				$ip=mysql_escape_string($ip);
				$time=time();
				$date=date('Y.m.d - H:i', $time);
				include_once("link.php");
				$query = mysql_query("SELECT * FROM users WHERE steamid='".$_SESSION['steamid']."'");
				//$hash = md5($steamid . time() . rand(1, 50));
				if (mysql_num_rows($query) == 0)
				{
					$secret=generateRandomString(10);
					setcookie('hash', $secret);
					$time=time();
					mysql_query("INSERT INTO users (steamid,reg,hash,account_secret,refcode) VALUES ('".$_SESSION['steamid']."','$time','$hash','$secret','".$_SESSION['steamid']."')") or die("MySQL ERROR: ".mysql_error());
					mysql_query("INSERT INTO user_history (userid,ico,icocolor,action,date) VALUES ('".$_SESSION['steamid']."','<i class=\'icon-plus\'></i>','success','Registered to CSGOResorts.com','$time')") or die("MySQL ERROR: ".mysql_error());
					mysql_query("INSERT INTO `logins` (`ip`,`steamid`,`time`) VALUES ('$ip','$steamid','$date')");
				}
				else
				{
					mysql_query("INSERT INTO `logins` (`ip`,`steamid`,`time`) VALUES ('$ip','$steamid','$date')") or die("MySQL ERROR: ".mysql_error());
					mysql_query("UPDATE `users` SET `hash`='$hash' WHERE `steamid`='$steamid'");
					$secret=fetchinfo("account_secret","users","steamid",$_SESSION["steamid"]);
					if(!$secret)
					{
						$secret=generateRandomString(10);
						mysql_query("UPDATE `users` SET `account_secret`='$secret' WHERE `steamid`='$steamid'");
						setcookie('hash', $secret);	
					}
					else
					{
						setcookie('hash', $secret);	
					}
				}
                //Determine the return to page. We substract "login&"" to remove the login var from the URL.
                //"file.php?login&foo=bar" would become "file.php?foo=bar"
                $returnTo = str_replace('login&', '', $_GET['openid_return_to']);
                //If it didn't change anything, it means that there's no additionals vars, so remove the login var so that we don't get redirected to Steam over and over.
                if($returnTo === $_GET['openid_return_to']) $returnTo = str_replace('?login', '', $_GET['openid_return_to']);
                header('Location: '.$returnTo);
        } else {
                echo "User is not logged in.\n";
        }

    }
} catch(ErrorException $e) {
    echo $e->getMessage();
}
}

if (!function_exists('getRealIpAddr')) 
{
	function getRealIpAddr()  
	{  
		if (!empty($_SERVER['HTTP_CLIENT_IP']))  
		{  
			$ip=$_SERVER['HTTP_CLIENT_IP'];  
		}  
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
		{  
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];  
		}  
		else  
		{  
			$ip=$_SERVER['REMOTE_ADDR'];  
		}  
		return $ip;  
	}
}

if (!function_exists('generateRandomString')) 
{
	function generateRandomString($length = 10)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}
}

if (!function_exists('fetchinfo')) 
{
	function fetchinfo($rowname,$tablename,$finder,$findervalue)
	{
		if($finder == "1") $result = mysql_query("SELECT $rowname FROM $tablename");
		else $result = mysql_query("SELECT $rowname FROM $tablename WHERE `$finder`='$findervalue'");
		$row = mysql_fetch_assoc($result);
		return $row[$rowname];
	}
}
?>
