<div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                        	<li class="text-muted menu-title">Navigation</li>
                            <li class="has_sub">
                                <a href="#" class="waves-effect <?php if($page=="j1"){echo'subdrop';} ?>"><i class="ti-home"></i><span>Jackpot </span> </a>
								<ul class="list-unstyled" <?php if($page=="j1"){echo'style="display: block;"';} ?>>
									<li><a href="index.php">Play!</a></li>
                                    <li><a href="history1.php">History</a></li>
                                    <li><a href="topusers1.php">Top Users</a></li>
                                </ul>
                            </li>
							
							<li class="">
                                <a href="rules.php" class="waves-effect waves-light <?php if($page=="rls"){echo'active';} ?>"><i class="fa fa-book"></i><span>Rules </span> </a>
                            </li>
							
                            <li class="">
                                <a href="tos.php" class="waves-effect waves-light <?php if($page=="tos"){echo'active';} ?>"><i class="fa fa-balance-scale"></i><span>Terms of Service </span> </a>
                            </li>

                            <li class="">
                                <a href="support.php" class="waves-effect waves-light <?php if($page=="supp"){echo'active';} ?>"><i class="fa fa-question-circle"></i><span>Support </span></a>
                            </li>
                            <?php
                            if($admin != 0)
							{
								echo'
								<li class="text-muted menu-title admin-content">Admin Panel</li>

								<li class="has_sub admin-content">
                                <a href="#" class="waves-effect '; if($page=="ad"){echo'subdrop';} echo'"><i class="ti-user"></i><span>Admin</span> </a>
                                <ul class="list-unstyled '; if($page=="ad"){echo'"style="display: block;"';} echo'" style="">
									<li><a href="apu.php">Premium users</a></li>
									<li><a href="abu.php">Banned users</a></li>
									<li><a href="acu.php">ChatBanned users</a></li>
									<li><a href="au.php">Users</a></li>
									<li><a href="ah1.php">History</a></li>
                                </ul>
								</li>
								';
                            
                            }
                            ?>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <script>
                $("li.has_sub").click(function(){
                    $(this).children("a").toggleClass("subdrop");
                    $(this).children("ul").toggle();
                });
            </script>