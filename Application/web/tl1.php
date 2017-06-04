<?php
include_once ('link.php');
$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);
?>

<?php
$rtime = fetchinfo("starttime","jackpotgames","id",$gameid);
$time=time();
if($rtime==2147483647)
{
	$rtime=-1;
}
else
{
	$rtime=$rtime+120;
}
?>

<script>
var curTime = <?php echo $time ?>;
var endTime = <?php echo $rtime ?>;
</script>