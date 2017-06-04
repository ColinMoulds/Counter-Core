<?php
$adminid=''; // The owner's Steam ID, rake will be given to this user
$minbet='25';
$maxbet='5000';
$snipetimer=5;
$title = "YOURWEBSITE.COM"; // This will be the title of your site, also shown in the top left corner

$steamgroup=''; // Link to your Steam Group - The Icon will show on top if you set this to anything
$twitter='https://twitter.com/CSGOdotNetwork'; // Link to Twitter Account - The Icon will show on top if you set this to anything
$facebook='https://www.facebook.com/CSGO.Network/'; // Link to your Facebook Page - The Icon will show on top if you set this to anything
$reddit=''; // Link to your Reddit Page - The Icon will show on top if you set this to anything

$sgt=''; // Don't change these
if($steamgroup)
{
	$sgt='<li class="hidden-xs"><a href="'.$steamgroup.'" target="_BLANK"><i class="fa fa-steam"></i></a></li>';
}
$tt=''; // Don't change these
if($twitter)
{
	$tt='<li class="hidden-xs"><a href="'.$twitter.'" target="_BLANK"><i class="fa fa-twitter"></i></a></li>';
}
$fbt=''; // Don't change these
if($facebook)
{
	$fbt='<li class="hidden-xs"><a href="'.$facebook.'" target="_BLANK"><i class="fa fa-facebook"></i></a></li>';
}
$rdt=''; // Don't change these
if($reddit)
{
	$rdt='<li class="hidden-xs"><a href="'.$reddit.'" target="_BLANK"><i class="fa fa-reddit"></i></a></li>';
}

?>