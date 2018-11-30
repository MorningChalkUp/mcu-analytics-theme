<tr>
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
  <td><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></td>
  <td align="right">
    <?php $purchase_id = get_field('purchase_id'); ?>
    <?php 
      if(get_field('purchase_total',$purchase_id) == get_field('amount_paid', $purchase_id)) {
        $paid = 'on';
        $paid_for = 'Paid For';
      } else {
        $paid = 'off';
        $paid_for = '$'.get_field('amount_paid', $purchase_id).' / $'.get_field('purchase_total',$purchase_id).' paid';
      }
    ?>
    <span class="status <?php echo $paid ?>" data-tooltip="<?php echo $paid_for ?>"><i class="far fa-dollar-sign"></i></span>
    <span class="status on" data-tooltip="Written"><i class="far fa-check"></i></span>
      
    
  </td>
</tr>
