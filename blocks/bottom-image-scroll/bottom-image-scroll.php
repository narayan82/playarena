<?php
/**
 * Bottom Image Scroll Block.
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
$class_name = 'block-bottom-image-scroll';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- bottom-image-scroll starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <?php if (have_rows('bottom_image_scroll')): ?>
    <div class="bottom-image-scroll-outer">
      <div class="bottom_image_scroll-slider">
        <?php while (have_rows('bottom_image_scroll')):
          the_row();
          $type = get_sub_field('type');
          if ($type === 'image'):
            $image = get_sub_field('image');
            if ($image): ?>
              <div class="scroll-item image-type">
                <img src="<?php echo esc_url(wp_get_attachment_image_url($image, 'full')); ?>">
              </div>
            <?php endif; ?>
          <?php elseif ($type === 'content'):
            $name = get_sub_field('name');
            $text = get_sub_field('content');
            $image = get_sub_field('logo'); ?>
            <div class="scroll-item content-type">
              <img class="logo" src="<?php echo esc_url(wp_get_attachment_image_url($image, 'full')); ?>">
              <img class="rating" src="<?php echo get_stylesheet_directory_uri(); ?>/img/rating.svg" alt="rating" width="202"
                height="34">
              <p><?php echo esc_html($text); ?></p>
              <h3><?php echo esc_html($name); ?></h3>
            </div>
          <?php endif;
        endwhile; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- bottom-image-scroll ends here -->