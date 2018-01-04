<?php  
  $mcu_email_data = mcu_get_email_data(get_field('campaign_id'), get_field('ad_urls'));
?>
<?php $sponsor = get_field('sponsor'); ?>
<div class="section">
  <div class="wrapper">
    <div class="breadcrumb">
      <a href="/">&larr; Back to Dashboard</a>
    </div>
    <h2 class="section-title">
      <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 100, 'h' => 'auto' )); ?>
      <?php the_title(); ?><small> | <?php the_field('date') ?></small>
    </h2>
    <hr>
    <div class="row">
      <div class="span8">
        <div class="row">
          <div class="span4">
            <span class="num"><?php echo number_format($mcu_email_data['opens']) ?></span>
            <label>Opens</label>
          </div>
          <div class="span4">
            <span class="num"><?php echo number_format($mcu_email_data['ad_clicks']) ?></span>
            <label>Ad Clicks</label>
          </div>
        </div>
        <hr>
        <?php
          foreach($mcu_email_data['ad_links'] as $ad_link) :
        ?>
        
        <?php
          endforeach;
        ?>
        <?php fn::put($mcu_email_data) ?>
        <hr>
      </div>
      <div class="span4">
        <h4>Campaign Preview <a class="alignright" href="<?php echo $mcu_email_data['web_view'] ?>" target="popup" onclick="window.open('<?php echo $mcu_email_data['web_view'] ?>','popup','width=700,height=700,resizable=no'); return false;">View Full</a></h4>
        <div class="preview">
          <iframe src="<?php echo $mcu_email_data['web_view'] ?>" width="600" height="900">
          </iframe>
        </div>
        <?php the_field('notes'); ?>
      </div>
    </div>
  </div>
</div>