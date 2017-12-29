<?php $sponsor = get_field('sponsor'); ?>
  <tr>
    <td><span class="date"><?php the_field('date'); ?></span></td>
    <td>
      <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 30, 'h' => 'auto' )); ?>
      <strong><?php echo $sponsor['display_name'] ?></strong>
    </td>
    <td>
      <a href="<?php the_permalink(); ?>" class="report-row">
          <?php the_title(); ?>
      </a>
    </td>
  </tr>
