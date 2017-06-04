<?php
include_once('link.php');

$id=$_GET['id'];

$id=mysql_escape_string($id);

$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);

$bg='#4D565E';

$ogameid=fetchinfo("gameid","jackpotdeposits","offerid",$id);

if($ogameid!=$gameid)
{
	die();
}

$userid=fetchinfo("userid","jackpotdeposits","offerid",$id);

$rs2 = mysql_query("SELECT username, SUM(cost) AS cost FROM `jackpotdeposits` WHERE `userid`='$userid' AND `gameid`='$gameid'");						
$row = mysql_fetch_assoc($rs2);
$sumvalue = $row["cost"];
$name=$row["username"];
$sumvalue=round($sumvalue,2);

$username=secureoutput($name);

$avatar = fetchinfo("avatar","users","steamid",$userid);
echo'<tr id="dep'.$userid.'" class="" style="text-align: left; vertical-align: middle;">
	<td><center><a href="http://steamcommunity.com/profiles/'.$userid.'"><img src="'.$avatar.'" width="30" class="rounded"></a>&emsp; <a href=""><font color="black"><a href="http://steamcommunity.com/profiles/'.$userid.'"><b>'.$username.'</b></a></font></a>&ensp; deposited &ensp;<font color="#3D732A"><span class="label label-pill label-success"><b>'.$sumvalue.' Credits</b></font></span></font></center>'

?>