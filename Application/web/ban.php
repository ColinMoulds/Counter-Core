<?php
@include_once('link.php');
@include_once('steamauth/steamauth.php');
if(!isset($_SESSION["steamid"])) {
	Header("Location: index.php");
	exit;
}

$admin = fetchinfo("admin","users","steamid",$_SESSION["steamid"]);

if($admin<2)
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


mysql_query("UPDATE users SET `ban`='1' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `bandate`='$time' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `banend`='$bantime' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `banby`='$banby' WHERE `steamid`='$banid'");
mysql_query("UPDATE users SET `banreason`='$banreason' WHERE `steamid`='$banid'");




$from=$_SERVER["HTTP_REFERER"];
echo '<script>location.href="'.$from.'" </script>';

exit;
?>