<?php $sponsor = get_field('sponsor'); ?>
  <tr>
    <td>
      <?php $date = get_field('date', false, false); $date = new DateTime($date); ?>
      <span class="date"><?php echo $date->format('M j, Y'); ?></span>
    </td>
    <td>
      <a href="<?php echo get_author_posts_url( $sponsor['ID'], $sponsor['user_nicename'] ); ?>">
        <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 30, 'h' => '30' )); ?>
        <strong><?php echo $sponsor['display_name'] ?></strong>
      </a>
    </td>
    <td>
      <a href="<?php the_permalink(); ?>" class="report-row">
          <?php the_title(); ?>
      </a>
    </td>
  </tr>
