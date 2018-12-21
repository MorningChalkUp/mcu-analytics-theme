<?php /* Template Name: Manual Receipt */ ?>

<?php 
  if ( $_SERVER['REQUEST_METHOD'] == 'POST' && !empty( $_POST['action'] ) ) {
    if( $_POST['action'] == 'manual-receipt' ) {
      $url = 'http://data.morningchalkup.com/api/ads/receipt';
    } elseif ( $_POST['action'] == 'manual-copy' ) {
      $url = 'http://data.morningchalkup.com/api/ads/reminder/copy';
    } elseif ( $_POST['action'] == 'manual-payment' ) {
      $url = 'http://data.morningchalkup.com/api/ads/reminder/payment';
    } 

    if (isset($url)) {
      $data = $_POST;

      $data['send_admin'] = false;

      $query = http_build_query($data);

      $ch = curl_init();

      curl_setopt($ch,CURLOPT_URL, $url);
      curl_setopt($ch,CURLOPT_POST, count($data));
      curl_setopt($ch,CURLOPT_POSTFIELDS, $query);
      curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

      $result = curl_exec($ch);
      
      $success = true;
    }
  }
?>

<?php 
  $purchases = new WP_Query(
    array(
      'post_type' => array( 'purchase' ),
      'posts_per_page' => '-1',
    )
  );
?>

<div class="section">
  <div class="wrapper">
    <?php if(isset($success) && $success): ?>
      <div class='success'>
        Email Sent
      </div>
    <?php endif; ?>
  </div>
</div>

<div class="section">
  <div class="wrapper">
    <?php foreach ($purchases->posts as $post): ?>
        <?php $purchaser = get_field('purchaser', $post->ID) ?>
        <div class="box">
          <h2>
            <?php echo $purchaser['display_name']; ?>: Order #: <?php echo $post->ID ?><br>
            <small><?php echo $purchaser['user_email']; ?></small>
          </h2>

          <?php 
            $items = query_posts(array(
              'post_type' => 'purchased_item',
              'posts_per_page' => -1,
              'meta_key' => 'purchaser',
              'meta_value' => $purchaser,
              'orderby' => 'title',
              'order' => 'ASC',
            ));
          ?>
          <ul>
            <?php foreach ($items as $key => $week): ?>
              <?php
                if($key == 0) {
                  $first_ad = get_field('start', $week);
                }
              ?>
              <li>
                <form method="POST">
                  <input type="hidden" value="manual-copy" name="action">
                  <input type="hidden" value="<?php echo $purchaser['display_name']; ?>" name="user[name]">
                  <input type="hidden" value="<?php echo $purchaser['user_email']; ?>" name="user[email]">
                  <input type="hidden" value="<?php echo $week->ID ?>" name="week_id">
                  <input type="hidden" value="<?php echo get_field('start', $week); ?>" name="ad_date">
                  <button type="submit"  class="btn btn-sm btn-reminder">Reminder</button>
                  <?php 
                    echo date('F j', strtotime(get_field('start', $week)));
                    if(get_field('start', $week) != get_field('end', $week)) {
                      echo ' - ';
                      echo date('F j', strtotime(get_field('end', $week))); 
                    }
                  ?>
                </form>
              </li>
            <?php endforeach; ?>
          </ul>
        <form method="POST" style="display:inline-block;">
          <input type="hidden" value="manual-receipt" name="action">
          <input type="hidden" value="<?php echo $post->ID ?>" name="purchase_id">
          <input type="hidden" value="<?php the_field('amount_paid', $post->ID) ?>" name="paid">
          <input type="hidden" value="<?php echo $purchaser['display_name']; ?>" name="user[name]">
          <input type="hidden" value="<?php echo $purchaser['user_email']; ?>" name="user[email]">
          <input type="hidden" value="<?php the_field('stripe_id', $post->ID) ?>" name="transaction">
          <input type="hidden" value="<?php the_field('purchase_total', $post->ID) ?>" name="total">
          <?php foreach ($items as $key => $week): ?>
            <input type="hidden" value="<?php echo get_field('facebook_retargeting', $week) ? 'true' : 'false' ?>" name="items[<?php echo $key ?>][facebook]">
            <input type="hidden" value="<?php echo get_field('ab_testing', $week) ? 'true' : 'false' ?>" name="items[<?php echo $key ?>][ab]">
            <input type="hidden" value="<?php echo get_field('we_write_ads', $week) ? 'true' : 'false' ?>" name="items[<?php echo $key ?>][wewrite]">
            <input type="hidden" value="<?php echo date('F j', strtotime(get_field('start', $week))) ?>" name="items[<?php echo $key ?>][start]">
            <input type="hidden" value="<?php echo date('F j', strtotime(get_field('end', $week))) ?>" name="items[<?php echo $key ?>][end]">
          <?php endforeach; ?>
          <button type="submit" class="btn">Send Receipt</button>
        </form>

        <form method="POST" style="display:inline-block;">
          <input type="hidden" value="manual-payment" name="action">
          <input type="hidden" value="<?php echo $purchaser['display_name']; ?>" name="user[name]">
          <input type="hidden" value="<?php echo $purchaser['user_email']; ?>" name="user[email]">
          <input type="hidden" value="<?php echo $post->ID ?>" name="order_id">
          <input type="hidden" value="<?php echo $first_ad ?>" name="ad_date">
          <button type="submit" class="btn btn-reminder">Payment Reminder</button>
        </form>
      </div>
    <?php endforeach; ?>
  </div>
</div>
