<?php
@include_once('link.php');
@include_once('steamauth/steamauth.php');
$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);

$rs0=mysql_query("SELECT SUM(cost) from `jackpotdeposits` WHERE `gameid`='$gameid'");
$value = mysql_fetch_row($rs0);
$cb=$value[0];
if(!$value||$value==NULL)
{
	$cb=0;
}
	
	$rs = mysql_query("SELECT * FROM `jackpotdeposits` WHERE `gameid`='$gameid' GROUP BY `userid` ORDER BY `id` DESC");
	$crs = "";
	if(mysql_num_rows($rs) == 0) 
	{
		echo'<br><h4>Be the first to deposit!</h4>';
	} 
	else
	{
		$crs.='<center><table class="table winnertable" id="winnertable" style="width:100%; margin: 0;">
					
					<tbody class="row lato">
					<div class="newdeposits" id="newdeposits">';

		$usern=0;
		while($row = mysql_fetch_array($rs))
		{
			$usern++;
			$avatar = $row["useravatar"];
			$userid = $row["userid"];
			$username = fetchinfo("name","users","steamid",$userid);
			$username=secureoutput($username);
			$rs2 = mysql_query("SELECT SUM(cost) AS cost FROM `jackpotdeposits` WHERE `userid`='$userid' AND `gameid`='$gameid'");						
			$row = mysql_fetch_assoc($rs2);
			$sumvalue = $row["cost"];
			$sumvalue=round($sumvalue,2);
			$depid=$row['id'];
					
			$crs .= '
			<tr id="dep'.$userid.'" class="" style="text-align: left; vertical-align: middle;">
			<td><center><a href="http://steamcommunity.com/profiles/'.$userid.'"><img src="'.$avatar.'" width="30" class="rounded"></a>&emsp; <a href=""><font color="black"><a href="http://steamcommunity.com/profiles/'.$userid.'"><b>'.$username.'</b></a></font></a>&ensp; deposited &ensp;<font color="#3D732A"><span class="label label-pill label-success"><b>'.$sumvalue.' Credits</b></font></span></font></center>
		';
		

			$crs.='</td></tr>';
		
			
			
		}
		$crs.='	</div></tbody>
				</table>';

	}
	echo $crs;


?>