<?php /* Template Name: Campaigns */ ?>
<div class="section">
  <div class="wrapper">
    <h2 class="section-title">
      <?php the_title() ?>
    </h2>
    <hr>
    <table>
    <?php
      $campaigns = mcu_get_campaigns();
      foreach ($campaigns as $campaign):
    ?>
      <tr>
        <td><?php echo $campaign->Name ?></td>
        <td><?php echo $campaign->CampaignID ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
  </div>
</div>