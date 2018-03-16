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
      <?php pxl::image("acf|logo|user_$author->ID", array( 'w' => 100, 'h' => 100, 'attrs' => array('class'=>'nofloat') )); ?>
      <?php echo $title ?>
    </h2>
    
    <?php
      $reports = get_posts($args);
      $agg_r = 0;
      $agg_o = 0;
      $agg_c = 0;
      $agg_or = 0;
      foreach($reports as $report){
        $r = get_field('recipients', $report->ID) ? : 0;
        $o = get_field('opens', $report->ID) ? : 0;
        $c = get_field('clicks', $report->ID) ? : 0;
        $agg_o += $o;
        $agg_c += $c;
        $agg_or += ($r > 0) ? $o/$r : 0;
      }
      $avg_or = $agg_or/count($reports);
    ?>
    
    <h4>Total Stats:</h4>
    <div class="stats">
      <div class="stat">
        <label>Opens</label>
        <span class="num"><?php echo number_format($agg_o) ?></span>
      </div>
      <div class="stat">
        <label>Average Open Rate</label>
        <span class="num"><?php  echo (round(($avg_or*10000))/100).'%' ?></span>
      </div>
      <div class="stat">
        <label>Clicks</label>
        <span class="num"><?php echo number_format($agg_c) ?></span>
      </div>
    </div>
    
    <br>
    
    <h4>Reports:</h4>
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