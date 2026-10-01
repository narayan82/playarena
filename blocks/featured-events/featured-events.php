<?php
/**
 * Featured Events Block.
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
$class_name = 'block-featured-events';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- featured-events starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <?php
  if (have_rows('events_list')):
    while (have_rows('events_list')):
      the_row();
      $eventName = get_sub_field('event_name');
      $eventIcon = get_sub_field('event_icon');
      $buttonText = get_sub_field('button_text');
      $buttonLink = get_sub_field('button_link');
      $thumbnailImage = get_sub_field('thumbnail_image');
      $eventDescription = get_sub_field('event_description');
      ?>
      <div class="each-content">
        <div class="top-sec">
          <?php
          if ($eventIcon) {
            echo wp_get_attachment_image($eventIcon, "full");
          }
          if ($eventName) {
            ?>
            <p class="event-title"><?php echo esc_html($eventName); ?></p>
            <?php
          }
          ?>
        </div>
        <?php if ($thumbnailImage) {
          ?>
          <div class="img-div">
            <?php echo wp_get_attachment_image($thumbnailImage, "full"); ?>
          </div>
          <?php
        }
        ?>
        <div class="content-div">
          <div class="top">
            <?php if ($eventDescription) {
              echo $eventDescription;
            }
            ?>
          </div>
          <div class="btn-container">
            <a href="<?php echo $buttonLink ? $buttonLink : '#' ?>" class="button" title="Find out More"><?php if ($buttonText) {
                     echo $buttonText;
                   } ?>
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="15.379" viewBox="0 0 18 15.379">
                <path id="Path_498" data-name="Path 498"
                  d="M7.689,0,0,7.689,1.244,8.934l5.565-5.56V18H8.57V3.373l5.561,5.56,1.248-1.244Z"
                  transform="translate(18) rotate(90)" />
              </svg>
            </a>
          </div>
        </div>
      </div>
      <?php
    endwhile;
  endif;
  ?>
</div>
<!-- featured-events ends here -->