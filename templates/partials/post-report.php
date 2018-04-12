<?php if ( $not_found ) : ?>
  <h3>No Reports</h3>
<?php else: ?>
  <tr>
    <?php if (current_user_can( 'manage_options' )): $sponsor = get_field('sponsor'); ?>
      <td class="avatar">
        <a title="<?php echo $sponsor['display_name'] ?>" href="<?php echo get_author_posts_url( $sponsor['ID'], $sponsor['user_nicename'] ); ?>">
          <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 30, 'h' => '30' )); ?>
        </a>
      </td>
    <?php endif; ?>
    <td>
      <?php $date = get_field('date', false, false); $date = new DateTime($date); ?>
      <div class="date"><?php echo $date->format('n/j/y'); ?></div>
      <h4 class="nomar"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
    </td>
    <td class="num" align="right">
      <?php 
        $recipients = get_field('recipients') ? : '1';
        $or = get_field('opens')/$recipients;
        echo (round(($or*10000))/100).'%'
      ?>
    </td>
    <td class="num" align="right">
      <?php echo number_format(floatval(get_field('opens'))); ?>
    </td>
    <td class="num" align="right">
      <?php echo number_format(floatval(get_field('clicks'))); ?>
    </td>
  </tr>
<?php endif; ?>