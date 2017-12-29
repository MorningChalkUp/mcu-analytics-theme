<?php if ( $not_found ) : ?>
  <h3>No Posts</h3>
<?php else: ?>
<div class="post">
  <?php if ( has_post_thumbnail() ) : ?>
    <a href="<?php the_permalink(); ?>"><?php pxl::image(array( 'w' => 370, 'h' => 150 )); ?></a>
  <?php endif; ?>
  <div class="header">
    <span class="date"><?php the_time('M j, Y'); ?></span>
    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
    <span class="tags">
      <?php $posttags = get_the_tags(); if ($posttags) {foreach($posttags as $tag) {echo '<a class="button" href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a></span>';}} ?>
    </span>
  </div>
  <div class="excerpt">
    <?php echo pxl::excerpt(); ?>
    <a href="<?php the_permalink(); ?>" class="btn">Read More</a>
  </div>
</div>
<?php endif; ?>