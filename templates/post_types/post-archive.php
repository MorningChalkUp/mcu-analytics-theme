<div class="section">
  <div class="wrapper">
    <h2>Posts Page</h2>
    <div class="featured posts"><?php pxl::loop('post:2'); ?></div>
    <div class="items row">
      <?php pxl::loop(); ?>
    </div>
    <?php pxl::paginate(); ?>
  </div>
</div>
