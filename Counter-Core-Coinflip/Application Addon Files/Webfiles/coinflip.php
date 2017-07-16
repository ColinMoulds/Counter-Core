<?php
include ('link.php');
include ('core.php');
require_once('steamauth/steamauth.php');
@include_once('steamauth/userInfo.php');
$page="coin";
include('user-information.php');
 ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="CsgoDank Counter Strike Global Offensive ">
        <meta name="author" content="csgodank.net">

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
	<script src="js/coinflip.js"></script>

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

<style>

tr:hover {background-color: #f5f5f5}
tr.cent {
text-align: center;
vertical-align: middle;
}
.cc-selector input{
margin:0;padding:0;
-webkit-appearance:none;
-moz-appearance:none;
appearance:none;
}

.cc-selector-2 input{
position:absolute;
z-index:999;
}

.C{background-image:url(img/fej.png);}
.CT{background-image:url(img/iras.png);}

.cc-selector-2 input:active +.coin-cc, .cc-selector input:active +.coin-cc{opacity: .9;}
.cc-selector-2 input:checked +.coin-cc, .cc-selector input:checked +.coin-cc{
-webkit-filter: none;
-moz-filter: none;
filter: none;
}
.coin-cc{
cursor:pointer;
background-size:contain;
background-repeat:no-repeat;
display:inline-block;
width:100px;height:70px;
-webkit-transition: all 100ms ease-in;
-moz-transition: all 100ms ease-in;
transition: all 100ms ease-in;
-webkit-filter: brightness(1.8) grayscale(1) opacity(.7);
-moz-filter: brightness(1.8) grayscale(1) opacity(.7);
filter: brightness(1.8) grayscale(1) opacity(.7);
}
.coin-cc:hover{
-webkit-filter: brightness(1.2) grayscale(.5) opacity(.9);
-moz-filter: brightness(1.2) grayscale(.5) opacity(.9);
filter: brightness(1.2) grayscale(.5) opacity(.9);
}




</style>

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
                  <div class="col-md-12 col-lg-12">
                        <div class="widget-bg-color-icon card-box">
                          <p style="font-size:20px;">
                <div class="container">
                </div>

              <center>
                                           <div class="col-md-2 col-md-offset-5">

            <form method="POST" class="form-horizontal group-border-dashed" action="updatehost.php" novalidate="">

                <!--- Radio buttons --->
                <br>  <br>
                <div class="cc-selector">
                  <input checked="checked" id="CT" type="radio" name="Side" value="CT" />
                  <label class="coin-cc CT" for="CT"></label>
                  <input id="T" type="radio" name="Side" value="T" />
                  <label class="coin-cc C" for="T"></label>
                </div>
                <br>
                <!--- Inputfield --->
                <input type="number" name="coincredits" id="coincredits" class="form-control"  required="" parsley-type="text" placeholder="Credits" data-parsley-id="40">
                <p>min 10 credits</p>

                    <br>

                    <?php

                        if(isset($_SESSION['steamid']))

                        {
                          echo'
                          <button type="button" onClick="host()" class="btn btn-primary btn-lg btn-block">Host A lobby</div></button>
                            <div>
                          ';
                        }
                        else
                        {
                          echo'
                            <a href="?login">
                            <button type="button" class="btn btn-lg btn-inverse btn-custom waves-effect waves-light">Log In before Hosting</button>
                            </a>
                          ';
                        }

                        ?>
                 <!-- </form> --->

                </div>

              <br>
              <br>
              <?php if($_SESSION['steamid'] !=""){ ?>
                 <script>
               function host() {
               var coincredits = document.getElementById("coincredits").value;
               var Side =  $('input[name="Side"]:checked').val();
               $.ajax({
                 type:"post",
                 url:"updatehost.php",
                 data: {coincredits: coincredits , Side: Side},
                 success: function(data){
                 }
               });
               refreshCredits();

               }
               </script>
               <?php } ?>

              <script>

             window.onload = function onLoad() {
                setInterval("updatetable()",1000);
              };

              function updatetable() {
                $.ajax({
                  type: "GET",
                  url: "coinfliptable.php",
                  success: function(result){
                      $("span.cointable").html(result);
                  }
                });
              }
              </script>
								<span class="cointable">
							<?php include('coinfliptable.php'); ?>
								</span>
                                                </tbody>
                                            </table>
              </p>
              <br>


                        </div>
                    </div>

                </div> <!-- container -->

                </div> <!-- content -->
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
