<?php if ( $not_found ) : ?>
  <h3>No Reports</h3>
<?php else: ?>
  <tr>
    <td>
      <?php $date = get_field('date', false, false); $date = new DateTime($date); ?>
      <span class="date hidden-phone"><?php echo $date->format('M j, Y'); ?></span>
      <span class="date visible-phone"><?php echo $date->format('n/j/y'); ?></span>
    </td>
    <td>
      <a href="<?php the_permalink(); ?>" class="report-row">
          <?php the_title(); ?>
      </a>
    </td>
  </tr>
<?php endif; ?>