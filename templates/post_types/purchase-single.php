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
      <h3 style="margin-top:0"><?php the_title(); ?></h3>
      <div class="payment" style="margin-bottom: 1rem;">
        $<?php the_field('amount_paid') ?> / $<?php the_field('purchase_total') ?> Paid
      </div>
      <?php if( get_field('amount_paid') != get_field('purchase_total') ) : ?>
        <div class="balance">
          <button id="balanceBtn" data-purchase="<?php echo get_the_ID(); ?>" data-key="<?php echo $stripe_key ?>" data-balance="<?php echo get_field('purchase_total') - get_field('amount_paid') ?>" data-total="<?php the_field('purchase_total'); ?>" data-user="<?php echo $user_email; ?>" class='btn'>Pay Balance</button>
        </div>
      <?php endif; ?>
    </div>
    
  </div>
</div>