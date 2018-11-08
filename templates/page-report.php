<?php /* Template Name: Purchase Report */ ?>

<?php 
  $purchases =  query_posts(array(
    'post_type' => 'purchase',
    'posts_per_page' => -1,
  ));
  $total = 0;
  $paid = 0;
  
  foreach ($purchases as $purchase) {
    $total += get_field( 'purchase_total', $purchase );
    $paid += get_field( 'amount_paid', $purchase );
  }

  $weeks =get_field('weeks', 'options');

  $total_weeks = 0;
  $purchased_weeks = 0;
  $available_weeks = 0;
  $total_weekends = 0;
  $purchased_weekends = 0;
  $available_weekends = 0;

  foreach ($weeks as $week) {
    if ($week['start'] == $week['end']) {
      ++$total_weekends;
      if ($week['availability'] != 'not_for_sale') {
        ++$available_weekends;
      }
      if ($week['purchaser']) {
        ++$purchased_weekends;
      }
    } else {
      ++$total_weeks;
      if ($week['availability'] != 'not_for_sale') {
        ++$available_weeks;
      }
      if ($week['purchaser']) {
        ++$purchased_weeks;
      }
    }
  }

?>

<div class="section" style="padding-top: 1rem;">
  <div class="wrapper">
    <div><h2>Total Purchased: $<?php echo number_format($total, 2,'.', ',') ?></h2></div>
    <div><h2>Total Paid: $<?php echo number_format($paid, 2,'.', ',') ?></h2></div>
    <div><h2>Weeks Purchased: <?php echo $purchased_weeks ?>/<?php echo $available_weeks; ?> (<?php echo $total_weeks ?> Total)</h2></div>
    <div><h2>Weekends Purchased: <?php echo $purchased_weekends ?>/<?php echo $available_weekends; ?> (<?php echo $total_weekends ?> Total)</h2></div>
  </div>
</div>

<div class="section">
  <div class="wrapper">
    <hr>
    <h1>Purchases By Week</h1>
    <?php foreach ($weeks as $week): ?>
      <h3 style="font-weight: 400">
        <?php 
          echo date('F j', strtotime($week['start'])); 
          if ($week['start'] != $week['end']) {
            echo ' - ' . date('F j', strtotime($week['end'])); 
          }
        ?>

        <?php if ($week['purchaser']): ?>
          - <strong style="font-weight: 700"><?php echo $week['purchaser']['display_name'] ?></strong>
        <?php endif; ?>

      </h3>
    <?php endforeach ?>
  </div>
</div>


<div class="section">
  <div class="wrapper">
    <hr>
    <h1>Purchases By Order</h1>
  </div>
</div>
<?php foreach ($purchases as $purchase): ?>
  <div class="section">
    <div class="wrapper">
      <h2><?php echo get_field('purchaser', $purchase)['display_name']; ?> - Order#: <?php echo $purchase->ID; ?></h2>

      <div style="font-weight: 700;">Total: $<?php echo number_format(get_field( 'purchase_total', $purchase ), 2,'.', ',') ?><br>
        Paid: $<?php echo number_format(get_field( 'amount_paid', $purchase ), 2,'.', ',') ?>
      </div>
      <?php 
        $items = query_posts(array(
          'post_type' => 'purchased_item',
          'posts_per_page' => -1,
          'meta_key' => 'purchase_id',
          'meta_value' => $purchase->ID,
          'orderby' => 'title',
          'order' => 'ASC',
        ));
      ?>
      <?php foreach ($items as $item): ?>
        <h3>
          <?php 
            echo date('F j', strtotime(get_field('start', $item))); 
            if(get_field('start', $item) != get_field('end', $item)) {
              echo ' - ';
              echo date('F j', strtotime(get_field('end', $item))); 
            }
          ?>   
        </h3>
        <?php if(get_field('facebook_retargeting', $item) || get_field('ab_testing', $item) || get_field('we_write_ads', $item)): ?>
          <ul>
            <?php if(get_field('facebook_retargeting', $item)): ?>
              <li>Facebook Retargeting</li>
            <?php endif; ?>
            <?php if(get_field('ab_testing', $item)): ?>
              <li>A/B Testing</li>
            <?php endif; ?>
            <?php if(get_field('we_write_ads', $item)): ?>
              <li>We Write Ads</li>
            <?php endif; ?>
          </ul>
        <?php endif; ?>
        <hr>
      <?php endforeach; ?>
    </div>
  </div>
<?php endforeach; ?>