<?php 
  if ( is_user_logged_in() ) : 
    include(THEME . '/templates/default/author.php'); 
  else: ?>
	<div class="section vertical-center">
		<div class="wrapper">
			<div id="login" class="box">
				<?php wp_login_form(array('label_log_in' => 'Sign In')); ?>
  			<?php
  				if ( !empty($_REQUEST['login']) ) {
  					$lostpassword_url = wp_lostpassword_url(home_url('my-account/?passwordreset=true'));
  					echo "<div class='error'>Login Failed<br><small>Please try again, <a href=\"{$lostpassword_url}\">click here to reset your password</a>.</small></div>";
  				}
				
  				if ( !empty($_REQUEST['passwordreset']) ) echo "<h5>Check your email for the confirmation link.<small></h5>";
  			?>
			</div>
			
		</div>
	</div>
<?php endif; ?>