<?php
include ('link.php');
include ('core.php');
require_once('steamauth/steamauth.php');
@include_once('steamauth/userInfo.php');
$page="roulette";
include('user-information.php');
 ?>
<!DOCTYPE html>
<html>
    <head>
		<link href="roulette-content/css/bootstrap.min.new.css" rel="stylesheet">
		<link href="roulette-content/css/font-awesome.min.css" rel="stylesheet">
		
		<link href="roulette-content/css/mineNew.css?v=5" rel="stylesheet">
		<script src="https://cdn.socket.io/socket.io-1.4.5.js"></script>
		<script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
		<script src="http://malsup.github.com/jquery.form.js"></script> 
		
		<script src="roulette-content/js/jquery-1.11.1.min.js"></script>
		<script src="roulette-content/js/jquery.cookie.js"></script>
		<script src="roulette-content/js/socket.io-1.4.5.js"></script>
		
		
		<script src="roulette-content/js/jquery.dataTables.min.js"></script>
		
		<script src="roulette-content/js/tinysort.js"></script>
		<script src="roulette-content/js/expanding.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.js"></script> 
		<style>
		.navbar{
			margin-bottom: 0px;
		}
		.progress-bar{
			transition:         none !important;
			-webkit-transition: none !important;
			-moz-transition:    none !important;
			-o-transition:      none !important;
		}
		#case {

			max-width: 1050px;
			height: 69px;
			background-image: url("roulette-content/img/cases.png");
			background-repeat: no-repeat;
			background-position: 0px 0px;
			position: relative;
			margin:0px auto;

		}	
		</style>
		<script type="text/javascript" src="roulette-content/js/new.js?v=<?=time()?>"></script>
		
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

		<script src="js/script.js"></script>

        <script src="assets/plugins/morris/morris.min.js"></script>
        <script src="assets/plugins/raphael/raphael-min.js"></script>

        <script src="assets/plugins/jquery-knob/jquery.knob.js"></script>

        <script src="assets/pages/jquery.dashboard.js"></script>

        <script src="assets/js/jquery.core.js"></script>
        <script src="assets/js/jquery.app.js"></script>
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
              <script>
                $(".right-bar-toggle").click(function(){
                  $(".wrapper").toggleClass("right-bar-enabled");
                  console.log($(".right-bar").css("right") == "0px");
                  if($(".right-bar").css("right") != "0px")
                    $(".right-bar").css("right","0");
                  else
                    $(".right-bar").css("right","-266px");
                });
				var hash='<?php echo $as; ?>';
              </script>

            <!-- ========== Left Sidebar Start ========== -->
            <?php include 'leftmenu.php';?>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">

			<!-- Start content -->
           <div class="content" style="text-align:center;">
