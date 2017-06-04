 <div class="topbar">
                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="index.php" class="logo"><i class="glyphicon glyphicon-usd"></i><span><?php echo $title ?></span></a>
                    </div>

                </div>
                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
						
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>


                            <ul class="nav navbar-nav navbar-right pull-right">
								<?php
								
								echo $sgt.$tt.$fbt.$rdt;
								
								?>
								
                                <li class="hidden-xs">
                                    <a href="#" class="right-bar-toggle waves-effect"><?php if($cbanned==0) {echo'<i class="fa fa-comments"></i></a>';}else{echo'<i class="fa fa-microphone-slash"></i>';} ?>
                                </li>
								<?php
								if(isset($_SESSION["steamid"]))
								{
									$name=$steamprofile['personaname'];
									$name=secureoutput($name);
									echo'
									<li class="hidden-xs" style="padding-top:"><a href="http://skinsbucket.com" target="_SB"><font color="#02ABE3"><b>Deposit & Withdraw</b></font></a></li>
									<li class="hidden-xs" style="padding-top:20px"><font color="#22B569"><b><span class="mycredits">'.$mycredits.'</span> Credits</b></font></li>
									<li class="dropdown">
										<a href="" class="dropdown-toggle profile waves-effect" data-toggle="dropdown" aria-expanded=""><img src="'.$steamprofile['avatarfull'].'" alt="user-img" class="img-circle"> </a>
										<ul class="dropdown-menu">
											<li class="notifi-title">'.$name.'</li>
											<li><a href="profile.php"><i class="ti-user m-r-5"></i> Profile</a></li>
											<li><a href="usersettings.php"><i class="ti-settings m-r-5"></i> Settings</a></li>
											<li><a href="userhistory.php"><i class="ti-book m-r-5"></i> History</a></li>
											<li><a href="steamauth/logout.php"><i class="ti-power-off m-r-5"></i> Logout</a></li>
										</ul>
									</li>';
								}
								else
								{
									echo '<li class="hidden-xs" style="padding-top:"><a href="" data-toggle="modal" data-target="#loginmodal"><img src="http://cdn.steamcommunity.com/public/images/signinthroughsteam/sits_small.png"></a></li>';
								}
								?>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>

			<script src="assets/js/jquery.app.js"></script>