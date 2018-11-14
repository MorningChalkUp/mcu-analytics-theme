<div class="section">
  <div class="wrapper">
    <?php
      $start = strtotime(get_field('start'));
      $end = strtotime(get_field('end'));
      $class = '';
      if ( date('M j',$start) == date('M j',$end) ){
        $range = date('M',$start).' '.date('j',$start);
        $class = 'single-day';
      } else if ( date('M',$start) == date('M',$end) ){
        $range = date('M',$start).' '.date('j',$start).' - '.date('j',$end);
      } else {
        $range = date('M',$start).' '.date('j',$start).' - '.date('M',$end).' '.date('j',$end);
      }
    ?>
    <h2>Your ads for <strong><?php echo $range ?></strong></h2>
    
    <?php
      $purchase = get_field('purchase_id');
      $paid = get_field('amount_paid',$purchase);
      $total = get_field('purchase_total',$purchase);
      $date = new DateTime(get_the_date());
      date_add($date, date_interval_create_from_date_string('30 days'));
      $due= date_format($date, 'F, j Y');
      
      if( $paid < $total){
        $unpaid = $total - $paid;
        echo "
          <div class='error'>
            There is a remaining balance of $$unpaid on this $$total purchase due by <strong>$due</strong>. 
            <a class='btn'>Pay Balance</a>
          </div>
        ";
      }
    ?>

    <div id="ad-manager">
      <?php $days = get_field('days') ?>
      <div id="tabs">
        <?php 
          foreach ($days as $key=>$day): 
            $date = new DateTime($day['date']); 
            // we need to determine if the fields are complete here so we can restyle the tabs
            // swap <i class="far fa-fw fa-minus"></i> for <i class="far fa-fw fa-check"></i>
        ?>
          <a class="tab" href="#key<?php echo $key ?>"><i class="far fa-fw fa-minus"></i> <?php echo date_format($date, 'M j') ?></a>
        <?php endforeach ?>
      </div>
      <div id="panels">
        <?php foreach ($days as $key=>$day): $date = new DateTime($day['date'])?>
          <div class="panel" id="key<?php echo $key ?>">
            <form>
              <h2 style="margin-top:0;"><?php echo date_format($date, 'l, F j') ?></h2>
              <p><label for="descriptor">Descriptor</label><br>
                <input type="text" name="descriptor" value="powered by" placeholder="powered by" id="descriptor">
              </p>
          
              <p><label>Ad Copy</label><br>
                <textarea name="ad" style="width:100%"></textarea>
              </p>
            
              <?php if(get_field('ab_testing')) : ?>
                <p><label>Ad Copy</label><br>
                  <textarea name="ad" style="width:100%"></textarea>
                </p>
              <?php endif; ?>
            
              <p><label>Link</label><br>
                <input type="text" name="link" value="" placeholder="http://www.morningchalkup.com" id="link">
              </p>
          
              <p><label>Hyperlinked Text</label><br>
                <input type="text" name="link_text" value="" placeholder="learn more" id="link_text">
              </p>
              <input type="submit" value="Save"/>
            </form>
          
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>