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
      $due = date_format($date, 'F, j Y');
      
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
            if($day['descriptor'] != '' && $day['copy'] != '' && $day['link'] != '') {
              $indicator = 'fa-check';
            } else {
              $indicator = 'fa-minus';
            }
        ?>
          <a class="tab" href="#key<?php echo $key ?>"><i class="far fa-fw <?php echo $indicator; ?>"></i> <?php echo date_format($date, 'M j') ?></a>
        <?php endforeach ?>
      </div>
      <div id="panels">
        <?php foreach ($days as $key=>$day): $date = new DateTime($day['date']); ?>
          <div class="panel" id="key<?php echo $key ?>">
            <form enctype="multipart/form-data" method="post">
              <h2 style="margin-top:0;"><?php echo date_format($date, 'l, F j') ?></h2>
              <?php
                // disable field and show notice if within 12 hours of ad day
                $disable = ( date_format($date, 'U') - time() < 60*60*12 ) ? 'disabled' : '' ;
                if ($disable == 'disabled') echo "
                  <div class='error'>
                    This ad is in production and cannot be edited further. For emergency changes, please contact Morning Chalk Up at info@morningchalkup.com
                  </div>
                ";
              ?>
              <p><label for="descriptor">Descriptor</label><br>
                <input <?php echo $disable ?> class="addescriptor" type="text" name="descriptor" value="<?php echo $day['descriptor'] ? : 'powered by' ?>" placeholder="powered by" id="descriptor">
              </p>
              
              <p><label>Link</label><br>
                <input <?php echo $disable ?> type="text" name="link" value="<?php echo $day['link'] ?>" placeholder="http://www.morningchalkup.com" id="link">
              </p>
          
              <p><label>Ad Copy <?php echo get_field('ab_testing') ? 'A' : '' ?></label><small class="charCount"></small><br>
                <textarea rows="6" class="adtextarea" <?php echo $disable ?> name="ad" style="width:100%"><?php echo $day['copy']; ?></textarea>
                <small>Use [ ] around the text you want us to apply your link to. For best results, blah blah</small>
              </p>
            
              <?php if(get_field('ab_testing')) : ?>
                <p><label>Ad Copy B</label><br>
                  <textarea <?php echo $disable ?> name="ad" style="width:100%"></textarea>
                  <small>Use [ ] around the text you want us to apply your link to. For best results, blah blah</small>
                </p>
              <?php endif; ?>
          
              <input type="submit" value="Save"/>
              
              <?php wp_nonce_field( 'update-ads' ) ?>

              <input type="hidden" name="row" value="<?php echo $key + 1; ?>">
              <input type="hidden" name="post" value="<?php echo get_the_ID(); ?>">
              <input name="honey-name" value="" type="text" style="display:none;"></input>
              <input name="action" type="hidden" id="action" value="update-ads" />

            </form>
            <div class="preview">
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px; font-family:Roboto, sans-serif">
                <tr>
                  <td align="left" style="padding: 20px 10px 20px 25px;font-size:12px"><a style="color:#3d5ba9" href="#" ><span style="color:#3d5ba9">Send us a tip!</span></a></td>
                  <td align="right" style="padding: 20px 25px 20px 10px;font-size:12px"><?php echo date_format($date, 'l, F j') ?></td>
                </tr>
              </table>
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
                <tr>
                  <td style="padding: 20px 25px 0; text-align: center">
                    <img src="<?php bloginfo('stylesheet_directory') ?>/resources/images/mcu.svg" width="320" alt="Morning Chalk Up" border="0" align="center" style="max-width: 100%; height: auto; font-family: Roboto, sans-serif; font-size: 24px; line-height: 36px; color: #555555; margin: auto;" class="g-img">
                  </td>
                </tr>
              </table>
              <table role="presentation" cellspacing="0" cellpadding="0" border="0" align="center" width="100%" style="max-width: 600px;">
                <tr>
                  <td bgcolor="#ffffff">
                    <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
                      <tr>
                        <td style="padding: 40px 25px 10px; font-family: Roboto, sans-serif; font-size: 16px; line-height: 24px; color: #333132;">
                          <?php $author = wp_get_current_user(); ?>
                          <p>Good morning and welcome to the <span style="font-weight:bold;">Morning Chalk Up</span>. Today's edition is <span class="desctarget"></span> <strong><?php echo $author->display_name; ?></strong>. <span class="target"></span></p>
                        </td>
                      </tr>
                      <?php
                        $quotes = array(
                          '"All I do is win, win, win no matter what. Got money on my mind, I could never get enough. Every time I step into the building everybody hands go up..." - Mat Fraser',
                          '"I come from a land down under. Where beer does flow and men chunder. Can\'t you hear, can\'t you hear the thunder?" - Tia Clair Toomey',
                          '"If I was you, I\'d wanna be me too." - Brooke Wells',
                        );
                        shuffle($quotes);
                      ?>
                      <tr>
                        <td style="padding: 40px 25px 15px 25px; font-family: Roboto, sans-serif; color: #333132; font-weight: bold;font-size: 18px; line-height: 18px;letter-spacing:2px">
                            QUOTE OF THE DAY
                        </td>
                      </tr>
                      <tr>
                        <td style="padding: 0px 25px 40px; font-family: Roboto, sans-serif; font-size: 16px; line-height: 24px; color: #333132;">
                            <multiline label='Quote of the Day'>
                                <p><em><?php echo $quotes[0] ?></em></p>
                            </multiline>
                            <div style="font-size:12px;text-align: right;"><a style="color:#3d5ba9" href="mailto:tips@morningchalkup.com?subject=Here's%20a%20quote!" target="_blank"><span style="color:#3d5ba9">+ Send us your favorite quote.</span></a></div>
                        </td>
                      </tr>
                    </table>
                  </td>
                </tr>
              </table>
              
            </div>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>