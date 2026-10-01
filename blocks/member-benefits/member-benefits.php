<?php
/**
 * Member Benefits Block.
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
$class_name = 'block-member-benefits';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- member-benefits starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <div class="wrap">
    <?php
    $title = get_field('title_for_member_benefits', 'option');
    $description = get_field('description_for_member_benefits', 'option');
    $buttonText = get_field('member_benefits_button_text', 'option');
    ?>
    <div class="left">
      <?php if ($title) { ?>
        <h2><?php echo $title ?></h2>
        <?php
      } ?>
      <?php if ($description) { ?>
        <p><?php echo $description ?></p>
        <?php
      }
      ?>
      <div class="button-div">
        <a href="#" class="button"><?php echo $buttonText ?></a>
      </div>
    </div>
    <div class="right">
      <?php
      if (have_rows('benefits', 'option')):
        while (have_rows('benefits', 'option')):
          the_row();
          $benefitsTitle = get_sub_field('title');
          $benefitsDescription = get_sub_field('description');
          $image = get_sub_field('image');
          ?>
          <div class="single">
            <?php if ($image) {
              echo wp_get_attachment_image($image, "full");
            }
            ?>
            <div class="content">
              <?php
              if ($benefitsTitle) {
                ?>
                <h2 class="title"><?php echo $benefitsTitle ?></h2>
                <?php
              }
              if ($benefitsDescription) {
                ?>
                <p class="description"><?php echo $benefitsDescription ?></p>
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
  </div>
</div>
<!-- member-benefits ends here -->