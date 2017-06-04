<footer class="footer text-right">
2016 © Ubold
</footer>
<?php
if(!isset($_SESSION['steamid']))
{
	echo'
	<div id="loginmodal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="loginmodal" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="loginmodal">Before logging in</h4>
				</div>
				<div class="modal-body">
					<b>By logging in to our website you agree to our TOS and Rules.</b>
					<br><br>
					Betting is only allowed to users above the age of 18, anyone gambling under 18 will be permanently banned from our website.
					<br><br>
					We are not in any way associated with Valve or Steam, to comply with their new TOS we only accept Deposits from <a href="http://skinbucket.com" target="_SB">SkinBucket.com</a>.
					<br><br><hr>';
					echo steamlogin();
					echo'
				</div>

			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	';
}
?>
<!-- V3 Version Alpha --->