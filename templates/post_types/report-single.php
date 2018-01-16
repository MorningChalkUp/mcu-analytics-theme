<?php  
  $mcu_email_data = mcu_get_email_data(get_field('campaign_id'), get_field('ad_urls'));
?>
<?php $sponsor = get_field('sponsor'); ?>
<div class="section">
  <div class="wrapper">
    <div class="breadcrumb">
      <a href="/">&larr; Back to Reports</a>
    </div>
    <h2 class="section-title">
      <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 100, 'h' => '100' )); ?>
      <small><?php the_field('date') ?></small><br>
      <em>&ldquo;<?php echo $mcu_email_data['subject'] ?>&rdquo;</em>
    </h2>
    
    <br>
    
    <div class="stats">
      
      <div class="stat">
        <label>Recipients</label>
        <span class="num"><?php echo number_format($mcu_email_data['recipients']) ?></span>
      </div>
      <div class="stat">
        <label>Opens</label>
        <span class="num"><?php echo number_format($mcu_email_data['opens']) ?></span>
      </div>
      <div class="stat">
        <label>Open Rate</label>
        <span class="num"><?php  echo (round(($mcu_email_data['opens']/$mcu_email_data['recipients']*10000))/100).'%' ?></span>
      </div>
      <div class="stat">
        <label>Clicks</label>
        <span class="num"><?php echo number_format($mcu_email_data['ad_clicks']) ?></span>
      </div>
      
      
    </div>
    
    <br>
    
    <div class="row">
      
      <div class="span6">
        <h4>Ad Copy:</h4>
        <?php the_field('ad_copy'); ?>
        <p class="right-text"><a href="<?php echo $mcu_email_data['web_view'] ?>" target="popup" onclick="window.open('<?php echo $mcu_email_data['web_view'] ?>','popup','width=700,height=700,resizable=no'); return false;">View Full Newsletter &rarr;</a></p>
        
        <?php if($notes = get_field('notes')) :?>
          <h4>Notes:</h4>
          <?php echo  $notes; ?>
        <?php endif; ?>
      </div>
      
      <div class="span6">
        <h4>Click Activity by Link:</h4>
        <table class="fix">
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
        </table>
      </div>
      
    </div>

  </div>
</div>