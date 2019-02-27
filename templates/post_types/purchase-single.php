<?php 
  if (is_user_logged_in()) {
    $user = get_userdata( get_current_user_id() );
    $user_email = $user->user_email; 
  } else {
    $user = null;
    $user_email = '';
  }
  if( get_field('mode', 'options') == 'test' ) {
    $stripe_key = get_field( 'stripe_test_publishable_key','options' );
  } elseif ( get_field('mode', 'options') == 'live' ) {
    $stripe_key = get_field( 'stripe_live_publishable_key','options' );
  } else {
    $stripe_key = 'pk_test_TYooMQauvdEDq54NiTphI7jx';
  }
?>

<div class="section">
  <div class="wrapper-tight">

		<?php
      $purchase = get_the_ID();
      $paid = get_field('amount_paid');
      $total = get_field('purchase_total');
      $date = new DateTime(get_the_date());
      date_add($date, date_interval_create_from_date_string('30 days'));
      $due = date_format($date, 'F, j Y');
    ?>
      
    <?php if( $paid < $total) : ?>
      <?php $unpaid = $total - $paid; ?>
      <div class='error'>
        There is a remaining balance of $<?php echo $unpaid ?> on this $<?php echo $total ?> purchase due by <strong><?php echo $due ?></strong>. 
        <button id="balanceBtn" data-purchase="<?php echo $purchase ?>" data-key="<?php echo $stripe_key ?>" data-balance="<?php echo $unpaid ?>" data-total="<?php echo $total ?>" class='btn'>Pay Balance</button>
      </div>
    <?php endif; ?>

    <?php if( isset($_GET['r']) && $_GET['r'] == 's' ): ?>
      <div class='success'>
        Thank you for your payment!
      </div>
    <?php endif; ?>

    <?php if( isset($_GET['r']) && $_GET['r'] == 'f' ): ?>
      <div class='error'>
        There was a problem with your payment: <?php echo $_GET['msg']; ?>
      </div>
    <?php endif; ?>

    <div class="box">
			<p>
				<?php the_date(); ?><br>
				Order #<?php echo the_ID(); ?>
			</p>
			<p><?php echo get_field('purchaser')['display_name'] ?>,</p>
			<p>Thank you for reserving a sponsorship with the Morning Chalk Up.</p>
			<p>Here are the details of your order:</p>
			<?php 
        $items = query_posts(array(
          'post_type' => 'purchased_item',
          'posts_per_page' => -1,
          'meta_key' => 'purchase_id',
          'meta_value' => get_the_ID(),
          'orderby' => 'title',
          'order' => 'ASC',
        ));
      ?>
			<?php foreach ($items as $item): ?>
				<h3>
					Morning Chalk Up Sponsorship - 
					<?php 
						echo date('F j, Y', strtotime(get_field('start', $item))); 
						if(get_field('start', $item) != get_field('end', $item)) {
							echo ' - ';
							echo date('F j, Y', strtotime(get_field('end', $item))); 
						}
					?>
				</h3>
				<?php if(get_field('facebook_retargeting', $item) || get_field('ab_testing', $item) || get_field('we_write_ads', $item)): ?>
					<ul>
						<?php if(get_field('facebook_retargeting', $item)) echo "<li>Facebook Retargeting</li>";  ?>
						<?php if(get_field('ab_testing', $item)) echo "<li>A/B Testing</li>"; ?>
						<?php if(get_field('we_write_ads', $item)) echo "<li>We Write Ads</li>"; ?>
					</ul>
        <?php endif; ?>
				<hr>
			<?php endforeach; ?>

			<div class="text-right">
				<div class="total">
						Grand Total: $<?php the_field('purchase_total') ?>
				</div>
				<div class="balance">
						Balance Due: $<?php echo get_field('purchase_total') - get_field('amount_paid'); ?>
				</div>
			</div>
		</div>
	</div>
</div>