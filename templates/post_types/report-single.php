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
      <?php echo $sponsor['display_name']; ?> <small>| <?php the_field('date') ?></small>
    </h2>
    <hr>
    <div class="row">
      <div class="span7">
        <h4>&ldquo;<?php echo $mcu_email_data['subject'] ?>&rdquo;</h4>
        <div class="row">
          <div class="span4">
            <span class="num"><?php echo number_format($mcu_email_data['opens']) ?></span>
            <label>Opens</label>
          </div>
          <div class="span3">
            <span class="num"><?php echo number_format($mcu_email_data['ad_clicks']) ?></span>
            <label>Ad Clicks</label>
          </div>
        </div>
        <hr>
        <h4>Click Activity by Link:</h4>
        <table>
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
        <?php //fn::put($mcu_email_data) ?>
      </div>
      <div class="span1 placeholder"></div>
      <div class="span4">
        <h4>Preview: <a class="alignright" href="<?php echo $mcu_email_data['web_view'] ?>" target="popup" onclick="window.open('<?php echo $mcu_email_data['web_view'] ?>','popup','width=700,height=700,resizable=no'); return false;">View Full</a></h4>
        <div class="preview">
          <iframe src="<?php echo $mcu_email_data['web_view'] ?>" width="600" height="900">
          </iframe>
        </div>
        <?php if($notes = get_field('notes')) :?>
          <h4>Notes:</h4>
          <?php echo  $notes; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>