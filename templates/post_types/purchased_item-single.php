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

    <div id="ad-manager">
      <?php $days = get_field('days') ?>
      <div id="tabs">
        <?php 
          foreach ($days as $key=>$day): 
            $date = new DateTime($day['date']);
            if($day['copy'] != '' && $day['link'] != '') {
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
								// edited to be 6 hours for hotfix on late add.
                $disable = ( date_format($date, 'U') - time() < 60*60*6 ) ? 'disabled' : '' ;
                if ($disable == 'disabled') echo "
                  <div class='error'>
                    This ad is in production and cannot be edited further. For emergency changes, please contact Morning Chalk Up at info@morningchalkup.com
                  </div>
                ";
              ?>
              
              <p style="margin-bottom:0"><label for="descriptor">Descriptor</label></p>
              <div class="select-outline"><select <?php echo $disable ?> class="addescriptor" id="descriptor" name="descriptor">
                <option value="brought to you by" <?php echo $day['descriptor'] == 'brought to you by' ? 'selected' : '' ?>>Brought to you by</option>
                <option value="built by" <?php echo $day['descriptor'] == 'built by' ? 'selected' : '' ?>>Built by</option>
                <option value="fueled by" <?php echo $day['descriptor'] == 'fueled by' ? 'selected' : '' ?>>Fueled by</option>
                <option value="powered by" <?php echo $day['descriptor'] == 'powered by' ? 'selected' : '' ?>>Powered by</option>
                <option value="sponsored by" <?php echo $day['descriptor'] == 'sponsored by' ? 'selected' : '' ?>>Sponsored by</option>
              </select><i class="fal fa-angle-down"></i></div>
              
              
              <p><label>Link</label><br>
                <input <?php echo $disable ?> type="text" name="link" value="<?php echo $day['link'] ?>" placeholder="http://www.morningchalkup.com" id="link">
              </p>
          
              <p id="copya"><label>Ad Copy <?php echo get_field('ab_testing') ? 'A' : '' ?></label><small class="charCount"></small><br>
                <textarea rows="6" class="adtextarea" data-label="Ad Copy A" <?php echo $disable ?> name="ad" style="width:100%"><?php echo htmlentities($day['copy']); ?></textarea>
                <small>Place [ ] around the text you want to hyperlink.</small>
              </p>
            
              <?php if(get_field('ab_testing')) : ?>
                <p id="copyb"><label>Ad Copy B</label><small class="charCount"></small><br>
                  <textarea rows="6" class="adtextarea" data-label="Ad Copy B" <?php echo $disable ?> name="ad_b" style="width:100%"><?php echo htmlentities($day['copy_b']); ?></textarea>
                  <small>Place [ ] around the text you want to hyperlink.</small>
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
              <?php if(get_field('ab_testing')) : ?><h3 class="center-text" style="margin-bottom:0"><span class="preview-label"></span></h3><?php endif; ?>
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
                          <p>Good morning and welcome to the <span style="font-weight:bold;">Morning Chalk Up</span>. Today's edition is <span class="desctarget"></span> <strong><?php echo $author->display_name; ?></strong>.</p>
                          <p><span class="target"></span></p>
                        </td>
                      </tr>
                      <?php
                        $quotes = array(
                          '"We give up things we love for things we love even more."  -- Craig Groeschel',
                          '"Success is not final, failure is not fatal: it is the courage to continue that counts." -- Winston Churchill',
                          '"You can have everything in life you want if you will just help enough other people get what they want." -- Zig Ziglar',
                          '"I have already settled it for myself, so flattery and criticism go down the same drain and I am quite free." -- Georgia O\'Keefe',
                          '"Discipline is always attractive." -- Joe Duncan',
                          '"It\'s kind of fun to do the impossible." -- Walt Disney',
                          '“You wouldn’t worry so much about what others think of you if you realized how seldom they do.” -- Eleanor Roosevelt',
                          '"When everything seems to be going against you, remember that the airplane takes off against the wind, not with it." -- Henry Ford',
                          '“Be so good they can’t ignore you.” -- Steve Martin ',
                          '“There is no limits to what a man can accomplish if he’s unwilling to take credit for it.” - Ronald Reagan',
                          '"I\'m going to work so that it\'s a pure guts race at the end, and if it is, I am the only one who can win it." -- Steve Prefontaine',
                          '"Be quick, but don\'t hurry." -- John Wooden',
                          '"Indecision is the thief of opportunity." -- Jim Rohn',
                          '"For the strength of the Pack is the Wolf and the strength of the Wolf is the Pack." -- Rudyard Kipling',
                          '"You have to be odd to be number one." -- Dr. Seuss',
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