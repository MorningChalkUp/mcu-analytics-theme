<?php /* Template Name: Sponsor */ ?>

<div class="section">
  <div class="wrapper">
    <h2>Sponsorships</h2>
    <div id="purchasebox">
      <div id="products">
        <h3><i class="far fa-calendar-alt"></i></h3>
        <?php
          $weeks = get_field('weeks','options');
          // here is where we need to do some validation if user is logged in.
          // 1. check how many weeks have been purchased by user. limit user to 5 total for 2019
          // 2. set weeks adjacent to purchased weeks as unavailable
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
                  if ( date('M',$start) == date('M',$end) ){
                    $range = date('M',$start).' '.date('d',$start).' - '.date('d',$end);
                  } else {
                    $range = date('M',$start).' '.date('d',$start).' - '.date('M',$end).' '.date('d',$end);
                  }
                  
                  if($week['availability'] == 'available'){
                    $tooltip = false;
                    $disabled = '';
                  } else {
                    $tooltip = $week['availability'];
                    $disabled = 'disabled';
                  }
                ?>
                <?php /* ?><a href="#" class="purchase-btn" data-status="<?php echo $week['availability'] ?>" data-price="<?php echo $week['price'] ?>" <?php if($tooltip) echo "title='$tooltip'"?> ><?php echo $range ?></a>php */?>
                <input <?php echo $disabled ?> class="purchase-checkbox" id="<?php echo $start ?>" type="checkbox" data-id="<?php echo $start ?>" data-status="<?php echo $week['availability'] ?>" data-price="<?php echo $week['price'] ?>" data-range="<?php echo $range ?>" />
                <label class="purchase-checklabel" for="<?php echo $start ?>"><?php echo $range ?></label>
              <?php endforeach; ?>
            </div>
            <?php
          endforeach;
        ?>
      </div>
      <div id="cart">
        <h3><i class="far fa-shopping-cart"></i></h3>
        <div id="list">
        </div>
        <div id="checkout">
          <span class="total">Total: $<span id="amt">0</span></span>
          
          <script src="https://checkout.stripe.com/checkout.js"></script>

          <button id="checkoutButton" class="btn" data-total="0">Checkout</button>

          <script>
            var handler = StripeCheckout.configure({
              key: 'pk_c1RxlK2387fUBDHZ5qOvSupF9DY0b',
              image: 'https://stripe.com/img/documentation/checkout/marketplace.png',
              locale: 'auto',
              token: function(token) {
                // You can access the token ID with `token.id`.
                // Get the token ID to your server-side code for use.
              }
            });

            document.getElementById('checkoutButton').addEventListener('click', function(e) {
              // Open Checkout with further options:
              handler.open({
                name: 'MCU Sponsorship',
                description: '-',
                amount: jQuery('#customButton').data('total'),
              });
              e.preventDefault();
            });

            // Close Checkout on page navigation:
            window.addEventListener('popstate', function() {
              handler.close();
            });
          </script>
        </div>
      </div>
      
    </div>
  </div>
</div>