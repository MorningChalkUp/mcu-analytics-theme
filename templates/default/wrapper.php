<?php if ( $load == 'header' ) : ?>
  <div id="navbar">
    <div class="wrapper">
      <div class="navleft">
        <h1><a id="logo" href="/"><?php echo file_get_contents(get_bloginfo('stylesheet_directory').'/resources/images/mcu.svg') ?></a> <small class="hidden-phone">Analytics</small></h1>
      </div>
      <div class="navmid">
        
      </div>
      <div class="navright">
        <?php if ( is_user_logged_in() ) {
          $site   = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'];
          $author = wp_get_current_user();
          $logout = wp_logout_url($site);
          echo '<span class="hidden-phone">welcome, '.$author->display_name.' </span>';

          echo "<a href='#' id='menubtn'> <i class='fal fa-bars fa-lg fa-fw'></i></a>";
        } ?>
        <div id="menu">
          <ul>
            <li><a href="/">Reports</a></li>
          </ul>
          <ul>
            <li><?php echo "<a href='$logout'>Logout</a>" ?></li>
          </ul>
        </div>
      </div>
    </div>
    
  </div>
<?php else : // Content Loads Between ?>
  <div id="footer">
    <div class="wrapper">
      
    </div>
  </div>
<?php endif; ?>