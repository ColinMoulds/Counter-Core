<?php
@include_once('link.php');
@include_once('functions.php');
$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);

$rsecret='CHANGEME'; // Also change this on the Bot, both should be the same secret.
$gsecret = $_GET['secret'];
if($rsecret!=$gsecret)
{
	echo'Invalid Secret Code!';
	die();
}

$in = fetchinfo("skins","jackpotgames","id",$gameid);
if($in==0)
{
	echo 'There are no skins in the pot.';
	die();
}
$jackpotcost = fetchinfo("SUM(cost)","jackpotdeposits","gameid",$gameid);
$rhash = "0.".str_pad(mt_rand(1000000,999999999),9,'0',STR_PAD_LEFT);
$whash= $jackpotcost*$rhash;

mysql_query("UPDATE `jackpotgames` SET `module`='$rhash' WHERE `id`='$gameid'");

$from=0;
$to=0;

$wincost = $jackpotcost*$rhash;
$jackpot1 = round($jackpotcost,2);
echo 'Jackpot Cost: '.$jackpotcost.'<br>Mov: '.$rhash.'<br>Winning Ticket: '.$wincost.'<br>';

echo'<br>';
$time=time();
$rs = mysql_query("SELECT * FROM `jackpotdeposits` WHERE `gameid`='$gameid'");
while($grow = mysql_fetch_array($rs))
{	
	$from=$to;
	$to+=$grow['cost'];
	echo 'Pool increased from '.$from.' Credits to '.$to.' Credits by '.$grow['username'].'\'s '.$grow['skin'].' &ensp; '.$grow['cost'].' Credits';
	if($wincost>=$from && $wincost<=$to)
	{
		echo'&emsp; Winner!';
		$winnerid=$grow['userid'];
		$winnername = mysql_real_escape_string($grow['username']);
		$rs = mysql_query("SELECT SUM(cost) AS ValueSum FROM `jackpotdeposits` WHERE `userid`='$winnerid' AND `gameid`='$gameid'") or die(logsqlerror(mysql_error()));
		$row = mysql_fetch_array($rs);
		$wonpercent = 100*$row["ValueSum"]/$jackpotcost;
		$wonpercent=round($wonpercent,2);
		mysql_query("UPDATE `jackpotgames` SET `percent`='$wonpercent', `winnername`='$winnername', `winnerid`='$winnerid', `endtime`='$time' WHERE `id`='$gameid'") or die(mysql_error());
		
	}
		
	echo'<br>';
}
$rs0 = mysql_query("SELECT SUM(cost) FROM `jackpotdeposits` WHERE `skin`='Credits' AND `userid`='$winnerid' AND `gameid`='$gameid'");						
$row = mysql_fetch_row($rs0);
$winnercredits=round($row[0]);

$rs = mysql_query("SELECT SUM(cost) as allcredits FROM `jackpotdeposits` WHERE `gameid`='$gameid' AND `userid`!='$winnerid' AND `skin`='Credits'");
if(mysql_num_rows($rs) != 0)
{
	$jrow = mysql_fetch_array($rs);
	$allcredits=0;
	$allcredits=$jrow['allcredits'];
	echo"Credits in the Pot: $allcredits Credits<br>";
}
$winworake=$winnercredits+$allcredits;
$rakep=calculaterake($winnerid);
$rakep=$rakep/100;
$rake=$allcredits*$rakep;
$rake=round($rake);
$profit=$allcredits-$rake;
$won=$profit+$winnercredits;
mysql_query("UPDATE `users` SET `credits`=credits+$won, `profit`=profit+profit, `won`=won+$won, `games`=games+1, `gameswon`=gameswon+1 WHERE `steamid`='$winnerid'");
mysql_query("UPDATE `users` SET `credits`=credits+$rake WHERE `steamid`='$adminid'");
mysql_query("INSERT INTO `messages` (`type`,`app`,`userid`,`title`,`msg`,`time`,`active`,`delay`) VALUES ('success','0','$winnerid','Congratulations!','You won $jackpotcost Credits in Game #$gameid with a $wonpercent% chance!','10',1,$time)");
echo"<br> Rake: $rake Credits<hr>";

$rs = mysql_query("SELECT userid FROM `jackpotdeposits` WHERE `gameid`='$gameid' GROUP BY userid") or die(mysql_error());
while($row = mysql_fetch_array($rs))
{
	if($row["userid"] == $winnerid)
	{

	}
	else
	{
		$loserid = $row["userid"];
		$rs = mysql_query("SELECT * FROM `jackpotdeposits` WHERE `userid`=".$loserid." AND `gameid`='$gameid'");
		$losercost=0;
		while($lrow = mysql_fetch_array($rs))
		{
			$losercost+=$lrow['cost'];
			$losercost=round($losercost,2);
			
		}

		mysql_query("UPDATE users SET `won`=won+$losercost, `profit`=profit-$losercost, `games`=games+1 WHERE `steamid`='$loserid'") or die(mysql_error());
		mysql_query("INSERT INTO `messages` (`type`,`app`,`userid`,`title`,`msg`,`time`,`active`,`delay`) VALUES ('error','0','$loserid','GL Next Game!','$winnername won $jackpotcost Credits in Game #$gameid with a $wonpercent% chance!','10',1,$time)");

	}
}

mysql_query("INSERT INTO `jackpotgames` (`starttime`) VALUES ('2147485547')") or die(mysql_error());

function calculaterake($steamid)
{
	$rake=10;
	$userpremium=fetchinfo("premium","users","steamid",$steamid);
	$username=fetchinfo("name","users","steamid",$steamid);
	if($userpremium==1)
	{
		$rake=3;
	}
	if(stristr(strtolower($username),"skingateway.com") != NULL || stristr(strtolower($username),"csgoresorts.com") != NULL)
	{
		$rake=5;
	}
	return $rake;
}
?>