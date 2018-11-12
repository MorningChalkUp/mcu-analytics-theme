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
    <h2>Draft your ads for <strong><?php echo $range ?></strong></h2>
    <div id="ad-manager">
      <?php $days = get_field('days') ?>
      <div id="tabs">
        <?php foreach ($days as $day): ?>
          <a href="#"><?php echo $day['date'] ?></a>
        <?php endforeach ?>
      </div>
      <div id="panels">
        <?php foreach ($days as $day): ?>
          <div class="panel">
          
            <h4 class="label">Jan 14</h4>
            <p><label for="descriptor">Descriptor</label><br>
              <input type="text" name="descriptor" value="powered by" placeholder="powered by" id="descriptor">
            </p>
          
            <p><label>Ad Copy</label><br>
              <textarea style="width:100%"></textarea>
            </p>
          
            <p><label>Link</label><br>
              <input type="text" name="link" value="" placeholder="http://www.morningchalkup.com" id="link">
            </p>
          
            <p><label>Hyperlinked Text</label><br>
              <input type="text" name="link_text" value="" placeholder="learn more" id="link_text">
            </p>
          
            <hr>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
</div>