<?php
include ('link.php');
include ('core.php');
require_once('steamauth/steamauth.php');
@include_once('steamauth/userInfo.php');
if(isset($_SESSION["steamid"]))
{
	$time = time();
    mysql_query("UPDATE users SET lastseen=".$time." WHERE steamid=".$_SESSION['steamid']."");
	$mycredits=fetchinfo("credits","users","steamid",$_SESSION["steamid"]);
	$premium=fetchinfo("premium","users","steamid",$_SESSION["steamid"]);
	$banned=fetchinfo("ban","users","steamid",$_SESSION["steamid"]);
	$cbanned=fetchinfo("cban","users","steamid",$_SESSION["steamid"]);
	$mytrade = fetchinfo("tlink","users","steamid",$_SESSION["steamid"]);
	$admin = fetchinfo("admin","users","steamid",$_SESSION["steamid"]);
	$name=$steamprofile['personaname'];
	$name = mysql_real_escape_string($name);
	if($name)
	{
		mysql_query("UPDATE `users` SET `name`='".$name."', `avatar`='".$steamprofile['avatarfull']."' WHERE `steamid`='".$_SESSION["steamid"]."'");
	}
	if($banned==1)
	{
		$banby=fetchinfo("banby","users","steamid",$_SESSION["steamid"]);
		$banend=fetchinfo("banend","users","steamid",$_SESSION["steamid"]);
		$banreason=fetchinfo("banreason","users","steamid",$_SESSION["steamid"]);
		if($banend!=-1)
		{
			$banendt=date('Y-m-d - H:i', $banend);
			$bmsg='You have been banned from this site by '.$banby.'.<br>Your ban ends on '.$banendt.'.<br>Ban reason: '.$banreason.'.';
		}
		else if($banend==-1)
		{
			$bmsg='You have been banned from this site by '.$banby.'.<br>Your ban is permanent.<br>Ban reason: '.$banreason.'.';
		}

		

		
		if($banend>=$time || $banend==-1)
		{
			echo $bmsg;
			die();
		}
		else
		{
			mysql_query("UPDATE `users` SET `ban`='0' WHERE `steamid`='".$_SESSION["steamid"]."'");
			mysql_query("UPDATE `users` SET `banend`='0' WHERE `steamid`='".$_SESSION["steamid"]."'");
			mysql_query("UPDATE `users` SET `banreason`='' WHERE `steamid`='".$_SESSION["steamid"]."'");
		}
	}
	$cbanstring='';
	if($cbanned==1)
	{
		$cbanby=fetchinfo("cbanby","users","steamid",$_SESSION["steamid"]);
		$cbanend=fetchinfo("cbanend","users","steamid",$_SESSION["steamid"]);
		$cbanreason=fetchinfo("cbanreason","users","steamid",$_SESSION["steamid"]);
		if($cbanend!=-1)
		{
			$cbanendt=date('Y-m-d - H:i', $cbanend);
			$cbtt='Chat ban by '.$cbanby.'';
			$cbmsg='Reason: '.$cbanreason.' - Ends on '.$cbanendt.'.';
	
		}
		else if($cbanend==-1)
		{
			$cbtt='You have been banned from the chat by '.$banby.'';
			$cbmsg='Reason: '.$cbanreason.' - The ban is permanent.';
		}
		if($cbanend>=$time || $cbanend==-1)
		{
					$cbanstring="
					<script>
					$.Notification.notify('black', 'top center',
                     '".$cbtt."',
                     '".$cbmsg."');
					 </script>
					 ";
		}
		else
		{
			mysql_query("UPDATE `users` SET `cban`='0' WHERE `steamid`='".$_SESSION["steamid"]."'");
			mysql_query("UPDATE `users` SET `cbanend`='0' WHERE `steamid`='".$_SESSION["steamid"]."'");
			mysql_query("UPDATE `users` SET `cbanreason`='' WHERE `steamid`='".$_SESSION["steamid"]."'");
		}
	}
}


