<?php /* Template Name: Create Account */ ?>
<?php 
  if ( is_user_logged_in() ) : 
    include(THEME . '/templates/default/author.php'); 
  else: ?>
  
	<div class="section vertical-center">
		<div class="wrapper">
      
      <div id="login" class="box">
        <h2 style="margin-top:0;"><?php the_title(); ?></h2>
        <?php gravity_form(2, false, false, false, '', true, 10 ); ?>
			</div>
			
		</div>
	</div>
  
<?php endif; ?>