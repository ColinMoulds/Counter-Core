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

$status = fetchinfo("ended","cflobbies","id",$id);


		if($status == 0){
			if($hid != $steam){
				if($pcredits >= $wageamount){
						$updatebal = $pcredits - $wageamount;
						mysql_query("UPDATE users SET `credits`='$updatebal' WHERE `steamid`='$steam'");
						mysql_query("UPDATE cflobbies SET `cid`='$steam' WHERE `id`='$id'");
						mysql_query("UPDATE cflobbies SET `ended`='1' WHERE `id`='$id'");
				}
			}
			//mysql_query("INSERT INTO `cflobbies` (`cid`,`ended`) VALUES ('$steam','1')");
		}






	Header("Location: lobby.php?id=$id");

exit;
?>
