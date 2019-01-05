<?php 
if ( is_user_logged_in() ) :
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
  } else { //this is a dashboard
    if(current_user_can( 'manage_options' )) {
      $title = "<strong>All</strong>";
      $partial = 'post-report';
      $args = array(
        'post_type' => 'report',
        'posts_per_page' => -1,
        'meta_key' => 'date',
        'orderby' => 'meta_value',
        'order' => 'DESC',
      );
    } else { 
      $title = "<strong>$author->display_name</strong>";
      $partial = 'post-report';
      $author = wp_get_current_user();
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
        ),
      );
    }
  }


?>
<div class="section">
  <div class="wrapper">

    <?php if( isset($_GET['r']) && $_GET['r'] == 's' ): ?>
      <div class='success'>
        Thank you for your purchase!
      </div>
    <?php endif; ?>

    <div class="box">
      <?php if ( current_user_can( 'manage_options' ) ) : ?>
        <table>
          <thead>
            <tr><th align="left" colspan="2"><h4 class="label">Upcoming Ad Copy</h4></th></tr>
          </thead>
          <tbody>
        <?php
          $next_ad = array(
            'post_type' => 'purchased_item',
            'posts_per_page' => 3,
            'order'      => 'ASC',
            'orderby'    => 'meta_value',
            'meta_key'   => 'end',
            'meta_query' => array(
              array(
                'key'     => 'end',
                'value'   => date("Ymd"),
                'compare' => '>=',
                'type'    => 'numeric'
              ),
            ),
          );
					pxl::loop('ad-details',$next_ad);
        ?>
          </tbody>
        </table>
        
      <?php else : ?>
        <?php
          $pi_args = array(
            'post_type' => 'purchased_item',
            'posts_per_page' => -1,
            'meta_key' => 'start',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
              array(
                'key' => 'purchaser', // name of custom field
                'value' => $author->ID, //$author->ID
                'compare' => '=',
              )
            )
          );
          $pi = new WP_Query( $pi_args );
          if ($pi->found_posts) : 
        ?>
          <table>
            <thead>
              <tr>
                <th align="left"><label>Upcoming Ads</label></th>
                <th align="right"><a href="/sponsor/" class="btn">Purchase New Ads</a></th>
              </tr>
            </thead>
            <tbody>
              <?php pxl::loop('purchased-item',$pi_args); ?>
            </tbody>
          </table>
        <?php else : ?>
          <p class="center-text" style="margin:0;">
            2019 Ads are available for purchase. &nbsp;&nbsp;<a href="/sponsor/" class="btn">Purchase Ads</a>
          </p>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    
    <?php
      $reports = get_posts($args);
      $rcount = count($reports);
      $agg_r = 0;
      $agg_o = 0;
      $agg_c = 0;
      $agg_or = 0;
      $o_max = 0;
      $o_min = 1000000000;
      $c_max = 0;
      $c_min = 1000000000;
      foreach($reports as $report){
        $r = get_field('recipients', $report->ID) ? : 0;
        $o = get_field('opens', $report->ID) ? : 0;
        $c = get_field('clicks', $report->ID) ? : 0;
        $o_max = $o > $o_max ? $o : $o_max;
        $o_min = $o < $o_min ? $o : $o_min;
        $c_max = $c > $c_max ? $c : $c_max;
        $c_min = $c < $c_min ? $c : $c_min;
        $agg_o += $o;
        $agg_c += $c;
        $agg_or += ($r > 0) ? $o/$r : 0;
      }
      
      $avg_or = $reports ? $agg_or/count($reports) : 0;
      $inc = 500/($rcount-1); // for trendline
    ?>
    <div class="box nopad flexed">
      <div class="stat blue center-text ads-stat">
        <h4 class="label">Ads</h4>
        <span class="num"><?php echo $rcount ?></span>
      </div>
      <div class="stats">
        <div class="stat chart">
          <div>
            <h4 class="label">Views</h4>
            <span class="num" data-value="<?php echo $agg_o ?>" ><?php echo theme::humanize_number($agg_o) ?></span>
          </div>
          <svg viewBox="-10 -10 520 120" class="trendline" height="70">
            <polyline fill="none" stroke="#3D5BA9" stroke-width="4"
               points="
               <?php
                 foreach(array_reverse($reports) as $key=>$report){
                   $ro = get_field('opens',$report->ID);
                   $point = $key;
                   $x = $point*$inc;
                   $y = 100 - 100*($ro-$o_min)/($o_max-$o_min);
                   echo "$x, $y ";
                 }
               ?>
               "
            />
          </svg>
        </div>
        <div class="stat chart">
          <div>
            <h4 class="label">Clicks</h4>
            <span class="num" data-value="<?php echo $agg_c ?>" ><?php echo theme::humanize_number($agg_c) ?></span>
          </div>
          <svg viewBox="-10 -10 520 120" class="trendline" height="70">
            <polyline fill="none" stroke="#3D5BA9" stroke-width="4"
               points="
               <?php
                 foreach(array_reverse($reports) as $key=>$report){
                   $rc = get_field('clicks',$report->ID);
                   $point = $key;
                   $x = $point*$inc;
                   $y = 100 - 100*($rc-$c_min)/($c_max-$c_min);
                   echo "$x, $y ";
                 }
               ?>
               "
            />
          </svg>
        </div>
      </div>
    </div>
    

    <div class="box">
      <table id="reports">
        <thead>
          <tr>
            <?php if (current_user_can( 'manage_options' )) echo "<th></th>"; ?>
            <th align="left"><label>Ad Reports</label></th>
            <th align="right"><label>Open rate</label></th>
            <th align="right"><label>Views</label></th>
            <th align="right"><label>Clicks</label></th>
          </tr>
        </thead>
        <tbody>
          <?php 
            pxl::loop(
              $partial,
              $args
            );
          ?>
        </tbody>
      </table>
    </div>
      


	</div>
</div>
<?php endif; ?>