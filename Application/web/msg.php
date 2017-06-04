<?php
@include_once ("link.php");
@include_once('steamauth/steamauth.php');

if(isset($_SESSION['steamid']))
{
	$rs = mysql_query("SELECT * FROM messages WHERE `userid` = '".$_SESSION['steamid']."' AND `active`='1'");
	while($row = mysql_fetch_array($rs)) 
	{
		$type = $row["type"];
		$app = $row["app"];
		$msg = $row["msg"];
		$title = $row["title"];
		$time = $row["time"];
		
		if(strlen($msg) > 0) 
		{
			if($app==1)
			{
				$msg=mysql_real_escape_string($msg);
				echo"
					<script>
						  swal('".$title."', '".$msg."');
					</script>
					";
				mysql_query("UPDATE`messages` SET `active`='0' WHERE `ID`='".$row["ID"]."'");
			}
			if($app==0)
			{
				$delay=$row['delay'];
				$ct=time();
				if($delay<=$ct)
				{
					echo"
						<script>
						$.Notification.notify('".$type."', 'top center',
						 '".$title."',
						 '".$msg."');
						 </script>
						 ";
					 mysql_query("UPDATE`messages` SET `active`='0' WHERE `ID`='".$row["ID"]."'");
				}
			}
		}
	}
	$banned=fetchinfo("ban","users","steamid",$_SESSION["steamid"]);
	if($banned)
	{
		echo '<script>location.href="index.php" </script>';
	}
}
?>