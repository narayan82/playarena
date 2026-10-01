<?php get_header(); ?>
<div class="restaurant-archive-page">
  <?php
  $args = array(
    'post_type' => 'restaurant',
    'orderby' => 'post_date',
    'order' => 'DESC',
  );
  $post_type = get_post_type();
  $restaurants = get_posts($args);
  $count = $GLOBALS['wp_query']->post_count;
  $post_type_obj = get_post_type_object($post_type);
  if (isset($post_type_obj->description)) {
    $description = $post_type_obj->description;
  } else {
    $description = '';
  }
  ?>
  <div class="top-section">
    <div class="wrap">
      <h2>
        Restaurants at PLaY
      </h2>
      <p>
        <?php echo $description;
        ?>
      </p>
    </div>
  </div>
  <div class="wrap">
    <div class="content-wrapper">
      <p class="count">
        <?php echo $count; ?> Restaurants Found
      </p>
      <div class="restaurant-outer-wrapper">
        <?php
        foreach ($restaurants as $restaurant) {
          $id = $restaurant->ID;
          ?>
          <a class="each-restaurant" href="<?php echo get_permalink($id); ?>">
            <div class="top">
              <h2>
                <?php echo ($restaurant->post_name); ?>
              </h2>
              <p>
                <?php echo ($restaurant->post_excerpt); ?>
              </p>
            </div>
            <div class="img-div ">
              <?php echo get_the_post_thumbnail($id, 'thumbnail', array('class' => '')); ?>
            </div>
          </a>
          <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>