<?php if ( is_user_logged_in() ) :
	$site   = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'];
	$author = wp_get_current_user();
  
  if ( current_user_can( 'manage_options' ) ) {
    $title = "<strong>All</strong> Reports";
    $partial = 'post-report-admin';
    $args = array(
      'post_type' => 'report',
      'posts_per_page' => -1,
      'meta_key' => 'date',
      'orderby' => 'meta_value',
      'order' => 'DESC',
    );
  } else {
    $title = "<strong>$author->display_name</strong> Reports";
    $partial = 'post-report';
    $args = array(
      'post_type' => 'report',
      'posts_per_page' => -1,
      'meta_key' => 'date',
      'orderby' => 'meta_value',
      'order' => 'DESC',
      'meta_query' => array(
        array(
          'key' => 'sponsor', // name of custom field
          'value' => $author->ID,
          'compare' => '=',
        )
      )
    );
  }
  
  
?>
<div class="section">
  <div class="wrapper">
    <h2 class="section-title">
      <?php $logo = get_field('logo','user_'.$author->ID); ?>
      <img src="<?php echo $logo['url'] ?>" width="100" height="100"/>
      <?php //pxl::image("acf|logo|user_$author->ID", array( 'w' => 100, 'h' => 'auto' )); ?>
      <?php echo $title ?>
    </h2>
    <table id="reports">
    <?php 
      pxl::loop(
        $partial,
        $args
      );
    ?>
    </table>

	</div>
</div>
<?php endif; ?>