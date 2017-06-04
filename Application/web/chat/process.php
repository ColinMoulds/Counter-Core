<?php
session_start();
                $steamid = $_SESSION["steamid"];
				if(!$steamid)
				{
					die();
				}
				$room = 0;
				$room=mysql_escape_string($room);

                include_once(dirname(__FILE__) . '/../link.php');
				
				$admin = fetchinfo("admin","users","steamid",$_SESSION["steamid"]);
				$premium = fetchinfo("premium","users","steamid",$_SESSION["steamid"]);

				$dbname = fetchinfo("name","users","steamid",$_SESSION["steamid"]);
				$dbname=mysql_escape_string($dbname);
				$dbava = fetchinfo("avatar","users","steamid",$_SESSION["steamid"]);
				$lastmsg = fetchinfo("lastmsg","users","steamid",$_SESSION["steamid"]);
				$cban = fetchinfo("cban","users","steamid",$_SESSION["steamid"]);

				$message=$_POST['message'];
				$time=time();
				$nmsg=$time+$bnmsg;
				$pmsg=$time+$bpmsg;
				$cens=array(
                  'you-can-add','censored-words-here',
                 );

					foreach($cens as $c)
				 
					$message=str_ireplace($cens, '****', $message);
					
    				if(($message) != "\n" && $message != "" && $message != " " && $message != "  " && $message != "   " && $message != "    " && $message != "     " && $message != "      " && $message != "       ")
					{

                        if($admin != "0" || $admin != 0)
						{
								$type=0;
								if (0 === strpos($message, '/a'))
								{
									$message=replace_first('/a','',$message);
									$type=1;
								}
								$message = htmlentities(strip_tags($message));
								$message=mysql_real_escape_string($message);
								if($admin==1)
								{
									$badge=1;
								}
								if($admin==2)
								{
									$badge=2;
								}
								if($admin==3)
								{
									$badge=3;
								}
								if(!$color)
								{
									if($admin==1)
									{
										$color='#A8FFB4';
									}
									if($admin==2)
									{
										$color='#85D6FF';
									}
									if($admin==3)
									{
										$color='#FF8585';
									}
								}
								if(!$mcolor)
								{
									$mcolor='#E8E8E8';
								}
								mysql_query("INSERT INTO `chat` (`room`,`name`,`badge`,`steamid`,`avatar`,`msg`,`time`,`nc`,`mc`,`type`) VALUES ('$room','$dbname','$badge','$steamid','$dbava','$message','$time','$color','$mcolor','$type')");	
								$lastid=mysql_insert_id();
								$lastid=$lastid*1;
								$arr = array('messageid' => $lastid, 'room' => $room);
								echo json_encode($arr);
								mysql_query("UPDATE `users` SET `lastmsg`='$nmsg' WHERE `steamid`='$steamid'");
								
                            
                        }
                        else if($premium == "1" || $premium == 1)
						{
							if($lastmsg<=$time && $cban==0)
							{
								$badge=4;
								$message = htmlentities(strip_tags($message));
								$message=mysql_real_escape_string($message);
								if(!$color)
								{
									$color = "#FFD885";
								}
								if(!$mcolor)
								{
									$mcolor='#E8E8E8';
								}
								mysql_query("INSERT INTO `chat` (`room`,`name`,`badge`,`steamid`,`avatar`,`msg`,`time`,`nc`,`mc`) VALUES ('$room','$dbname','$badge','$steamid','$dbava','$message','$time','$color','$mcolor')");	
								$lastid=mysql_insert_id();
								$arr = array('messageid' => $lastid, 'room' => $room);
								echo json_encode($arr);
								mysql_query("UPDATE `users` SET `lastmsg`='$pmsg' WHERE `steamid`='$steamid'");
							
							}	
						}
                        else
						{
							if($lastmsg<=$time && $cban==0)
							{
								$color = "#FFF3C4";
								if(!$mcolor)
								{
									$mcolor='#E8E8E8';
								}
								$message = htmlentities(strip_tags($message));
								$message=mysql_real_escape_string($message);
								mysql_query("INSERT INTO `chat` (`room`,`name`,`steamid`,`avatar`,`msg`,`time`,`nc`,`mc`) VALUES ('$room','$dbname','$steamid','$dbava','$message','$time','$color','$mcolor')");	
								$lastid=mysql_insert_id();
								$arr = array('messageid' => $lastid, 'room' => $room);
								echo json_encode($arr);						
								mysql_query("UPDATE `users` SET `lastmsg`='$nmsg' WHERE `steamid`='$steamid'");
							
							}
						}
					}
    	

	

?>