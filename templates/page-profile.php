<?php /* Template Name: Profile */ ?>
<?php acf_form_head(); ?>
<div class="section">
  <div class="wrapper">
    <div class="row">
      <div class="span2 placeholder"></div>
      <div class="span8">
    
        <h2 class="section-title">My Profile</h2>
    
        <?php require_once(THEME.'/includes/update-profile.php'); ?>
    
        <?php get_template_part('parts/dashboard/user'); ?>
    
        <div id="dashboard-content">
          <div class="wrap">
        
        		<?php if( !empty( $_GET['updated'] ) ): ?>
        			<p class="success"><?php _e('Profile successfully updated', 'textdomain'); ?></p>
        		<?php endif; ?>
        
        		<?php if( !empty( $_GET['validation'] ) ): ?>
        	
        			<?php if( $_GET['validation'] == 'emailnotvalid' ): ?>
        				<div class="error"><?php _e('The given email address is not valid', 'textdomain'); ?></div>
        			<?php elseif( $_GET['validation'] == 'emailexists' ): ?>
        				<div class="error"><?php _e('The given email address already exists', 'textdomain'); ?></div>
        			<?php elseif( $_GET['validation'] == 'passwordmismatch' ): ?>
        				<div class="error"><?php _e('The given passwords did not match', 'textdomain'); ?></div>
        			<?php elseif( $_GET['validation'] == 'unknown' ): ?>
        				<div class="error"><?php _e('An unknown error accurd, please try again or contant the website administrator', 'textdomain'); ?></div>
        			<?php endif; ?>
        
        		<?php endif; ?>
        
        		<?php $current_user = wp_get_current_user(); ?>
        
            <form method="post" id="adduser" action="<?php the_permalink(); ?>">          
              <table class="form-table">
                <tbody>
                  <tr class="acf-field">
                    <td class="acf-label"><label for="user_login"><?php _e('Username', 'textdomain'); ?></label></td>
                    <td><input class="text-input" name="user_login" type="text" id="user_login" value="<?php the_author_meta( 'user_login', $current_user->ID ); ?>" disabled/></td>
                  </tr>
                  <tr class="acf-field">
                    <td class="acf-label"><label for="first-name"><?php _e('First name', 'textdomain'); ?></label></td>
                    <td><input class="text-input" name="first-name" type="text" id="first-name" value="<?php the_author_meta( 'first_name', $current_user->ID ); ?>" /></td>
                  </tr>
                  <tr class="acf-field">
                    <td class="acf-label"><label for="last-name"><?php _e('Last name', 'textdomain'); ?></label></td>
                    <td><input class="text-input" name="last-name" type="text" id="last-name" value="<?php the_author_meta( 'last_name', $current_user->ID ); ?>" /></td>
                  </tr>
                  <tr class="acf-field">
                    <td class="acf-label"><label for="email"><?php _e('E-mail *', 'textdomain'); ?></label></td>
                    <td><input class="text-input" name="email" type="text" id="email" value="<?php the_author_meta( 'user_email', $current_user->ID ); ?>" /></td>
                  </tr>
                  <tr class="acf-field">
                    <td class="acf-label">
                      <label><?php _e('Change password', 'textdomain'); ?></label>
                    </td>
                    <td>
                      <p class="form-password">
                          <label for="pass1"><?php _e('Password *', 'profile'); ?> </label>
                          <input class="text-input" name="pass1" type="password" id="pass1" />
                      </p>
                      <p class="form-password">
                          <label for="pass2"><?php _e('Repeat password *', 'profile'); ?></label>
                          <input class="text-input" name="pass2" type="password" id="pass2" />
                      </p>
                      <p><?php _e('When both password fields are left empty, your password will not change', 'textdomain'); ?></p>
                      
                    </td>
                  </tr>
                </tbody>
              </table>
              <style>
                #acf-form-data + h2{display:none;}
                #acf-form-data + h2 + table{}
              </style>
              <?php 
                  // action hook for plugin and extra fields
                  do_action('edit_user_profile', $current_user); 
              ?>
              <p><?php //the_field('logo', 'user_'.$current_user->ID); ?></p>
        
              <?php //acf_form(); ?>
                                  
              <p class="form-submit">
                  <input name="updateuser" type="submit" id="updateuser" class="submit button" value="<?php _e('Update profile', 'textdomain'); ?>" />
                  <?php wp_nonce_field( 'update-user' ) ?>
                  <input name="honey-name" value="" type="text" style="display:none;"></input>
                  <input name="action" type="hidden" id="action" value="update-user" />
              </p><!-- .form-submit -->
            </form><!-- #adduser -->
          </div>
        </div>
      </div>
      <div class="span2 placeholder"></div>
    </div>
  </div>
</div>