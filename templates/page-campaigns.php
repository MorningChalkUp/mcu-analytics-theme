<?php /* Template Name: Campaigns */ ?>
<div class="section">
  <div class="wrapper">
    <h2 class="section-title">
      <?php the_title() ?>
    </h2>
    <table>
    <?php
      $campaigns = mcu_get_campaigns();
      foreach ($campaigns as $campaign):
        //fn::put($campaign);
    ?>
      <tr>
        <td><?php echo date_format(date_create($campaign->SentDate),"n/j/Y") ?></td>
        <td><?php echo $campaign->Subject ?></td>
        <td><?php echo $campaign->CampaignID ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
  </div>
</div>