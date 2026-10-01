<?php
/**
 * Hero Video Block.
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
$class_name = 'block-hero-video';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- hero-video starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <?php
  $displayOption = get_field('select_option');
  if ($displayOption == 'image') {
    $image = get_field('image');
    $size = 'full';
    if ($image) {
      echo wp_get_attachment_image($image, $size);
    }
  } else {
    $video = get_field('video');
    $thumbail = get_field('video_thumbnail');
    if ($video) {
      ?>
      <video loading="lazy" lazy autoplay muted loop playsinline class="video" src="<?php echo $video ?>"
        poster="<?php echo isset($thumbail) ? esc_url($thumbail) : '' ?>" type="video/webm"></video>
      <?php
    }
  }
  ?>
</div>
<!-- hero-video ends here -->