if(isset($_GET["action"]))
{
	if($_GET["action"] == "view")
	{
		$sid = $_GET["id"];
	}
	if($_GET["action"] != "view")
	{
		echo '<script>location.href="index.php" </script>';
	}

}
if(!isset($_GET["action"]))
{
	if(isset($_SESSION["steamid"]))
	{
		$sid= $_SESSION['steamid'];
	}
	else
	{
		echo '<script>location.href="index.php" </script>';
	}
}

$sid=mysql_real_escape_string($sid);

$exists=fetchinfo("steamid","users","steamid",$sid);

if(!$exists)
{
	echo '<script>location.href="index.php" </script>';
}

	$pname=fetchinfo("name","users","steamid",$sid);
	$pname=secureoutput($pname);
	$premium=fetchinfo("premium","users","steamid",$sid);
	$avatar=fetchinfo("avatar","users","steamid",$sid);
	$uadmin = fetchinfo("admin","users","steamid",$sid);
	$reg = fetchinfo("reg","users","steamid",$sid);
	$gp=fetchinfo("games","users","steamid",$sid);
	$gw=fetchinfo("gameswon","users","steamid",$sid);
	
	$profit=fetchinfo("profit","users","steamid",$sid);
	
	$banned=fetchinfo("ban","users","steamid",$sid);
	$cbanned=fetchinfo("cban","users","steamid",$sid);
	
	$banby=fetchinfo("banby","users","steamid",$sid);
	$banend=fetchinfo("banend","users","steamid",$sid);
	$banreason=fetchinfo("banreason","users","steamid",$sid);
	
	$cbanby=fetchinfo("cbanby","users","steamid",$sid);
	$cbanend=fetchinfo("cbanend","users","steamid",$sid);
	$cbanreason=fetchinfo("cbanreason","users","steamid",$sid);
	
	if($reg)
	{
		$reg2date=date('Y-m-d', $reg);
	}
	else
	{
		$reg2date='Unknown';
	}
	if($gp==0  || $gw==0)
	{
		$wr=0;
	}
	else
	{
		$wr=($gw/$gp)*100;
	}
	$wr=round($wr);
	if($profit>0)
	{
		$ptext='<span class="oz"><font color="#A4D177" size="4">'.$profit.' Credits</font></span>';
	}
	if($profit==0)
	{
		$ptext='<span class="oz"><font color="#D1D077" size="4">'.$profit.' Credits</font></span>';
	}
	if($profit<0)
	{
		$profit=$profit*-1;
		$ptext='<span class="oz"><font color="#D17777" size="4">-'.$profit.' Credits</font></span>';
	}
	
	if($premium==1)
	{
	$id=$_SESSION['steamid'];
	$time=time();
	$puntil = fetchinfo("puntil","users","steamid","$id");
	if($puntil<=$time)
	{
		
		mysql_query("UPDATE users SET `premium`='0' WHERE `steamid`='$id'");
		mysql_query("UPDATE users SET `profile`='1' WHERE `steamid`='$id'");
		
	}
	if($uadmin==1)
	{
		$utitle="Moderator";
	}
	if($uadmin==2)
	{
		$utitle="Administrator";
	}
}

 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Site description">
        <meta name="author" content="Website.com">

        <link rel="shortcut icon" href="defico.png">

        <title><?php echo $title; ?></title>

        <!--Morris Chart CSS -->
		<link rel="stylesheet" href="assets/plugins/morris/morris.css">
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>

        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/wow.min.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>

        <script src="assets/plugins/peity/jquery.peity.min.js"></script>

        <!-- jQuery  -->
        <script src="assets/plugins/waypoints/lib/jquery.waypoints.js"></script>
        <script src="assets/plugins/counterup/jquery.counterup.min.js"></script>

	<script src="https://cdn.socket.io/socket.io-1.3.7.js"></script>	
	<script src="js/script.js"></script>

        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>

        <script src="assets/plugins/jquery-knob/jquery.knob.js"></script>

        <script src="assets/pages/jquery.dashboard.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        
        <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="assets/css/responsive.css" rel="stylesheet" type="text/css" />
        <script src="assets/plugins/notifyjs/dist/notify.min.js"></script>
        <script src="assets/plugins/notifications/notify-metro.js"></script>

        <link rel="stylesheet" href="chat/chat.css">
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

