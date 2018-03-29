<?php if ( is_user_logged_in() ) :
	$site   = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'];
  //current_user_can( 'manage_options' )
  if(is_author()){
    $author = (get_query_var('author_name')) ? get_user_by('slug', get_query_var('author_name')) : get_userdata(get_query_var('author'));
    $title = "<strong>$author->display_name</strong>";
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
  } else {
    $author = wp_get_current_user();
    $title = "<strong>All</strong>";
    $partial = 'post-report-admin';
    $args = array(
      'post_type' => 'report',
      'posts_per_page' => -1,
      'meta_key' => 'date',
      'orderby' => 'meta_value',
      'order' => 'DESC',
    );
  }


?>
<div class="section">
  <div class="wrapper">
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
    
    <div class="box nopad">
      <div class="stats">
        <div class="stat blue center-text">
          <label>Ads</label>
          <span class="num"><?php echo count($reports); ?></span>
        </div>
        <div class="stat">
          <label>Views</label>
          <span class="num"><?php echo number_format($agg_o) ?></span>
        </div>
        <!-- <div class="stat">
          <label>Average Open Rate</label>
          <span class="num"><?php  //echo (round(($avg_or*10000))/100).'%' ?></span>
        </div> -->
        <div class="stat">
          <label>Clicks</label>
          <span class="num"><?php echo number_format($agg_c) ?></span>
        </div>
      </div>
    </div>
    <div class="box">
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
</div>
<?php endif; ?>