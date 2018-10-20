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
      $avg_or = $agg_or/count($reports);
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
    
    <div class="row">
      <div class="span8">
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
      <div class="span4">
        <div class="box">
          <table>
            <thead>
              <tr>
                <th align="left"><label>Upcoming Ads</label></th>
                <th align="right"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td><a href="#t1547424000" class="popup">Jan 14 - 18</a></td>
                <td align="right">
                  <!-- <span class="status on" title="Ad Written"><i class="far fa-pencil"></i></span>
                  <span class="status on" title="Ad Approved"><i class="far fa-check-circle"></i></span> -->
                </td>
              </tr>
              <tr>
                <td><a href="#t1547424000" class="popup">Feb 25 - Mar 01</a></td>
                <td align="right">
                  <!-- <span class="status on" title="Ad Written"><i class="far fa-pencil"></i></span>
                  <span class="status off" title="Ad Approved"><i class="far fa-check-circle"></i></span> -->
                </td>
              </tr>
            </tbody>
          </table>
          <div id="t1547424000" class="mfp-hide popupwindow" >
            <div id="manageads">
              <h3>Your ads for Jan 14 - 18</h3>
              <hr>
              <div>
                <h4 class="label">Jan 14</h4>
                <p>
                  <label for="descriptor">Descriptor</label><br>
                  <input type="text" name="descriptor" value="powered by" placeholder="powered by" id="descriptor">
                </p>
            
                <p>
                  <label>Ad Copy</label><br>
                  <textarea style="width:100%"></textarea>
                </p>
            
                <p>
                  <label>Link</label><br>
                  <input type="text" name="link" value="" placeholder="http://www.morningchalkup.com" id="link">
                </p>
            
                <p>
                  <label>Hyperlinked Text</label><br>
                  <input type="text" name="link_text" value="" placeholder="learn more" id="link_text">
                </p>
              
                <hr>
              </div>
              
              <div>
                <h4 class="label">Jan 15</h4>
                <p>
                  <label for="descriptor">Descriptor</label><br>
                  <input type="text" name="descriptor" value="powered by" placeholder="powered by" id="descriptor">
                </p>
            
                <p>
                  <label>Ad Copy</label><br>
                  <textarea style="width:100%"></textarea>
                </p>
            
                <p>
                  <label>Link</label><br>
                  <input type="text" name="link" value="" placeholder="http://www.morningchalkup.com" id="link">
                </p>
            
                <p>
                  <label>Hyperlinked Text</label><br>
                  <input type="text" name="link_text" value="" placeholder="learn more" id="link_text">
                </p>
              
                <hr>
              </div>
              
            </div>
          </div>
          <br>
          <a href="/sponsor/" class="btn btn-full">New Ads</a>
        </div>
      </div>
    </div>
	</div>
</div>
<?php endif; ?>