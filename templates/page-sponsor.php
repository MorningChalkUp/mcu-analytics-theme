<?php /* Template Name: Sponsor */ ?>
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
  <div class="wrapper">
    <h2>Sponsor the Morning Chalk Up</h2>
    <div id="purchasebox">
      <div id="products">
        <h3><i class="far fa-calendar-alt"></i></h3>
        <div>
          <p>Below is a list of available advertising inventory on the Morning Chalk Up. Grayed out items have already been reserved. More inventory may be released at a later date.</p>
          <p>For a full breakdown of current audience, the sponsorship program, and add on features download our 2019 sponsorship guide.</p>
          <p>If you have any questions, please email <a href="mailto:justin@morningchalkup.com">Justin@morningchalkup.com</a>.</p>
          <hr>
        </div>
        
        <?php
          $weeks = get_field('weeks','options');
          $months = array();
          foreach($weeks as $week){
            $month = date('M',strtotime($week['start'])).' '.date('Y',strtotime($week['start']));
            $months[$month][] = $week;
          }
          foreach($months as $key=>$month):
            ?>
            <div class="month">
              <h4 class="label"><?php echo $key ?></h4>
              <?php foreach ($month as $week) : ?>
                <?php
                  $start = strtotime($week['start']);
                  $end = strtotime($week['end']);
                  $class = '';
                  if ( date('M j',$start) == date('M j',$end) ){
                    $range = date('M',$start).' '.date('j',$start);
                    $class = 'single-day';
                  } else if ( date('M',$start) == date('M',$end) ){
                    $range = date('M',$start).' '.date('j',$start).' - '.date('j',$end);
                  } else {
                    $range = date('M',$start).' '.date('j',$start).' - '.date('M',$end).' '.date('j',$end);
                  }
                  
                  if($week['availability'] == 'available'){
                    $tooltip = false;
                    $disabled = '';
                  } else {
                    $tooltip = $week['availability'];
                    $disabled = 'disabled';
                  }

                  if( isset($week['purchaser']['ID']) && isset($user->ID) && $week['purchaser']['ID'] == $user->ID ) {
                    $purchaser = 'purchaser';
                  } else {
                    $purchaser = '';
                  }

                ?>
                <input <?php echo $disabled ?> class="purchase-checkbox <?php echo $purchaser ?>" id="<?php echo $start ?>" type="checkbox" data-id="<?php echo $start ?>" data-status="<?php echo $week['availability'] ?>" data-price="<?php echo $week['price'] ?>" data-range="<?php echo $range ?>" data-notes="<?php echo $week['notes'] ?>" data-start="<?php echo date('n/j/Y', strtotime($week['start'])) ?>" data-end="<?php echo date('n/j/Y', strtotime($week['end'])) ?>" />
                <label class="<?php echo $class ?> purchase-checklabel" for="<?php echo $start ?>"><?php echo $range ?> <span><?php echo '$'.$week['price'] ?></span></label>
              <?php endforeach; ?>
            </div>
            <?php
          endforeach;
        ?>
      </div>
      <div id="cart" data-user="<?php echo $user_email; ?>" data-key="<?php echo $stripe_key; ?>">
        <h3><i class="far fa-shopping-cart"></i></h3>
        <div id="list"></div>
        <div id="checkout">
          <p class="total">Total: $<span id="amt">0</span></p>
          <?php if(is_user_logged_in()): ?>
            <button id="depositButton" class="btn" data-total="0">20% Deposit</button>
            <button id="checkoutButton" class="btn" data-total="0">Pay in Full</button>
          <?php else: ?>
            <a id="createAccount" href="/create-account/" class="btn">Create Account</a>
          <?php endif; ?>
        </div>
      </div>
      
    </div>
  </div>
</div>