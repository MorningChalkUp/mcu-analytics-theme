<script async src="https://www.googletagmanager.com/gtag/js?id=UA-76434343-2"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-76434343-2');
</script>

<?php if ( $load == 'header' ) : ?>
  <div id="navbar" class="fixed">
    <div class="max">
      <div class="contain">
        <div class="navleft">
          <h1><a id="logo" href="/"><?php echo file_get_contents(get_bloginfo('stylesheet_directory').'/resources/images/mcu.svg') ?></a> <small class="hidden-phone">Ads</small></h1>
        </div>
        <div class="navmid">
          
        </div>
        <div class="navright" id="nav">
          <?php 
            if ( is_user_logged_in() ) :
              $site   = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'];
              $author = wp_get_current_user();
              $logout = wp_logout_url($site);
              
          ?>
            <ul class="menu">
              <?php 
                wp_nav_menu(
                  array(
                    'container' => false,
                    'items_wrap' => '%3$s',
                    'fallback_cb' => false,
                    'menu_class' => 'menu',
                    'theme_location' => 'main',
                    'walker' => new pxl_menu
                  )
                );
              ?>
              <li class="pipe"><span></span></li>
              <li>
                <a href='#' id='menubtn'>
                  <?php 
                    echo $author->display_name;
                    pxl::image("acf|logo|user_$author->ID", array( 'w' => 40, 'h' => 40));
                  ?>
                </a>
              </li>
            </ul>
            <div id="menu">
              <ul>
                <li><a href="/profile">My Profile</a></li>
                <li><?php echo "<a href='$logout'>Logout</a>" ?></li>
              </ul>
            </div>
          <?php else: ?>
            <ul class="menu">
              <li>
                <a href="/">Login</a>
              </li>
            </ul>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php else : // Content Loads Between ?>

<?php endif; ?>