<br>
			<div class="panel panel-border panel-danger">
				<div class="panel-heading">
					<h3 class="panel-title">Minimum bet: 25 Credits &emsp; Maximum bet: 1000 Credits</h3>
				</div>
				<div class="panel-body">
					<p>
						<font size="1">*You may randomly encounter visual bugs, stuck timers, just refresh the page. Credits are never lost and winners are always awarded.*</font>
					</p>
				</div>
			</div>

         <div class="portlet-body tabs-below">
          
		  <div class="well text-center" style="margin-bottom:10px;margin-top:25px; padding: 20px;">	
			<div class="progress text-center" style="height:50px;margin-bottom:5px;margin-top:5px">
				<span id="banner"></span>
				<div class="progress-bar progress-bar-danger" id="counter"></div>
			</div>

		<div id="case" style="margin-bottom: 5px; background-position: -710.5px 0px;"><div id="pointer"></div></div>
		<div class="well text-center" style="padding:5px;margin-bottom:5px"><div id="past"></div>
			<div style="margin: 20px 0px;">
			</div>
			<div class="form-group">
				<div class="input-btn bet-buttons">
					<span style="font-size: 13px;background-color: #b04a43; padding: 10px 20px; margin-right: 5px; color: #fff; border-radius: 10px;"> 
						<span>Balance: </span>
						<span id="dongers"></span>
						<span id="balance"><?php echo $mycredits; ?></span> <i style="cursor:pointer; margin-left: 5px;" class="fa fa-refresh noselect" id="getbal"></i>
					</span>
					<input type="text" class="form-control input-lg" placeholder="Bet amount..." id="betAmount">
					<button type="button" class="btn btn-danger betshort" data-action="clear">Clear</button>
					<button type="button" class="btn btn-inverse betshort" data-action="10">+10</button>
					<button type="button" class="btn btn-inverse betshort" data-action="50">+50</button>
					<button type="button" class="btn btn-inverse betshort" data-action="100">+100</button>
					<button type="button" class="btn btn-inverse betshort" data-action="1000">+1000</button>
					<button type="button" class="btn btn-inverse betshort" data-action="half">1/2</button>
					<button type="button" class="btn btn-inverse betshort" data-action="double">x2</button>
					<button type="button" class="btn btn-danger betshort" data-action="max">Max</button>
				</div>
			</div>
			
		</div>
			</div>
			<div class="row text-center">
				<div class="col-xs-4 betBlock" style="padding-right:0px">
					<div class="panel panel-default bet-panel" id="panel11-7-b">
						<div class="panel-heading" style="padding: 3px;">
							<button class="btn btn-danger btn-lg  btn-block betButton" data-lower="1" data-upper="7">1 - 7</button>
						</div>
					</div>
					<div class="panel panel-default bet-panel" id="panel1-7-m" style="width: 220px; margin: auto; margin-bottom: 10px;">
						<div class="panel-body" style="padding:0px">
							<div class="my-row">
								<div class="text-center"><span class="mytotal">0</span></div>
							</div>
						</div>
					</div>
					<div class="panel panel-default bet-panel" id="panel1-7-t">
						<div class="panel-body" style="padding:0px" id="panel1-7">
							<div class="total-row">
								<div class="text-center">Total bet: <span class="total">0</span></div>
							</div>
							<ul class="list-group betlist"></ul>
						</div>
					</div>
				</div>
				
				<div class="col-xs-4 betBlock">
					<div class="panel panel-default bet-panel" id="panel0-0-b">
						<div class="panel-heading" style="padding: 3px;">
							<button class="btn btn-success btn-lg btn-block betButton" data-lower="0" data-upper="0">0</button>
						</div>
					</div>
					<div class="panel panel-default bet-panel" id="panel0-0-m" style="width: 220px; margin: auto; margin-bottom: 10px;">
						<div class="panel-body" style="padding:0px">
							<div class="my-row">
								<div class="text-center"><span class="mytotal">0</span></div>
							</div>
						</div>
					</div>
					<div class="panel panel-default bet-panel" id="panel0-0-t">
						<div class="panel-body" style="padding:0px" id="panel0-0">
							<div class="total-row">
								<div class="text-center">Total bet: <span class="total">0</span></div>
							</div>
							<ul class="list-group betlist">
							</ul>
						</div>
					</div>
				</div>
				
				<div class="col-xs-4 betBlock" style="padding-left:0px">
					<div class="panel panel-default bet-panel" id="panel8-14-b">
						<div class="panel-heading" style="padding: 3px;">
							<button class="btn btn-inverse btn-lg  btn-block betButton" data-lower="8" data-upper="14">8 - 14</button>
						</div>
					</div>
					<div class="panel panel-default bet-panel" id="panel8-14-m" style="width: 220px; margin: auto; margin-bottom: 10px;">
						<div class="panel-body" style="padding:0px">
							<div class="my-row">
								<div class="text-center"><span class="mytotal">0</span></div>
							</div>
						</div>
					</div>
					<div class="panel panel-default bet-panel" id="panel8-14-t">
						<div class="panel-body" style="padding:0px" id="panel8-14">
							<div class="total-row">
								<div class="text-center">Total bet: <span class="total">0</span></div>
							</div>
							<ul class="list-group betlist"></ul>
						</div>
					</div>
				</div>
			</div>

					
						
                        </div>
                    </div>
                </div> <!-- container -->
<br><br><br>
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