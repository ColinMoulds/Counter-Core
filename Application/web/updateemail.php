<?php
@include_once('link.php');
@include_once('steamauth/steamauth.php');
if(!isset($_SESSION["steamid"])) {
	Header("Location: index.php");
	exit;
}

$myemail = fetchinfo("email","users","steamid",$_SESSION["steamid"]);
$newemail = $_POST["link"];
$newemail = mysql_real_escape_string($newemail);
$steam = $_SESSION["steamid"];
if(filter_var($newemail, FILTER_VALIDATE_EMAIL))
{
	mysql_query("UPDATE users SET `email`='$newemail' WHERE `steamid`='$steam'");

	if($myemail)
	{
		mysql_query("INSERT INTO `messages` (`type`,`app`,`userid`,`title`,`msg`,`time`,`active`) VALUES ('success','0','$steam','Success!','You have successfully changed your e-mail!','10',1)");
	}
	if(!$myemail)
	{
		mysql_query("INSERT INTO `messages` (`type`,`app`,`userid`,`title`,`msg`,`time`,`active`) VALUES ('success','0','$steam','Success!','You have successfully set your e-mail!','10',1)");
	}
}
else
{
	mysql_query("INSERT INTO `messages` (`type`,`app`,`userid`,`title`,`msg`,`time`,`active`) VALUES ('error','0','$steam','Error!','You entered an invalid e-mail!','10',1)");
}

Header("Location: usersettings.php");

exit;
?>