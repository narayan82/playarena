<?php
/**
 * Single Page Hero Carousel Block.
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
$class_name = 'block-single-page-hero-carousel';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- single-page-hero-carousel starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <div class="slider-section">
    <div class="single-page-hero-carousel" style="display:flex">
      <?php
      if (have_rows('carousel_images')):
        while (have_rows('carousel_images')):
          the_row();
          $image = get_sub_field('image');
          $size = 'full';
          if ($image) {
            echo wp_get_attachment_image($image, $size);
          }
        endwhile;
      endif;
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
  </div>

  <div class="bottom-section">
    <div class="wrap">
      <div class="left">
        <?php
        $featured_image = get_post_thumbnail_id();
        if ($featured_image) {
          ?>
          <div class="img-div">
            <?php echo wp_get_attachment_image($featured_image, 'full') ?>
          </div>
          <?php
        }
        ?>
      </div>
      <div class="right">
        <?php
        if (have_rows('hero_button_details')):
          while (have_rows('hero_button_details')):
            the_row();

            $button_text = get_sub_field('button_text');
            $button_link = get_sub_field('link');
            if ($button_text && $button_link) {
              ?>
              <div class="button-div">

                <a href="<?php echo $button_link ?>" class="button">
                  <?php echo $button_text ?>
                </a>
              </div>
              <?php
            }
          endwhile;
        endif;
        ?>
      </div>
    </div>
  </div>
</div>
<!-- single-page-hero-carousel ends here -->