<?php /* Template Name: Campaigns */ ?>
<div class="section">
  <div class="wrapper">
    <h2 class="section-title"><?php the_title() ?></h2>
    <table>
    <?php
      $campaigns = mcu_get_campaigns();
      foreach ($campaigns as $campaign):
    ?>
      <tr>
        <td><?php echo date_format(date_create($campaign->SentDate),"n/j/y") ?></td>
        <td><a href="<?php echo str_replace('http:','https:',$campaign->WebVersionURL) ?>" target="_blank"><?php echo $campaign->Subject ?></a></td>
        <td><?php echo $campaign->CampaignID ?></td>
      </tr>
    <?php endforeach; ?>
    </table>
  </div>
</div>