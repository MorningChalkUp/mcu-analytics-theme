<?php if ( $not_found ) : ?>
  <h3>No Reports</h3>
<?php else: ?>
  <tr>
    <td><span class="date"><?php the_field('date'); ?></span></td>
    <td>
      <a href="<?php the_permalink(); ?>" class="report-row">
          <?php the_title(); ?>
      </a>
    </td>
  </tr>
<?php endif; ?>