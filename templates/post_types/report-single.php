<?php  
  // pull data
  $mcu_email_data = mcu_get_email_data(get_field('campaign_id'), get_field('ad_urls'));
  
  // save data to cache:
  update_field('recipients', $mcu_email_data['recipients']);
  update_field('opens', $mcu_email_data['opens']);
  update_field('clicks', $mcu_email_data['ad_clicks']);
  
?>
<?php $sponsor = get_field('sponsor'); ?>
<div class="section">
  <div class="wrapper">
    <div class="breadcrumb">
      <a href="/">&larr; Back to Reports</a>
    </div>
    <h2 class="section-title">
      <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 100, 'h' => '100' )); ?>
      
      <?php
        if ( current_user_can( 'manage_options' ) ) {
          $args = array(
            'post_type' => 'report',
            'posts_per_page' => -1,
            'meta_key' => 'date',
            'orderby' => 'meta_value',
            'order' => 'DESC',
          );
        } else {
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
        $reports = get_posts($args);
      ?>
      
      <div class="select-container">
        <select id="report_select">
          <?php foreach ($reports as $report) : $date = get_field('date',$report->ID) ; $selected = $report->ID == $post->ID ? 'selected' : '' ; ?>
            <option <?php echo $selected ?> value="<?php echo get_permalink($report->ID) ?>"><?php echo $date ?></option>
          <?php endforeach; ?>
        </select>
        <i class="fal fa-angle-down"></i>
      </div>
      <br>
      <em>&ldquo;<?php echo $mcu_email_data['subject'] ?>&rdquo;</em>
    </h2>
    
    <div class="box">
      <div class="stats">
        <div class="stat">
          <h4 class="label">Recipients</h4>
          <span class="num"><?php echo number_format($mcu_email_data['recipients']) ?></span>
        </div>
        <div class="stat">
          <h4 class="label">Opens</h4>
          <span class="num"><?php echo number_format($mcu_email_data['opens']) ?></span>
        </div>
        <div class="stat">
          <h4 class="label">Open Rate</h4>
          <span class="num"><?php  echo (round(($mcu_email_data['opens']/$mcu_email_data['recipients']*10000))/100).'%' ?></span>
        </div>
        <div class="stat">
          <h4 class="label">Clicks</h4>
          <span class="num"><?php echo number_format($mcu_email_data['ad_clicks']) ?></span>
        </div>
      </div>
    </div>
    
    <div class="row boxes">
      
      <div class="span6">
        <div class="box">
          <h4 class="label">Ad Copy</h4>
          <?php the_field('ad_copy'); ?>
          <p class="right-text"><a href="<?php echo $mcu_email_data['web_view'] ?>" target="popup" onclick="window.open('<?php echo $mcu_email_data['web_view'] ?>','popup','width=700,height=700,resizable=no'); return false;">View Full Newsletter &rarr;</a></p>
        
          <?php if($notes = get_field('notes')) :?>
            <h4>Notes:</h4>
            <?php echo  $notes; ?>
          <?php endif; ?>
        </div>
      </div>
      
      <div class="span6">
        <div class="box">
          <table class="fix">
            <thead>
              <tr>
                <th align="left"><label>Sponsor Link</label></th>
                <th align="right"><label>Clicks</label></th>
              </tr>
            </thead>
            <tbody>
              <?php
                foreach($mcu_email_data['ad_links'] as $ad_link) :
              ?>
                <tr>
                  <td><?php echo $ad_link['url'] ?></td>
                  <td class="num num-small" align="right"><?php echo $ad_link['clicks'] ?></td>
                </tr>
              <?php
                endforeach;
              ?>
            </tbody>
          </table>
        </div>
      </div>
      
    </div>

  </div>
</div>