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
	$steamid=$_SESSION['steamid'];
	$time = time();
    mysql_query("UPDATE users SET lastseen=".$time." WHERE steamid=".$_SESSION['steamid']."");
	$mycredits=fetchinfo("credits","users","steamid",$_SESSION["steamid"]);
	$premium=fetchinfo("ban","users","steamid",$_SESSION["steamid"]);
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
        <script src="chat/chat.js"></script>
        <link rel="stylesheet" href="chat/chat.css">
		<script src="js/script.js"></script>
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
                    <div class="container">
                    	<div class="row">
		                    <div class="col-lg-12">
		                    	<div class="widget-bg-color-icon card-box">
		                    		<h1>User History</h1>
									<br>
									<?php
									
								
									
									echo'
									
									<table id="datatable" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
												<th>ID</th>
                                                <th>Title</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>


                                        <tbody>';
										$rs = mysql_query("SELECT * FROM `messages` WHERE `userid`='$steamid'");
										while($row = mysql_fetch_array($rs))
										{
											$type=$row['type'];
											if($type=='error')
											{
												$type='danger';
											}
											$mtitle=$row['title'];
											if($mtitle)
											{
												$mtitle=$row['title'];
											}
											else
											{
												$mtitle='No title';
											}
											$msg=$row['msg'];
											$msg=strip_tags($msg);
											echo'
											<tr class="'.$type.'">
												<td>'.$row['ID'].'</td>
												<td>'.$mtitle.'</td>
												<td>'.$msg.'</td>
											</tr>
											';
											
										
										}
										echo'
                                        </tbody>
                                    </table>
									
									
									';
									?>
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
                var chat =  new Chat();
                $(function() {
                  chat.getState(); 
                  // watch textarea for key presses
                    $("#sendie").keydown(function(event) {  
                      var key = event.which;  
                      //all keys including return.  
                      if (key >= 33) {
                        var maxLength = 57;  
                        var length = this.value.length;  
                        // don't allow new content if length is maxed out
                        if (length >= maxLength) {  
                          event.preventDefault();  
                        }  
                      }
                    });
                    // watch textarea for release of key press
                    $('#sendie').keyup(function(e) {       
                      if (e.keyCode == 13) { 
                        var text = $(this).val();
                        var maxLength = $(this).attr("maxlength");  
                        var length = text.length; 
                        // send 
                        if (length <= maxLength + 1) { 
                          chat.send(text, name, ava,id,admin,color);  
                          $(this).val("");
                        } else {
                          $(this).val(text.substring(0, maxLength));
                        } 
                      }
                    });
                    
                    // watch textarea for release of key press
                    $("#sendchat").click( function() {    
                        var text = $('#sendie').val();
                        var maxLength = $('#sendie').attr("maxlength");  
                        var length = text.length; 
                        
                        if (length >= maxLength) {  
                          event.preventDefault();  
                        }  
                        // send 
                        else if (length <= maxLength + 1) { 
                          chat.send(text, name, ava,id,admin,color);  
                          $('#sendie').val("");
                        } else {
                          $('#sendie').val(text.substring(0, maxLength));
                        } 
                    });
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

<script type="text/javascript">
            $(document).ready(function() {
                $('#datatable2').dataTable();
                $('#datatable2-keytable').DataTable( { keys: true } );
                $('#datatable2-responsive').DataTable();
                $('#datatable2-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
                var table = $('#datatable2-fixed-header').DataTable( { fixedHeader: true } );
            } );
            TableManageButtons.init();

        </script>
		
		<script type="text/javascript">
            $(document).ready(function() {
                $('#datatable3').dataTable();
                $('#datatable3-keytable').DataTable( { keys: true } );
                $('#datatable3-responsive').DataTable();
                $('#datatable3-scroller').DataTable( { ajax: "assets/plugins/datatables/json/scroller-demo.json", deferRender: true, scrollY: 380, scrollCollapse: true, scroller: true } );
                var table = $('#datatable3-fixed-header').DataTable( { fixedHeader: true } );
            } );
            TableManageButtons.init();

        </script>


    </body>
</html>