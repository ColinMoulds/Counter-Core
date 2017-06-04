<?php
@include_once('link.php');
@include_once('steamauth/steamauth.php');
if(!isset($_SESSION["steamid"]))
{
	Header("Location: index.php");
	exit;
}

$admin = fetchinfo("admin","users","steamid",$_SESSION["steamid"]);

if($admin==0)
{
	die();
}

$banid = $_POST["bid"];
$bantime = $_POST["bh"];
if(!is_numeric($bantime))
{
	$bantime=-1;
}
$time=time();
if($bantime!=-1)
{
	$bantime=$bantime*60;
	$bantime=$time+$bantime;
}
$banreason = $_POST["br"];
$banreason = mysql_real_escape_string($banreason);
if(!$banreason)
{
	$banreason="No reason given";
}
$banby = fetchinfo("name","users","steamid",$_SESSION["steamid"]);


mysql_query("UPDATE users SET `cban`='1' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `cbandate`='$time' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `cbanend`='$bantime' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `cbanby`='$banby' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `cbanreason`='$banreason' WHERE `steamid`='$banid'");
mysql_query("INSERT INTO `messages` (`type`,`userid`,`msg`,`time`) VALUES ('error','$banid','You\'ve been banned from the chat by $banby.','10')");	

$from=$_SERVER["HTTP_REFERER"];
echo '<script>location.href="'.$from.'" </script>';

exit;
?>