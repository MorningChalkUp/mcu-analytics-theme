<?php  
  require_once path_to_theme() . '/resources/php/email_data.php';
  $mcu_email_data = mcu_get_email_data(the_field('campaign_id'), get_field('ad_urls'));
  ?>
<?php $sponsor = get_field('sponsor'); ?>
<div class="section">
  <div class="wrapper">
    <div class="breadcrumb">
      <a href="/">&larr; Back to Dashboard</a>
    </div>
    <h2 class="section-title">
      <?php pxl::image("acf|logo|user_{$sponsor['ID']}", array( 'w' => 100, 'h' => 'auto' )); ?>
      <?php the_title(); ?><small> | <?php the_field('date') ?></small>
    </h2>
    <hr>
    <div class="row">
      <div class="span8">
        <?php the_field('campaign_id') ?>
        <hr>
        <?php 
          $urls = get_field('ad_urls');
          foreach($urls as $url){
            echo "<p>{$url['url']}</p>";
          }
        ?>
      </div>
      <div class="span4">
        <?php the_field('notes'); ?>
      </div>
    </div>
  </div>
</div>