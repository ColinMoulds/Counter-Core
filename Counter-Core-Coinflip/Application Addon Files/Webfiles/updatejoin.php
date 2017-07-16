<?php
@include_once('link.php');
@include_once('steamauth/steamauth.php');
if(!isset($_SESSION["steamid"])) {
	Header("Location: index.php");
	exit;
}

$id = $_GET['id'];

$steam = $_SESSION["steamid"];
$hid = fetchinfo("hid","cflobbies","id",$id);
$wageamount = fetchinfo("value","cflobbies","id",$id);
$pcredits = fetchinfo("credits","users","steamid",$steam);
$randomnum = rand(0, 100);
$status = fetchinfo("ended","cflobbies","id",$id);

if($randomnum >= 0 && $randomnum <= 49){
	$dataside = 1;
}else if($randomnum >= 50 && $randomnum <= 100){
	$dataside = 2;
}

		if($status == 0){
			if($hid != $steam){
				if($pcredits >= $wageamount){
						$updatebal = $pcredits - $wageamount;
						mysql_query("UPDATE users SET `credits`='$updatebal' WHERE `steamid`='$steam'");
						mysql_query("UPDATE cflobbies SET `cid`='$steam' WHERE `id`='$id'");
						mysql_query("UPDATE cflobbies SET `win`='$dataside' WHERE `id`='$id'");
						mysql_query("UPDATE cflobbies SET `ended`='1' WHERE `id`='$id'");
				}
			}
			//mysql_query("INSERT INTO `cflobbies` (`cid`,`ended`) VALUES ('$steam','1')");
		}

	Header("Location: lobby.php?id=$id");

exit;
?>
