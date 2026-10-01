<?php get_header(); ?>
<?php if (have_posts()):
  while (have_posts()):
    the_post(); ?>
    <div class="single-restaurant-page">
      <div class="entry-content">
        <?php the_content(); ?>
      </div>
    <?php endwhile; else: ?>
  <?php endif; ?>
</div>
<?php get_footer(); ?>