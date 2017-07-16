<?php
ob_start();
require ('openid.php');
session_start();
function logoutbutton() {
    echo "<form action=\"steamauth/logout.php\" method=\"post\"><input value=\"Logout\" type=\"submit\" /></form>"; //logout button
}
 
function steamlogin()
{
try {
    require("settings.php");
    $openid = new LightOpenID($steamauth['domainname']);
 
    $button = $button[$steamauth['buttonstyle']];
 
    if(!$openid->mode) {
        if(isset($_GET['login'])) {
            $openid->identity = 'http://steamcommunity.com/openid';
            header('Location: ' . $openid->authUrl());
        }
 
    return "<form action=\"?login\" method=\"post\"> <input type=\"image\" src=\"http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_01".$button.".png\"></form>";
    }
 
     elseif($openid->mode == 'cancel') {
        echo 'User has canceled authentication!';
    } else {
        if($openid->validate()) {
                $id = $openid->identity;
                $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                preg_match($ptn, $id, $matches);
 
                $_SESSION['steamid'] = $matches[1];
                include_once("link.php");
                $query = mysql_query("SELECT * FROM users WHERE steamid='".$_SESSION['steamid']."'");
                if (mysql_num_rows($query) == 0)
                {
                    $secret=generateRandomString(10);
                    $time=time();
                    mysql_query("INSERT INTO users (steamid,reg,account_secret) VALUES ('".$_SESSION['steamid']."','$time','$secret')") or die("MySQL ERROR: ".mysql_error());
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
 
?>