<?php /* Template Name: Sponsored Links */ ?>
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

    <?php if( isset($_GET['r']) && $_GET['r'] == 'f' ): ?>
      <div class='error'>
        There was a problem with your transaction: <?php echo $_GET['msg']; ?>
      </div>
    <?php endif; ?>
    
    <div id="purchasebox">
      <div id="products">
        <h3><i class="far fa-calendar-alt"></i></h3>
        <?php if (get_the_content() != ''): ?>
          <div>
            <?php the_content(); ?>
            <hr>
          </div>
        <?php endif; ?>
        
        <?php
          $days = get_field('links','options');
          // var_dump($days);
          $months = array();
          foreach($days as $day){
            $month = date('M',strtotime($day['day'])).' '.date('Y',strtotime($day['day']));
            $months[$month][] = $day;
          }
          foreach($months as $key=>$month):
            ?>
            <?php 
              $empty = true;
              foreach ($month as $day) {
                if ( $day['availability'] != 'not_for_sale' ) {
                  $empty = false;
                  break;
                }
              }
            ?>
            <?php if ( !$empty ): ?>
              <div class="month">
                <h4 class="label"><?php echo $key ?></h4>
                <?php foreach ($month as $day) : ?>
                  <?php if ( $day['availability'] != 'not_for_sale' ): ?>
                    <?php
                      $start = strtotime($day['day']);
                      $range = date('M',$start).' '.date('j',$start);
                      $class = 'single-day';
                      
                      if($day['availability'] == 'available'){
                        $tooltip = false;
                        $disabled = '';
                      } else {
                        $tooltip = $day['availability'];
                        $disabled = 'disabled';
                      }
                      if( $user != null && $day['purchaser']['ID'] == $user->ID ) {
                        $purchaser = 'purchaser';
                      } else {
                        $purchaser = '';
                      }
                    ?>
                    <input <?php echo $disabled ?> class="purchase-checkbox <?php echo $purchaser ?>" id="<?php echo $start ?>" type="checkbox" data-id="<?php echo $start ?>" data-status="<?php echo $day['availability'] ?>" data-price="<?php echo $day['price'] ?>" data-range="<?php echo $range ?>" data-notes="<?php echo $day['notes'] ?>" data-start="<?php echo date('n/j/Y', strtotime($day['day'])) ?>" data-end="<?php echo date('n/j/Y', strtotime($day['day'])) ?>" />
                    <label class="<?php echo $class ?> purchase-checklabel" for="<?php echo $start ?>"><?php echo $range ?> <span><?php echo '$'.$day['price'] ?></span></label>
                  <?php endif; ?>
                <?php endforeach; ?>
              </div>
            <?php endif; ?>
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
            <button id="checkoutButton" class="btn" data-total="0">Pay in Full</button>
          <?php else: ?>
            <a id="createAccount" href="/create-account/" class="btn">Create Account</a>
          <?php endif; ?>
        </div>
      </div>
      
    </div>
  </div>
</div>