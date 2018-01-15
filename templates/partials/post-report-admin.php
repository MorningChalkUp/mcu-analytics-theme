<?php $sponsor = get_field('sponsor'); ?>
  <tr>
    <td>
      <?php $date = get_field('date', false, false); $date = new DateTime($date); ?>
      <span class="date"><?php echo $date->format('M j, Y'); ?></span>
    </td>
    <td>
      <?php //$logo = get_field('logo','user_'.$sponsor['ID']); ?>
      <!-- <img src="<?php //echo $logo['url'] ?>" width="30" height="30"/> -->
      <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 30, 'h' => 'auto' )); ?>
      <strong><?php echo $sponsor['display_name'] ?></strong>
    </td>
    <td>
      <a href="<?php the_permalink(); ?>" class="report-row">
          <?php the_title(); ?>
      </a>
    </td>
  </tr>
