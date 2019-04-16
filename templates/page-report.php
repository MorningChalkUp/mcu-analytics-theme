<?php /* Template Name: Purchase Report */ ?>

<?php if ( current_user_can( 'administrator' ) ) : ?>
  <?php 
    $purchases =  query_posts(array(
      'post_type' => 'purchase',
      'posts_per_page' => -1,
    ));
    $total = 0;
    $paid = 0;
    
    $weeks =get_field('weeks', 'options');

    foreach ($purchases as $purchase) {
      $total += get_field( 'purchase_total', $purchase );
      $paid += get_field( 'amount_paid', $purchase );
    }
    get_field('links', 'options');
    if(have_rows('links', 'options')) {
      while(have_rows('links', 'options')) {
        the_row();
        if(get_sub_field('order_id') != '' && get_sub_field('availability') == 'purchased') {
          $total += get_sub_field('price');
          $paid += get_sub_field('price');
        }
      }
    }

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
  <div class="section">
    <div class="wrapper">
      
      <div class="box">
        <div class="stats">
          <div class="stat">
            <h4 class="label">Total Purchased:</h4>
            <span class="num">$<?php echo number_format($total, 2,'.', ',') ?></span>
          </div>
          <div class="stat">
            <h4 class="label">Total Paid:</h4>
            <span class="num">$<?php echo number_format($paid, 2,'.', ',') ?></span>
            <h4 class="label">$<?php echo number_format(($total - $paid), 2,'.', ',') ?> Remaining</h4>
          </div>
          <div class="stat">
            <h4 class="label">Weeks Purchased:</h4>
            <span class="num"><?php echo $purchased_weeks ?>/<?php echo $available_weeks; ?> </span>
            <h4 class="label"><?php echo $total_weeks ?> Total</h4>
          </div>
          <div class="stat">
            <h4 class="label">Weekends Purchased:</h4>
            <span class="num"><?php echo $purchased_weekends ?>/<?php echo $available_weekends; ?> </span>
            <h4 class="label"><?php echo $total_weekends ?> Total</h4>
          </div>
        </div>
      </div>
      
      <div class="row">
        <div class="span8">
          <h2>Purchases By Order</h2>

          <?php foreach ($purchases as $purchase): ?>
          <div class="box">
            <h3 style="margin:0">
              <?php echo get_field('purchaser', $purchase)['display_name']; ?> - Order#: <?php echo $purchase->ID; ?>
              <br><small>Payment: <?php the_field( 'stripe_id', $purchase ); ?></small>
            </h3>
        
            <table>
              <tr style="border:none">
                <td valign="top">
                  <p>Total: $<?php echo number_format(get_field( 'purchase_total', $purchase ), 2,'.', ',') ?><br>
                  Paid: $<?php echo number_format(get_field( 'amount_paid', $purchase ), 2,'.', ',') ?></p>
                </td>
                <td>
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
                  <table>
                    <?php foreach ($items as $item): ?>
                      <tr>
                        <td>
                          <?php 
                            echo date('F j', strtotime(get_field('start', $item))); 
                            if(get_field('start', $item) != get_field('end', $item)) {
                              echo ' - ';
                              echo date('F j', strtotime(get_field('end', $item))); 
                            }
                          ?>   
                        </td>
                        <td>
                          <?php 
                            if(get_field('facebook_retargeting', $item) || get_field('ab_testing', $item) || get_field('we_write_ads', $item)){
                              if(get_field('facebook_retargeting', $item)) echo "[Facebook Retargeting]"; 
                              if(get_field('ab_testing', $item)) echo "[A/B Testing]";
                              if(get_field('we_write_ads', $item)) echo "[We Write Ads]";
                            } 
                          ?>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </table>
                </td>
              </tr>
            </table>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="span4">
          <h2>Sponsored Links</h2>
          <table>
            <?php if(have_rows('links', 'options')): ?>
              <?php while(have_rows('links', 'options')): the_row(); ?>
                <?php if(get_sub_field('availability') == 'purchased'): ?>
                  <tr>
                    <td>
                      <?php echo date('M j', strtotime(get_sub_field('day')));  ?>
                    </td>
                    <td align="right">
                      <strong><?php echo get_sub_field('purchaser')['display_name']; ?></strong>
                    </td>
                  </tr>
                <?php endif; ?>
              <?php endwhile; ?>
            <?php endif; ?>
          </table>
          <h2>By Date</h2>
          <table>
          <?php foreach ($weeks as $week): ?>
            <tr>
              <td>
                <?php 
                  echo date('M j', strtotime($week['start'])); 
                  if ($week['start'] != $week['end']) echo ' - ' . date('M j', strtotime($week['end'])); 
                ?>
              </td>
              <td align="right">
                <?php 
                  if ($week['purchaser']) echo "<strong>{$week['purchaser']['display_name']}</strong>";
                ?>
              </td>
            </tr>
          <?php endforeach ?>
          </table>
        </div>
      </div>
      

<?php endif; ?>