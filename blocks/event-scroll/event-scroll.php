<?php
/**
 * Event Scroll Block.
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
$class_name = 'block-event-scroll';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- event-scroll starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <?php if (have_rows('event_scroll')): ?>
    <div class="event-scroll-slider">
      <div class="slider-track">
        <?php while (have_rows('event_scroll')):
          the_row();
          $icon_id = get_sub_field('icon');
          $text = get_sub_field('icon_text');
          $icon_url = wp_get_attachment_image_url($icon_id, 'full');
          ?>
          <div class="event-item">
            <?php if ($icon_url): ?>
              <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($text); ?>" />
            <?php endif; ?>
            <div class="event-label"><?php echo esc_html($text); ?></div>
          </div>
        <?php endwhile; ?>
        <!-- Optional: Duplicate for seamless loop -->
        <?php if (have_rows('event_scroll')):
          while (have_rows('event_scroll')):
            the_row();
            $icon_id = get_sub_field('icon');
            $text = get_sub_field('icon_text');
            $icon_url = wp_get_attachment_image_url($icon_id, 'full');
            ?>
            <div class="event-item">
              <?php if ($icon_url): ?>
                <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($text); ?>" />
              <?php endif; ?>
              <div class="event-label"><?php echo esc_html($text); ?></div>
            </div>
          <?php endwhile;
        endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div>

<!-- event-scroll ends here -->