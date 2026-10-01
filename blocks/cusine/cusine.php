<?php
/**
 * Cusine Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

// Support custom "anchor" values.
$anchor = '';
if (!empty($block['anchor'])) {
  $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block-cusine';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- cusine starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <div class="wrap">
    <div class="cusine-container">
      <?php
      $terms = get_terms(array(
        'taxonomy' => 'cusine',
        'hide_empty' => false,
        'post_type' => 'restaurant',
      ));
      foreach ($terms as $term) {
        $id = $term->ID;
        ?>
        <div class="each-cusine">
          <div class="top">
            <h2>
              <?php echo ($term->name); ?>
            </h2>
          </div>
          <div class="bottom">
            <a href="<?php echo get_permalink($id); ?>">
              View Menu
            </a>
            <div class="right">
              <a href="">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/1.png" alt="">

              </a>
              <a href="">
                <img src="<?php echo get_stylesheet_directory_uri(); ?>/img/2.png" alt="">
              </a>
            </div>
          </div>

        </div>
        <?php
      }
      ?>
    </div>
  </div>
</div>
<!-- cusine ends here -->