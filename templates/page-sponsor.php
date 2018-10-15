<?php /* Template Name: Sponsor */ ?>

<div class="section">
  <div class="wrapper">
    <h2>Sponsorships</h2>
    <div id="purchasebox">
      <div id="products">
        <h3><i class="far fa-calendar-alt"></i></h3>
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
                  if ( date('M',$start) == date('M',$end) ){
                    $range = date('M',$start).' '.date('d',$start).' - '.date('d',$end);
                  } else {
                    $range = date('M',$start).' '.date('d',$start).' - '.date('M',$end).' '.date('d',$end);
                  }
                  if($week['availability'] == 'available'){
                    $tooltip = false;
                  } elseif ($week['availability'] == 'purchased'){
                    $tooltip = 'Purchased';
                  } else {
                    $tooltip = 'Not for Sale';
                  }
                ?>
                <a href="#" class="purchase-btn" data-status="<?php echo $week['availability'] ?>" data-price="<?php echo $week['price'] ?>" <?php if($tooltip) echo "title='$tooltip'"?> ><?php echo $range ?></a>
              <?php endforeach; ?>
            </div>
            <?php
          endforeach;
        ?>
      </div>
      <div id="cart">
        <h3><i class="far fa-shopping-cart"></i></h3>
        <div class="cart-item">
          <h4>Title Here <span class="price">$2100</span></h4>
          <div class="inside">
            <p>Notes here</p>
            <h5>Add-ons:</h5>
            <ul class="add-ons">
              <li><input type="checkbox" id="facebook"/> <label for="facebook">Facebook Retargeting</label> <span class="price">+ $250</span></li>
              <li><input type="checkbox" id="ab"/> <label for="ab">A/B Testing</label> <span class="price">+ $250</span></li>
              <li><input type="checkbox" id="wewrite"/> <label for="wewrite">We Write Your Ads</label> <span class="price">+ $250</span></li>
            </ul>
          </div>
        </div>
        <div id="checkout">
          <span class="total">Total: $3000</span>
          
          <script src="https://checkout.stripe.com/checkout.js"></script>

          <button id="customButton" class="btn">Checkout</button>

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

          document.getElementById('customButton').addEventListener('click', function(e) {
            // Open Checkout with further options:
            handler.open({
              name: 'Parapxl Corp',
              description: '2 widgets',
              amount: 2000
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