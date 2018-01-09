<?php if ( $load == 'header' ) : ?>
  <div id="navbar">
    <div class="wrapper">
      <div class="navleft">
        <h1><a id="logo" href="/"><?php echo file_get_contents(get_bloginfo('stylesheet_directory').'/resources/images/mcu.svg') ?></a> Analytics</h1>
      </div>
      <div class="navmid">
        
      </div>
      <div class="navright">
        <?php if ( is_user_logged_in() ) {
          $site   = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'];
          $author = wp_get_current_user();
          $logout = wp_logout_url($site);
          echo 'welcome, '.$author->display_name;

          echo " | <a href='$logout'>Logout</a>";
        } ?>
      </div>
    </div>
    <!-- <div id="menu">

    </div> -->
  </div>
<?php else : // Content Loads Between ?>
  <div id="footer">
    <div class="wrapper">
      
    </div>
  </div>
<?php endif; ?>