<?php
include_once ('link.php');
$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);
//$value=fetchinfo("SUM(cost)","jackpotdeposits","gameid",$gameid);
$rs0=mysql_query("SELECT SUM(cost) from `jackpotdeposits` WHERE `gameid`='$gameid'");
$value = mysql_fetch_row($rs0);
$value=$value[0];
if(!$value||$value==NULL)
{
	$value=0;
}
$value=round($value,2);
echo $value.' Credits';

?>