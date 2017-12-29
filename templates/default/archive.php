<div class="section">
  <div class="wrapper">
    <h2><?php
      if ( is_post_type_archive() ) {
        post_type_archive_title();
      }
      else if( is_home() ) {
        echo "Welcome to my Blog!";
      }
    ?></h2>
    <div class="items row">
      <?php pxl::loop(); ?>
    </div>
  </div>
</div>