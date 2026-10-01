<?php
/**
 * Slider Type 1 Block.
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
$class_name = 'block-slider-type-1';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- slider-type-1 starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <div class="slider-container">

    <?php
    if (have_rows('slider_content')):
      ?>
      <?php
      while (have_rows('slider_content')):
        the_row();
        $slideTitle = get_sub_field('title');
        $buttonText = get_sub_field('button_text');
        $buttonLink = get_sub_field('button_link');
        $slideThumbnail = get_sub_field('thumbnail');
        $slideDescription = get_sub_field('description');
        ?>
        <div class="single-slide">
          <?php if ($slideThumbnail) {
            echo wp_get_attachment_image($slideThumbnail, "full", false, ['class' => 'thumbnail']);
          }
          if ($slideTitle) {
            ?>
            <h2 class="slide-title"><?php echo $slideTitle ?></h2>
            <?php
          }
          if ($slideDescription) {
            ?>
            <p class="slide-description"><?php echo $slideDescription ?></p>
            <?php
          }
          if ($buttonText) {
            ?>
            <a href="<?php echo isset($buttonLink) ? $buttonLink : '#' ?>" class="button">
              <span>
                <?php echo $buttonText ?>
              </span>
              <div class="icon-div">
                <svg xmlns="http://www.w3.org/2000/svg" width="19.79" height="19.79" viewBox="0 0 19.79 19.79">
                  <path id="Diagonal_Arrow" data-name="Diagonal Arrow"
                    d="M3.68,0V2.19H16.05L0,18.24l1.55,1.55L17.6,3.74V16.11h2.19V0Z" transform="translate(0)"
                    fill="#007bfe" />
                </svg>
              </div>
            </a>
            <?php
          }
          ?>
        </div>
        <?php
      endwhile;
      ?>
    </div>
    <div class="pager-div">
      <div class="pager">
        <div class="prev">
          <svg xmlns="http://www.w3.org/2000/svg" width="13.239" height="21.514" viewBox="0 0 13.239 21.514">
            <path id="if_chevron-right_406199_copy" data-name="if_chevron-right_406199 copy"
              d="M11.634,12.757l8.606,8.44-2.317,2.317L7,12.757,17.922,2l2.317,2.317Z" transform="translate(-7 -2)"
              fill="#fff" />
          </svg>
        </div>
        <div class="next">
          <svg xmlns="http://www.w3.org/2000/svg" width="13.239" height="21.514" viewBox="0 0 13.239 21.514">
            <path id="if_chevron-right_406199_copy" data-name="if_chevron-right_406199 copy"
              d="M15.606,12.757,7,21.2l2.317,2.317L20.239,12.757,9.317,2,7,4.317Z" transform="translate(-7 -2)"
              fill="#fff" />
          </svg>

        </div>
      </div>
    </div>
    <?php
    endif;
    ?>
</div>
<!-- slider-type-1 ends here -->