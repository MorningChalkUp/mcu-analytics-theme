<?php if ( $load == 'header' ) : ?>
  <div id="navbar">
    <div class="wrapper">
      <div class="navleft">
        <h1><a id="logo" href="/"><?php echo file_get_contents(get_bloginfo('stylesheet_directory').'/resources/images/mcu.svg') ?></a> <small class="hidden-phone">Analytics</small></h1>
      </div>
      <div class="navmid">
        
      </div>
      <div class="navright">
        <?php 
          if ( is_user_logged_in() ) :
            $site   = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'];
            $author = wp_get_current_user();
            $logout = wp_logout_url($site);
            
        ?>
          <a href='#' id='menubtn'>
            <?php 
              echo '<span class="hidden-phone">'.$author->display_name.'</span>';
              pxl::image("acf|logo|user_$author->ID", array( 'w' => 40, 'h' => 40));
            ?>
          </a>
          <div id="menu">
            <ul>
              <li><a href="/profile">My Profile</a></li>
              <li><?php echo "<a href='$logout'>Logout</a>" ?></li>
            </ul>
          </div>
        <?php endif; ?>
      </div>
    </div>
    
  </div>
<?php else : // Content Loads Between ?>
  <div id="footer">
    <div class="wrapper">
      
    </div>
  </div>
<?php endif; ?>