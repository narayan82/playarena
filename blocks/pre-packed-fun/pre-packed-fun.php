<?php
/**
 * Pre packed Fun Block.
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
$class_name = 'block-pre-packed-fun';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- pre-packed-fun starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <?php if (have_rows('pre_packed_fun')): ?>
    <div class="pre-packed-fun-slider">
      <?php while (have_rows('pre_packed_fun')):
        the_row();
        $heading = get_sub_field('heading');
        $icon = get_sub_field('icon');
        $paragraph = get_sub_field('paragraph');
        $price = get_sub_field('price');
        ?>
        <div class="fun-box">
          <h3><?php echo $heading; ?></h3>
          <div class="icon-wrap">
            <?php if ($icon): ?>
              <img src="<?php echo esc_url(wp_get_attachment_image_url($icon, 'full')); ?>"
                alt="<?php echo esc_attr($heading); ?>">
            <?php endif; ?>
          </div>
          <p class="description"><?php echo $paragraph; ?></p>
        </div>
      <?php endwhile; ?>
    </div>
  
  <?php endif; ?>
</div>



</div>
<!-- pre-packed-fun ends here -->