<?php
include ('link.php');
include ('core.php');
require_once('steamauth/steamauth.php');
@include_once('steamauth/userInfo.php');

if(!isset($_SESSION["steamid"]))
{
	echo '<script>location.href="index.php" </script>';
	exit();
}

if(isset($_SESSION["steamid"]))
{
	$time = time();
    mysql_query("UPDATE users SET lastseen=".$time." WHERE steamid=".$_SESSION['steamid']."");
$mycredits=fetchinfo("credits","users","steamid",$_SESSION["steamid"]);
	$premium=fetchinfo("premium","users","steamid",$_SESSION["steamid"]);
	$banned=fetchinfo("ban","users","steamid",$_SESSION["steamid"]);
	$cbanned=fetchinfo("cban","users","steamid",$_SESSION["steamid"]);
	$mytrade = fetchinfo("tlink","users","steamid",$_SESSION["steamid"]);
	$email = fetchinfo("email","users","steamid",$_SESSION["steamid"]);
	$mytrade=mysql_escape_string($mytrade);
	$email=mysql_escape_string($email);
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
        
        <link href="assets/plugins/sweetalert/dist/sweetalert.css" rel="stylesheet" type="text/css">

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

        <style>
        @import url(https://fonts.googleapis.com/css?family=Lato);
          @import url(https://fonts.googleapis.com/css?family=Oswald);
          @import url(https://fonts.googleapis.com/css?family=Montserrat);

          @font-face {
              font-family: digital;
              src: url(digital.ttf);
          }

          .text-red{color:red}a.text-red:focus,a.text-red:hover{color:red}
          .text-green{color:green}a.text-green:focus,a.text-green:hover{color:green}

          .lato{
            font-family: 'Lato', sans-serif;
          }

          .oz{
            font-family: 'Oswald', sans-serif;
          }

          .mst{
            font-family: 'Montserrat', sans-serif;
          }
          .highlight {
              color: £FFF;
              background-color: #C00;
                -webkit-opacity: 0.45;
            -moz-opacity: 0.45;
            opacity: 0.45;
          -webkit-transition: all 0.4s ease;
            -moz-transition: all 0.4s ease;
            -ms-transition: all 0.4s ease;
            -o-transition: all 0.4s ease;
            transition: all 0.4s ease;
          }
          .youwin{font-size:15px;   background-color: #8FBC8F;  -webkit-opacity: 1;
            -moz-opacity: 1;
            opacity: 1;
          }
        </style>

    </head>


    <body class="fixed-left" onload="setInterval('chat.update()', 1000)">
	<?php echo $cbanstring; ?>

	<span class="msg"></span>
        <!-- Begin page -->
        <div id="wrapper">

			<!-- Top Bar Start -->
           <?php include('topmenu.php'); ?>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <?php include('leftmenu.php'); ?>
            <!-- Left Sidebar End -->




            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content" style="text-align:center;">
                    <div class="container">
                    	<div class="row">
		                    <div class="col-lg-12">
		                    	<div class="widget-bg-color-icon card-box">
		                    		<h1>Trade URL</h1>
									<p>
									<a href="http://steamcommunity.com/id/gergo4961/tradeoffers/privacy#trade_offer_access_url" target="_BLANK">You can find your Trade URL here!</a>
									<br>
									<a href="http://steamcommunity.com/id/hello/edit/settings" target="_BLANK">Don't forget to make your Inventory & Profile public!</a>
									</p>
		                    		<form method="POST" class="form-horizontal group-border-dashed" action="updatelink.php" novalidate="">
												<div class="form-group">
													<label class="col-sm-3 control-label"></label>
													<div class="col-sm-6">
														<input type="text" name="link" id="link" class="form-control" required="" parsley-type="text" value='<?php echo $mytrade; ?>' placeholder="Enter a valid Trade URL" data-parsley-id="40">
													</div>
												</div>
												<div class="form-group">
													<div class="col-sm-12">
														<button type="submit" class="btn btn-primary">
															Submit
														</button>
													</div>
												</div>
											</form>
											<br>
											<br>
											<p><font color="red">If your Trade URL is incorrect we can not help you with your missing items, so please double check the url!</font></p>
		                  		</div>
		                  	</div>
		                </div>
		                <div class="row">
		                    <div class="col-lg-12">
		                    	<div class="widget-bg-color-icon card-box">
		                    		<h1>Email</h1>
									<p>You'll only receive site updates, no SPAM!</p>
		                    		<form method="POST" class="form-horizontal group-border-dashed" action="updateemail.php" novalidate="">
												<div class="form-group">
	                                                <label class="col-sm-3 control-label" for="example-email"></label>
	                                                <div class="col-sm-6">
	                                                    <input type="email" name="link" id="link" name="example-email" class="form-control" value='<?php echo $email; ?>' placeholder="Enter a valid Email adress">
	                                                </div>
	                                            </div>
												<div class="form-group">
													<div class="col-sm-12">
														<button type="submit" class="btn btn-primary">
															Submit
														</button>
													</div>
												</div>
											</form>
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
                      <a href="?login" class="btn btn-success">
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



        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
                <script src="assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
        <script src="assets/pages/jquery.sweet-alert.init.js"></script>

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