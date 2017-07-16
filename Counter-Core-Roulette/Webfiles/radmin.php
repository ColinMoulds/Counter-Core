<!DOCTYPE html>
<?php
include ('link.php');
include ('core.php');
require_once('steamauth/steamauth.php');
@include_once('steamauth/userInfo.php');
$page="radmin";
include('user-information.php');
if($admin==0)
{
	die();
}

 ?>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Site description">
        <meta name="author" content="Website.com">

        <link rel="shortcut icon" href="defico.png">

        <title><?php echo $title; ?></title>
		
		<!-- DataTables -->
        <link href="assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/buttons.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/fixedHeader.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/responsive.bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="assets/plugins/datatables/scroller.bootstrap.min.css" rel="stylesheet" type="text/css" />


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
		<style>
		.ball{
		color:white;
		cursor:default;
		border-radius: 45px;
		border: 1px solid transparent;
		width:45px;
		height:45px;
		background-color: #000;
		font-size: 17px;
		line-height: 45px;
		padding: 0;
		text-align: center;
		display:inline-block;
		margin:1px;
	}
	.ball-1{
		background-color:#b04a43;
		border: 0px !important;
	}
	.ball-0{
		background-color: #6fb26b;
		border: 0px !important;
	}			
	.ball-8{
		background: #454545;
		border: 0px !important;
	}
	table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
		</style>
        <link rel="stylesheet" href="chat/chat.css">
        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

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
					<?php
					if(isset($_POST['submit']))
					{
						$rs = mysql_query("SELECT SUM(profit) as profit FROM `rolls` WHERE `claimed`='0'");
						if(mysql_num_rows($rs) != 0)
						{
							$row = mysql_fetch_array($rs);
							$profit=0;
							$profit=$row['profit'];
							if(!$profit)
							{
								echo"<center><font color='red'>Can't claim 0 Credits!</font></center><br>";
							}
							
							if($profit<=-1 && $profit)
							{
								echo"<center><font color='red'>Can't claim $profit Credits!</font></center><br>";
							}
							if($profit>=1 && $profit)
							{
								if($adminid)
								{
									echo"<center><font color='green'><b>$profit</b> Credits were given to the Administrator!</font></center><br>";
									mysql_query("UPDATE `users` SET `credits`=credits+$profit WHERE `steamid`='$adminid'");
									mysql_query("UPDATE `rolls` SET `claimed`=1");
								}
								else
								{
									echo"<center><font color='red'>Set up an <b>\$adminid</b> in your core.php!</font></center><br>";	
								}
							}
						}
					}
					?>
                    <div class="container">
						<div class="row">
                            <div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
									<div class="text-center">
                                        <h3 class="text-dark"><b>Current Unclaimed Profit</b></h3>
										<?php
										
										$rs = mysql_query("SELECT SUM(profit) as profit FROM `rolls` WHERE `claimed`='0'");
										if(mysql_num_rows($rs) != 0)
										{
											$row = mysql_fetch_array($rs);
											$profit=0;
											$profit=$row['profit'];
											$claim=0;
											if(!$profit)
											{
												echo '<p><font color="red">0 Credits</font></p>';
											}
											
											if($profit<=-1 && $profit)
											{
												echo '<p><font color="red">'.$profit.' Credits</font></p>';
											}
											if($profit>=1 && $profit)
											{
												echo '<p><font color="green">'.$profit.' Credits</font></p>';
												$cprofit=$profit;
												$claim=1;
											}
										}
										
										?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
							<div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
									<div class="text-center">
                                        <h3 class="text-dark"><b>Overall Claimed Profit</b></h3>
										<?php 
									
										$rs = mysql_query("SELECT SUM(profit) as profit FROM `rolls` WHERE `claimed`='1'");
										if(mysql_num_rows($rs) != 0)
										{
											$row = mysql_fetch_array($rs);
											$profit=0;
											$profit=$row['profit'];
											if(!$profit)
											{
												echo '<p><font color="red">0 Credits</font></p>';
											}
											
											if($profit<=-1 && $profit)
											{
												echo '<p><font color="red">'.$profit.' Credits</font></p>';
											}
											if($profit>=1 && $profit)
											{
												echo '<p><font color="green">'.$profit.' Credits</font></p>';
											}
											
										}
										
										?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
							<div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
									<div class="text-center">
                                        <h3 class="text-dark"><b>24h Profit</b></h3>
										<?php 
										$past24=time();
										$past24=$past24-86400;
										$rs = mysql_query("SELECT SUM(profit) as profit FROM `rolls` WHERE `time`>='$past24'");
										if(mysql_num_rows($rs) != 0)
										{
											$row = mysql_fetch_array($rs);
											$profit=0;
											$profit=$row['profit'];
											if(!$profit)
											{
												echo '<p><font color="red">0 Credits</font></p>';
											}
											
											if($profit<=-1 && $profit)
											{
												echo '<p><font color="red">'.$profit.' Credits</font></p>';
											}
											if($profit>=1 && $profit)
											{
												echo '<p><font color="green">'.$profit.' Credits</font></p>';
											}
											
										}
										
										?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
							<div class="col-md-6 col-lg-3">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
									<div class="text-center">
                                        <h3 class="text-dark"><b>24h Bets</b></h3>
										<?php 
										$past24=time();
										$past24=$past24-86400;
										$rs = mysql_query("SELECT count(profit) as bets FROM `rolls` WHERE `time`>='$past24' AND `won`!=0 OR `time`>='$past24' AND `lost`!=0");
										if(mysql_num_rows($rs) != 0)
										{
											$row = mysql_fetch_array($rs);
											$bets=0;
											$bets=$row['bets'];
											if(!$bets)
											{
												echo '<p><font color="red">0 Bets</font></p>';
											}
											
											if($bets<=-1 && $bets)
											{
												echo '<p><font color="red">'.$bets.' Bets</font></p>';
											}
											if($bets>=1 && $bets)
											{
												echo '<p><font color="green">'.$bets.' Bets</font></p>';
											}
											
										}
										
										?>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
							
                        </div>
						<?php
						if($claim==1 && $cprofit)
						{
							echo'
							<div class="col-md-12">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
									<div class="text-center">
                                        <h3 class="text-dark"><b>Claim your Profit of '.$cprofit.' Credits!</b></h3>
										<br>
										<form method="post" class="form-horizontal group-border-dashed" novalidate="">
										<button name="submit" id="submit" type="submit" class="btn btn-success waves-effect waves-dark">Click to Claim</button>
										</form>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
							';
						}

						?>
						<div class="col-md-12">
							<div class="widget-bg-color-icon card-box fadeInDown animated">
								<h3>Previous 50 Rolls & Profit</h3>
								<br>
								<?php
								$rs = mysql_query("SELECT * FROM `rolls` WHERE `roll`!='-1' AND `won`!=0 OR `roll`!='-1' AND `lost`!=0 ORDER BY `id` DESC LIMIT 50");
								echo '<table>
									  <tr>
										<th>Roll ID</th>
										<th>Roll</th>
										<th>Time</th>
										<th>Users Won</th>
										<th>Users Lost</th>
										<th>Your Profit</th>
									  </tr>
								';
								while($row = mysql_fetch_array($rs))
								{
									$rid=$row['id'];
									$rtime=$row['time'];
									$rtime=date('Y-m-d H:i', $rtime);
									$rwon=$row['won'];
									$rlost=$row['lost'];
									$rprofit=$row['profit'];
									$roll=$row['roll'];
									echo"
										<tr>
											<td>$rid</td>";
											if($roll==0)
											{
												echo"<td><div class='ball ball-0'>$roll</div> Rolled: $roll</td>";	
											}
											else if($roll<=7)
											{
												echo"<td><div class='ball ball-1'>$roll</div> Rolled: $roll</td>";
											}
											else
											{
												echo"<td><div class='ball ball-8'>$roll</div> Rolled: $roll</td>";
											}
										echo"
											<td>$rtime</td>
											<td>$rwon Credits</td>
											<td>$rlost Credits</td>
											<td><b>$rprofit Credits</b></td>
										</tr>
											";
										
								}
								echo '</table>';
								?>
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
		
		        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap.js"></script>

        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>

        <script src="assets/plugins/datatables/dataTables.fixedHeader.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.keyTable.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.scroller.min.js"></script>

        <script src="assets/pages/datatables.init.js"></script>
		




        <script type="text/javascript">
            $(document).ready(function() {
                $('#datatable').dataTable();
                $('#datatable-keytable').DataTable( { keys: true } );
                $('#datatable-responsive').DataTable();
                $('#datatable-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
                var table = $('#datatable-fixed-header').DataTable( { fixedHeader: true } );
            } );
            TableManageButtons.init();

        </script>




    </body>
</html>