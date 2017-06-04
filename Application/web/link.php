<?php
//session_start();
$link = mysql_connect("localhost", "root", ""); // MySQL Host , Username and password
$db_selected = mysql_select_db('csgjp', $link); // MySQL Database
mysql_query("SET NAMES utf8");

function fetchinfo($rowname,$tablename,$finder,$findervalue)
{
	if($finder == "1") $result = mysql_query("SELECT $rowname FROM $tablename");
	else $result = mysql_query("SELECT $rowname FROM $tablename WHERE `$finder`='$findervalue'");
	$row = mysql_fetch_assoc($result);
	return $row[$rowname];
}

function secureoutput($string)
{
	$string = mysql_real_escape_string($string);
	$string=htmlentities(strip_tags($string));
	$string=str_replace('>', '', $string);
	$string=str_replace('<', '', $string);
	$string=htmlspecialchars($string);
	return $string;
}
function addemotes($message,$admin,$premium,$steamid)
{
	$emotes = array
	(
		/*
		Emote name
		Emote extension
		Type: 0=Public | 1=Premium | 2=Admin | 3=Custom
		Customid: 0=Public | 0<=Steam ID of the owner
		Preferred width
		*/
		
		array("Kappa","png",0,0,25),

		
	 );
	 
	foreach($emotes as $e)
	{
		$width=$e[4];
		if($e[2]==0)
		{
			$message=str_ireplace($e[0], "<img width='$width'src='chat/emotes/".$e[0].".".$e[1]."' title='".$e[0]."'>", $message);
			continue;
		}
		if( $e[2]==1&&$premium==1 || $e[2]==1&&$admin!=0)
		{
			$message=str_ireplace($e[0], "<img width='$width' src='chat/emotes/".$e[0].".".$e[1]."' title='".$e[0]."'>", $message);
			continue;
		}
		if($e[2]==2&&$admin!=0)
		{
			$message=str_ireplace($e[0], "<img width='$width' src='chat/emotes/".$e[0].".".$e[1]."' title='".$e[0]."'>", $message);
			continue;
		}
		if($e[2]==3 && $e[3]!=0 && $e[3]==$steamid || $admin!=0)
		{
			$message=str_ireplace($e[0], "<img width='$width' src='chat/emotes/".$e[0].".".$e[1]."' title='".$e[0]."'>", $message);
			continue;
		}
	}
	return $message;
}
?>