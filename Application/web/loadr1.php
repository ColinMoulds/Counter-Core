<?php
@include_once('link.php');
$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);
$gameid--;

	$rs = mysql_query("SELECT * FROM `jackpotdeposits` WHERE `gameid`='$gameid' GROUP BY `userid`");
	$i = 0;
	$crd = "";
	while($row = mysql_fetch_array($rs)) {
		$crd .= 'avatar.push(\''.$row["useravatar"].'\');';
		$i++;
	}
echo '<script src="js/jquery.easing.1.3.js"></script>
<script>
	$(".stop-game").addClass("hidden");
	function getRandomInt(min, max) {
		return Math.floor(Math.random() * (max - min + 1)) + min;
	}
	var avatar=[]; 
	'.$crd.' 
	$( ".hhdgfbd" ).after( "<div id=\"hjgfd\" style=\"width: 1000px;margin: auto;overflow: hidden\"><div id=\"rouletbox\" style=\"height: 140px; width: 100%;  margin: auto\"><div class=\"roulet\"><div class=\"weaponline\" style=\"  margin-left: 330px\"></div><div class=\"mainbox\"><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img1\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img2\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img3\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img4\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img5\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img6\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img7\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img8\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img9\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img10\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img11\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img12\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img13\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img14\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img15\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img16\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img17\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img18\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img19\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img20\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img21\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img22\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img23\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img24\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img25\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img26\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img27\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img28\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img29\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img30\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img31\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img32\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img33\"></center></div></div><div class=\"weaponbox\" style=\"margin: 5px\"><div class=\"weaponheader\"><center><img style=\"width: 125px; height: 125px\" id=\"img34\"></center></div></div></div></div></div></div>");
	for(var i=1; i <= 34; i++) {
		var rand = getRandomInt(0,(avatar.length-1));
		$(\'#img\'+i).attr("src",avatar[rand]); 
		//alert(avatar[rand]);
	}';
	
$winner = fetchinfo("winnerid","jackpotgames","id",$gameid);
$avatar = fetchinfo("avatar","users","steamid",$winner);
echo '$(\'#img30\').attr("src","'.$avatar.'");'; 
echo '$(\'.mainbox\').css("margin-left",getRandomInt(-425,-5)+"px");
	setTimeout(function() {
		$(".mainbox").animate({marginLeft: getRandomInt(-3715,-3590)+"px"}, 7000, "easeOutExpo");
		audioElement3.play();
	},50);
	setTimeout(function() {
		$("#hjgfd").remove();
	},10000);
</script>';

?>