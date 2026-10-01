<?php
/**
 * Restaurant Features Block.
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
$class_name = 'block-restaurant-features';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- restaurant-features starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>" style="display:flex">
  <?php
  if (have_rows('features')):

    while (have_rows('features')):
      the_row();
      $title = get_sub_field('title');
      $description = get_sub_field('description');
      $image = get_sub_field('image');
      $buttonText = get_sub_field('button_text');
      $buttonLink = get_sub_field('button_link');
      ?>
      <div class="each-card">
        <?php
        $size = 'full';
        if ($image) {
          echo wp_get_attachment_image($image, $size, false, ['class' => 'thumbnail']);
        }
        ?>
        <div class="bottom">
          <?php
          if ($title) {
            ?>
            <h2>
              <?php echo $title ?>
            </h2>
            <?php
          }
          if ($description) {
            ?>
            <?php echo $description ?>
            <?php
          }
          if ($buttonText) {
            ?>
            <a href="<?php echo isset($buttonText) ? $buttonLink : '#' ?>" class="button">
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
      </div>
      <?php
    endwhile;

  endif;
  ?>
</div>

<!-- restaurant-features ends here -->