<link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>


    <body class="fixed-left">
<?php echo $cbanstring; ?>
        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
              <?php include 'topmenu.php';?>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->
            <?php include 'leftmenu.php';?>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content" style="text-align:center;">
                    <div class="container">
                      <div class="wraper container-fluid">
				<?php
					if($_GET["act"] == "unban")
					{
						if($sid!=$_SESSION['steamid'])
						{
							if($admin>1)
							{
								mysql_query("UPDATE users SET `ban`='0' WHERE `steamid`='$sid'");
								mysql_query("UPDATE `users` SET `banend`='0' WHERE `steamid`='$sid'");
								mysql_query("UPDATE `users` SET `banreason`='' WHERE `steamid`='$sid'");
								$from=$_SERVER["HTTP_REFERER"];
								echo '<script>location.href="'.$from.'" </script>';
							}
						}
					}	
			
					if($_GET["act"] == "cunban")
					{
						if($admin>0)
						{
							mysql_query("UPDATE users SET `cban`='0' WHERE `steamid`='$sid'");
							mysql_query("UPDATE `users` SET `cbanend`='0' WHERE `steamid`='$sid'");
							mysql_query("UPDATE `users` SET `cbanreason`='' WHERE `steamid`='$sid'");
							$from=$_SERVER["HTTP_REFERER"];
							echo '<script>location.href="'.$from.'" </script>';
						}
					}
					if($admin>=1)
					{
					echo'
					<div class="row">
                      <div class="col-md-12 col-lg-12">
                        <div class="card-box m-t-20">
							<h4 class="m-t-0 header-title"><b>Admin functions</b></h4>
								<div class="p-20">';
								if($admin>1)
								{
									
									if($banned==0)
									{
										echo'
										<font size="4"><b>Ban from the site</b></font>
										<br>
										<br>
										<form class="form-inline" method="post" action="ban.php">
											<div class="form-group">
												<input type="text" class="form-control" id="bid" name="bid" placeholder="Steam ID" value="'.$sid.'">
											</div>
											
											<div class="form-group">
												<input type="text" class="form-control" id="bh" name="bh" placeholder="Time(Minutes, -1=Perm)" value="">
											</div>
											
											<div class="form-group">
												<input type="text" class="form-control" id="br" name="br" placeholder="Reason" value="">
											</div>
											
											<button value="submit" name="submit" id="submit" type="submit" class="btn btn-danger waves-effect waves-light m-l-10 btn-md">Ban</button>
										</form>
										';
									}
									else
									{
										$banby = fetchinfo("banby","users","steamid",$sid);
										$banreason = fetchinfo("banreason","users","steamid",$sid);
										$banend = fetchinfo("banend","users","steamid",$sid);
										if($banend==-1)
										{
											$bant="The ban is permanent";
										}
										else
										{
											$bant=date('Y-m-d - H:i', $banend);
										}
										echo'<u>Chat Banned by:</u> <b>'.$banby.'</b> &ensp; <u>Ban Reason:</u> <b>'.$banreason.'</b> &ensp; <u>Banned until:</u> <b>'.$bant.'</b>';
										echo'<br><br>';
										
									}
									echo'
										<br>
										<br>';
								}
									if($cbanned==0)
									{
										echo'
										<font size="4"><b>Ban from the chat</b></font>
										<br>
										<br>
										<form class="form-inline" method="post" action="cban.php">
											<div class="form-group">
												<input type="text" class="form-control" id="bid" name="bid" placeholder="Steam ID" value="'.$sid.'">
											</div>
											
											<div class="form-group">
												<input type="text" class="form-control" id="bh" name="bh" placeholder="Time(Minutes, -1=Perm)" value="">
											</div>
											
											<div class="form-group">
												<input type="text" class="form-control" id="br" name="br" placeholder="Reason" value="">
											</div>
											
											<button value="submit" name="submit" id="submit" type="submit" class="btn btn-danger waves-effect waves-light m-l-10 btn-md">Ban</button>
										</form>';
									}
									else
									{
										$cbanby = fetchinfo("cbanby","users","steamid",$sid);
										$cbanreason = fetchinfo("cbanreason","users","steamid",$sid);
										$cbanend = fetchinfo("cbanend","users","steamid",$sid);
										if($cbanend==-1)
										{
											$cbant="The chat ban is permanent";
										}
										else
										{
											$cbant=date('Y-m-d - H:i', $cbanend);
										}
										echo'<u>Chat Banned by:</u> <b>'.$cbanby.'</b> &ensp; <u>Ban Reason:</u> <b>'.$cbanreason.'</b> &ensp; <u>Banned until:</u> <b>'.$cbant.'</b>';
										echo'<br><br>';
										echo'<a href="profile.php?action=view&id='.$sid.'&act=cunban"><button class="btn btn-danger waves-effect waves-light">Unban User</button></a>';
									}
										
										
										echo'
										<br>
										<br>';
										if($premium==1)
										{
											if($admin>1)
											{
												echo'

												<a href="profile.php?action=view&id='.$sid.'&act=unpr"><button class="btn btn-danger waves-effect waves-light">Revoke Premium</button></a>

												';
											}
										}
										else
										{
											if($admin>1)
											{
												echo'

												<a href="profile.php?action=view&id='.$sid.'&act=pr"><button class="btn btn-success waves-effect waves-light">Give Premium</button></a>
												';		
											}
										}
								
									
								echo'</div>
							</div>
                        </div>                      
                    </div>';
					}
					
					if($_GET["act"] == "pr")
					{
						if($admin>1)
						{
							$time=time();
							$time=$time+ 2592000;
							$mysid=$_SESSION['steamid'];
							mysql_query("UPDATE users SET `premium`='1' WHERE `steamid`='$sid'");
							mysql_query("UPDATE users SET `puntil`='$time' WHERE `steamid`='$sid'");
							$from=$_SERVER["HTTP_REFERER"];
							echo '<script>location.href="'.$from.'" </script>';
						}
						
					}
					if($_GET["act"] == "unpr")
					{
						if($admin>1)
						{

							$mysid=$_SESSION['steamid'];
							mysql_query("UPDATE users SET `premium`='0' WHERE `steamid`='$sid'");
							$from=$_SERVER["HTTP_REFERER"];
							echo '<script>location.href="'.$from.'" </script>';
						}
						
					}
					
                    ?>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="bg-picture text-center">
                                <div class="bg-picture-overlay"></div>
                                <div class="profile-info-name">
								<?php

								echo'<a href="http://steamcommunity.com/profiles/'.$sid.'" target="_BLANK"><img src="'.$avatar.'" class="thumb-lg img-circle img-thumbnail" alt="profile-image"></a>'; 
								
								?>

                                    <h4 class="m-b-5"><b><?php echo '<a href="http://steamcommunity.com/profiles/'.$sid.'" target="_BLANK">'.$pname.'</a>'; ?></b></h4>
                                    <?php echo'<p class="text-muted"><a href="http://steamcommunity.com/profiles/'.$sid.'" target="_BLANK"><i class="fa fa-map-marker"></i> View Steam Profile</a></p>'; ?>
									<?php 
									if($uadmin==1)
									{
										echo'Moderator';
									}
									if($uadmin==2)
									{
										echo'Administrator';
									}
									?>
                                </div>
                            </div>
                            <!--/ meta -->
                        </div>
                    </div>
					
               
                    
                    <div class="row">
                      <div class="col-md-12 col-lg-12">
                        
                        <div class="card-box m-t-20">
                <h4 class="m-t-0 header-title"><b>Available Information</b></h4>
                <div class="p-20">
                  <div class="about-info-p">
                                        <strong>Joined</strong>
                                        <br>
                                        <p class="text-muted"><?php echo $reg2date; ?></p>
                                    </div>
                                    <div class="about-info-p">
                                        <strong>Games Played</strong>
                                        <br>
                                        <p ><?php echo $gp; ?></p>
                                    </div>
                                    <div class="about-info-p">
                                        <strong>Games Won</strong>
                                        <br>
                                        <p ><?php echo $gw; ?></p>
                                    </div>
									
									  <div class="about-info-p m-b-0">
                                        <strong>Winrate</strong>
                                        <br>
                                        <p class="text-muted"><?php echo $wr; ?>%</p>
                                    </div>
									  <div class="about-info-p m-b-0">
                                        <strong>Profit</strong>
                                        <br>
                                        <p class="text-muted"><?php echo $ptext; ?></p>
                                    </div>
                </div>
              </div>
              
              <!-- Personal-Information -->
                        </div>                      
                        
                    </div>
                </div>

                    </div> <!-- container -->

                </div> <!-- content -->

                <?php include('footer.php'); ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll">
                <script>
      var name = "<?php echo $steamprofile['personaname'] ?>";
      var ava = "<?php echo $steamprofile['avatarfull'] ?>";
      var id = "<?php echo $_SESSION['steamid'] ?>";
      var color = "<?php echo 'FF0000' ?>";
      var admin = "<?php echo $admin ?>";

      // display name on page
      $("#name-area").html("You are: <span>" + name + "</span>");
      // kick off chat
    $(function() {

          // watch textarea for release of key press
          $('#sendie').keyup(function(e)
		  {       
            if (e.keyCode == 13) { 
              var text = $(this).val();
              var maxLength = $(this).attr("maxlength");  
              var length = text.length; 
              // send 
              if (length <= maxLength + 1) { 
                sendChat(text);
                $(this).val("");
              } else {
                $(this).val(text.substring(0, maxLength));
              } 
            }
          });
          

          $("#sendchat").click( function() 
		  {    
              var text = $('#sendie').val();
			  if(text)
			  {
				  var maxLength = $('#sendie').attr("maxlength");  
				  var length = text.length; 
				  if (length >= maxLength)
				  {  
					event.preventDefault();  
				  }  
				 else if (length <= maxLength + 1) { 
					sendChat(text);
					$('#sendie').val("");
				  } else {
					$('#sendie').val(text.substring(0, maxLength));
				  } 	  
				  
			  }
             
          });


		  function sendChat(message)
			{       
				console.log('sendchat pls');
				$.ajax({
					type: "POST",
					url: "chat/process.php",
					data: {"function": "send", "message": message}
				}).done(function(msg) 
				{
					msg=msg.replace('[]','');
					socket.emit('showchat',msg);
				});
			}
		});
      </script>
                <h4 class="text-center">Chat</h4>                      
                    <div class="row userarea" style="height:78%; padding: 0 5%;">
                          <div id="chat-wrap">
                            <?php include "chat/chat.php";?>
							<span class="newmessages"></span>
                            </div>
                            <div class="botton">
                            <?php
                if(!isset($_SESSION["steamid"])){
                  echo '
                  <div id="otpsoob"><div style="padding-top: 7px;">
                      <a href="" data-toggle="modal" data-target="#loginmodal" class="btn btn-success">
                        <p style="padding: 0; margin: 20px 0 20px 0; text-transform: uppercase; font-weight: bold;">Login through Steam</p>
                      </a>
                  </div></div>';
                } else {
                  echo '
                   
                    <div id="otpsoob"><form id="send-message-area">
                      <textarea id="sendie" maxlength="125" rows="2" placeholder="Enter your message"></textarea>
                      <button onClick="return false;" id="sendchat" class="btn btn-success">
                        Send
                      </button>
                      </form>
                    </div>
                  ';
                }
              ?>
                            </div>
                        </div>
            </div>
            <!-- /Right-bar -->

        </div>
        <!-- END wrapper -->

<script src="assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
        <script src="assets/pages/jquery.sweet-alert.init.js"></script>

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->


        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('.counter').counterUp({
                    delay: 100,
                    time: 1200
                });

                $(".knob").knob();

            });
        </script>




    </body>
</html>