<?php
include ('link.php');
include ('core.php');
$page="j1";
include('user-information.php');
$rs0 = mysql_query("SELECT id FROM `jackpotgames` ORDER BY ID DESC");						
$row = mysql_fetch_row($rs0);
$gameid=round($row[0]);
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
        <script src="assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
		<script src="js/script.js"></script>
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<link href="css/ranim.css" rel="stylesheet" type="text/css" />

    </head>


    <body class="fixed-left">
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
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
									<div class="text-center">
                                        <h3 class="text-dark"><b>Credit Jackpot</b></h3>
										<?php 
										
										echo'<p class="text-muted"<u>Min/Max bet</u>: <b>'.$minbet.' / '.$maxbet.' Cr</b> &ensp; <u>Snipe Timer</u>: <b>'.$snipetimer.' s</b></p>';
										
										?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>


                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-warning pull-left">
                                        <i class="md md-people text-white"></i>
                                    </div>
                                    <div class="text-right">
									<?php
									
									 $result = mysql_query("SELECT id FROM jackpotgames WHERE `starttime` > ".(time()-86400));
									 $result2 = mysql_query("SELECT id FROM users WHERE `lastseen` > ".(time()-86400));
									 $rows=mysql_num_rows($result2);
									  
									?>
                                        <h3 class="text-dark"><b class="counter"><?php echo $rows; ?></b></h3>
                                        <p class="text-muted">Players Today</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
							
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-info pull-left">
                                        <i class="md md-event text-white"></i>
                                    </div>
                                    <div class="text-right">
									<?php
									 $result2 = mysql_query("SELECT id FROM users WHERE `lastseen` > ".(time()-86400));
									?>
                                        <h3 class="text-dark"><b class="counter"><?php echo mysql_num_rows($result); ?></b></h3>
                                        <p class="text-muted">Games Today</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-success pull-left">
                                        <i class="md md-attach-money text-white"></i>
                                    </div>
                                    <div class="text-right">
									<?php
										$result = mysql_query("SELECT * FROM jackpotgames ORDER BY value*1 DESC LIMIT 1");
										$row = mysql_fetch_assoc($result);
										$maxcost =  $row["value"];
										$maxcost=round($maxcost,2);
									?>
                                        <h3 class="text-dark"><b class="counter"><?php echo $maxcost; ?></b> Credits</h3>
                                        <p class="text-muted">Biggest win</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
							
                        </div>
            <div class="row">
			<div class="col-md-3">
			</div>
              <div class="col-md-3 ">
                                <div class="card-box widget-box-1 bg-white" style="height:200px;">
                                  <h4 class="text-dark">Time Left</h4>
                                  <h2 class="text-primary text-center"><span class="ticker" id="ticker"><?php include('tl1.php');?></span></h2>
                                  <p class="text-muted"><font size="3">Pot: </font><font color="#598749">
								<br>
								  <span class="pot1 jpot cvalue"><?php include('pot1.php');?></span></font>
								  </p>
                                </div>
                            </div>
			<div class="col-md-3 ">
                                <div class="card-box widget-box-1 bg-white"  style="height:200px;">
								<?php
								if(isset($_SESSION['steamid']))
								{
									echo'
									  <h4 class="text-dark">Deposit Credits</h4>
									  <br>
									  <input type="number" name="credits" id="credits" class="form-control" required="" parsley-type="text" placeholder="Credits" data-parsley-id="40">
									  <br>
									  <br>
									  <button id="button_joinjp" type="button" class="btn btn-danger waves-effect waves-dark">Deposit Credits</button>
									  ';
								}
								else
								{
									echo'
									<h4 class="text-dark">Deposit Credits</h4>
									  <br>
									  <input disabled type="number" name="" id="" class="form-control" required="" parsley-type="text" placeholder="Credits" data-parsley-id="40">
									  <br>
									  <br>
									  <a href="" data-toggle="modal" data-target="#loginmodal"><img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_small.png"></a>';	
								}
								?>
                                </div>
                            </div>
						</div>

					<div class="hhdgfbd"></div>
					<div class="kjmhgd"></div>
						
                    <div class="row">
                    <div class="col-lg-12">
                    <div class="widget-bg-color-icon card-box">
					
					<h3>Game #<span class="gnum"><?php include('updategamenumber.php'); ?></span></h3>
					<div class="t1 centered">
					<?php include('table1.php'); ?>
					</div>
					
                    <br>
					<br>
					<br>
					
					
                  </div>

                  </div>
                    <br>  
                          
                    </div>
                    <div class="row">
                    <div class="col-lg-12">
                    <div class="widget-bg-color-icon card-box">
					<div class="t2 centered">
					<span class="lastwinner"><?php include('previouswinner.php'); ?></span>
					</div>
					
					<br>
					
					
                  </div>

                  </div>
                    <br>  
                          
                    </div>
					<!-- container -->

                </div> <!-- content -->

                <?php include('footer.php'); ?>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->


            <!-- Right Sidebar -->
            <div class="side-bar right-bar nicescroll" style="overflow: visible">
            <script>
			var steamid = "<?php echo $_SESSION['steamid'] ?>";
			var as = "<?php echo $as ?>";
			bonus='';
			function tick( )
			{
				if(endTime==-1)
				{
					document.getElementById("ticker").innerHTML = "02:00";
				}
				var secs = endTime - curTime;
				var days = Math.floor( secs / 86400 );
				secs %= 86400;
				var hrs = Math.floor( secs/ 3600 );
				secs %= 3600;
				var mins = Math.floor( secs / 60 );
				secs %= 60;
				if(mins==2 && endTime!=-1)
				{
					++curTime;
					document.getElementById("ticker").innerHTML = "02:00";
				}
				if(secs>-1 && mins!=2 && endTime!=-1)
				{
					if(secs<10)
					{

						bonus="0";
					}
					else
					{
						bonus='';
					}
					document.getElementById("ticker").innerHTML = "0"+mins+":"+bonus+secs;
					++curTime;
				}
				if(secs<0 && endTime!=-1)
				{
					document.getElementById("ticker").innerHTML = "02:00";
				}
			}
			clearInterval(timer);
			var timer = setInterval(tick,1000);
			tick();
			
			$( "#button_joinjp" ).click(function()
			{
				var credits = $("#credits").val();
				if(credits>24&&steamid)
				{
					$("#credits").val('');
					socket.emit('processdeposit',{ steamid: steamid, amount: credits, secret: as });
				}
			});
	  var room=0;
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
                    <div class="row userarea slimScrollDiv" style="height:78%; padding: 0 5%;">
                          <div id="chat-wrap" class="slimScrollleft">
                            <?php include "chat/chat.php";?>
							<span class="newmessages"></span>
                            </div>
                            <div class="slimScrollBar" style="width: 5px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 737.093px; visibility: visible; background: rgb(220, 220, 220);"></div>
                        <div class="slimScrollRail" style="width: 5px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div>

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
                      <button onClick="return false;" id="sendchat" name="sendchat" class="btn btn-success">
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