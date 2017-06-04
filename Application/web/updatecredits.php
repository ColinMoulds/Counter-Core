<?php
session_start();
@include_once('link.php');
@include_once('functions.php');
$steamid = $_SESSION['steamid'];
if(!$steamid)
{
	die();
}
$credits=fetchinfo("credits","users","steamid",$steamid);
echo $credits;
?>