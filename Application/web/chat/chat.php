<?php
include_once(dirname(__FILE__) . '/../link.php');

	
	$rs = mysql_query("SELECT * FROM (SELECT * FROM `chat` WHERE `room`='0' ORDER BY ID DESC LIMIT 30) AS T ORDER BY T.ID ASC");
	if(mysql_num_rows($rs) == 0)
	{
		
	}
	else
	{
		while($row = mysql_fetch_array($rs))
		{
			$id=$row['id'];
			$cname=$row['name'];
			$cname=secureoutput($cname);
		
			$sid=$row['steamid'];
			$avatar=$row['avatar'];
			$admin=fetchinfo("admin","users","steamid",$sid);
			$premium=fetchinfo("premium","users","steamid",$sid);
			$msg=$row['msg'];
			$msg=addemotes($msg,$admin,$premium,$sid);
			$time=$row['time'];
			$color=$row['nc'];
			if($admin==1)
			{
				$color='FF8F0F';
			}
			if($admin==2)
			{
				$color='FF6363';
			}
			
			$date=date('H:i', $time);

			echo"<div style='border-bottom: dotted 1px #DCDCDC; display:flex'>
				<a href='profile.php?action=view&id=".$sid."'><img class='img-rounded' src='".$avatar."' height='50' width='50'></img></a><p style='float: right;width: 210px;overflow-wrap: break-word;padding: 3px;padding-left: 13px;'><a class='nameclick' style='color:#".$color."' target='_blank' href='profile.php?action=view&id=".$sid."'>".$cname."</a><br><a style='display: block;margin-top: 5px;'>".$msg = str_replace("\n", " ", $msg)."</a></p><a href='index.php?action=cban&id=$steamid' class='ban' style='display:none'></a><script>document.getElementById('chat-wrap').scrollTop = document.getElementById('chat-wrap').scrollHeight;</script>
				</div>
			";
		}
		
	}
?>