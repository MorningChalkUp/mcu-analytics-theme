<?php foreach( get_field('days') as $day ) : ?>
  <tr>
    <td valign="top"><h5><?php echo $day['date']; ?></h5></td>
    <td>
      <?php if (get_field('ab_testing')) echo "<h5>VERSION A</h5>" ?>
      <?php
        $copy = str_replace('[', "<a href='{$day['link']}'>", $day['copy'] );
        $copy = str_replace(']', "</a>", $copy );
        $copy = str_replace('
', "<br />", $copy );
         
        $copyb = str_replace('[', "<a href='{$day['link']}'>", $day['copy_b'] );
        $copyb = str_replace(']', "</a>", $copyb );
        $purchaser = get_field('purchaser');
      ?>
        <?php fn::log($copy) ?>
        <p>Good morning and welcome to the <span style="font-weight:bold;">Morning Chalk Up</span>. Today's edition is <?php echo $day['descriptor'] ?> <span style="font-weight:bold;"><?php echo $purchaser['display_name'] ?></span><?php echo ($copy) ?></p>
      <?php if (get_field('ab_testing')) : ?>
        <hr>
        <h5>VERSION B</h5>
        <p>Good morning and welcome to the <span style="font-weight:bold;">Morning Chalk Up</span>. Today's edition is <?php echo $day['descriptor'] ?> <span style="font-weight:bold;"><?php echo $purchaser['display_name'] ?></span><?php echo ($day['copy_b']) ?></p>
      <?php endif; ?>
    </td>
  </tr>
  
<?php endforeach; ?>