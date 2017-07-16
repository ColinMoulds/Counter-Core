<?php
@include_once('link.php');
@include_once('steamauth/steamauth.php');
if(!isset($_SESSION["steamid"])) {
	Header("Location: index.php");
	exit;
}
$amount = $_POST["coincredits"];
$side = $_POST["Side"];
$hside = 0; //1 = ct, 2 = t;
$dataside = 0; // 1 CT,  2 T
$steam = $_SESSION["steamid"];
$steam = $_SESSION["steamid"];
$hid = fetchinfo("hid","cflobbies","id",$id);
$pcredits = fetchinfo("credits","users","steamid",$steam);
$status = fetchinfo("ended","cflobbies","id",$id);

//ct 0-49, T 50-100;

if($side === 'CT'){
	$hside = 1;
}else if($side == 'T'){
	$hside = 2;
}

if(isset($_SESSION["steamid"])) {
	if($amount >= 10){
		if($pcredits >= $amount){
			$updatebal = $pcredits - $amount;
			mysql_query("UPDATE users SET `credits`='$updatebal' WHERE `steamid`='$steam'");
			mysql_query("INSERT INTO `cflobbies` (`hid`,`hside`,`cid`,`value`,`win`,`ended`) VALUES ('$steam','$hside','','$amount','','0')");
		}
	}
}



	Header("Location: coinflip.php");

exit;
?>
