<?php
@include_once('link.php');

$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);
$lg=$gameid-1;
$lw = fetchinfo("winnername","jackpotgames","id",$lg);
$lw=secureoutput($lw);
$ld = fetchinfo("winnerid","jackpotgames","id",$lg);
$lp = fetchinfo("percent","jackpotgames","id",$lg);
$lc = fetchinfo("value","jackpotgames","id",$lg);
$la = fetchinfo("avatar","users","steamid",$ld);

echo'
<h3>Game #'.$lg.'</h3>
<hr>
<img class="img-circle" src="'.$la.'" width="50">
<br><br>
<font color="#D64040">
<b>'.$lw.'</b> won the Last Pot (<b>'.$lc.'</b> Credits) with a <b>'.$lp.'%</b> chance!
</font>
';
?>