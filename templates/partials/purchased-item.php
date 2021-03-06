<tr>
  <?php
    $start = strtotime(get_field('start'));
    $end = strtotime(get_field('end'));
    if ( date('M j',$start) == date('M j',$end) ){
      $range = date('F j, Y',$start);
    } else {
      $range = date('F j',$start).' - '.date('F j, Y',$end);
    }
  ?>
  <td><a href="<?php the_permalink() ?>"><?php echo $range ?></a></td>
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
    <?php $days = get_field('days');
      $written_days = 0;
      foreach ($days as $key => $day) {
        if($day['copy'] != '' && $day['link'] != '') {
          ++$written_days;
        }
      }
    ?>

    <?php if (count($days) == $written_days): ?>
      <span class="status on" data-tooltip="Written"><i class="far fa-check fa-fw"></i></span>
    <?php elseif ($written_days > 0): ?>
      <span class="status partial" data-tooltip="In Progress"><i class="far fa-exclamation-circle fa-fw"></i></span>
    <?php else: ?>
      <span class="status warning" data-tooltip="Not Written"><i class="far fa-exclamation-triangle fa-fw"></i></span>
    <?php endif; ?>  
    
  </td>
</tr>
