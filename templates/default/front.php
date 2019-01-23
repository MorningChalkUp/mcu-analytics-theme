<?php 
  if ( is_user_logged_in() ) : 
    include(THEME . '/templates/default/author.php'); 
  else: ?>

<?php
	if(isset($_GET['redirect'])) {
		$redirect = $_GET['redirect'];
	} else {
		$redirect = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	}
?>
  
	<div class="section vertical-center">
		<div class="wrapper">
			
      <div id="login" class="box">
        <h2 style="margin-top:0;">Sign In</h2>
				<?php wp_login_form(array('label_log_in' => 'Sign In', 'redirect' => $redirect)); ?>
  			<?php
  				if ( !empty($_REQUEST['login']) ) {
  					$lostpassword_url = wp_lostpassword_url(home_url('my-account/?passwordreset=true'));
  					echo "<div class='error'>Login Failed<br><small>Please try again, <a href=\"{$lostpassword_url}\">click here to reset your password</a>.</small></div>";
  				}
  				if ( !empty($_REQUEST['passwordreset']) ) echo "<h5>Check your email for the confirmation link.<small></h5>";
  			?>
        <p class="center-text">or <a href="/create-account/" >Create an Account</a></p>
			</div>
			
		</div>
	</div>
  
<?php endif; ?>