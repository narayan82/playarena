<?php
/**
 * Event Spaces Block.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during backend preview render.
 * @param   int $post_id The post ID the block is rendering content against.
 *          This is either the post ID currently being displayed inside a query loop,
 *          or the post ID of the post hosting this block.
 * @param   array $context The context provided to the block by the post or it's parent block.
 */

$anchor = '';
if (!empty($block['anchor'])) {
  $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

$class_name = 'block-event-spaces';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

if (is_page(array(834, 36, 1495))) {
  include __DIR__ . '/cards.php';
  return;
}
?>
<!-- event-spaces starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <div class="tab-section">
    <div class="wrap">
      <div class="tab-wrap">
        <?php
        if (have_rows('event_space_details')):
          $tabIndex = 0;
          while (have_rows('event_space_details')):
            the_row();
            $tabName = get_sub_field('tab_name');
            ?>
            <?php if ($tabName) {
              ?>
              <button class="tab <?php echo $tabIndex === 0 ? 'active' : ''; ?> " data-tab-index="<?php echo $tabIndex; ?>">
                <?php echo $tabName ?></button>
              <?php
              $tabIndex++;
            }
          endwhile;
        endif;
        ?>

      </div>
      <div class="mobile-only-tab">
        <button id="event-space-prev-button" class="btn prev-btn">
          <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Previous">
        </button>
        <select id="event-space-tab-select" class="tab-select">
          <?php
          if (have_rows('event_space_details')):
            $tabIndex = 0;
            while (have_rows('event_space_details')):
              the_row(); ?>
              <?php $tabName = get_sub_field('tab_name'); ?>
              <?php if ($tabName) { ?>
                <option value="<?php echo $tabIndex; ?>"><?php echo $tabName; ?></option>
                <?php
                $tabIndex++;
              }
            endwhile;
          endif;
          ?>
        </select>
        <button id="event-space-next-button" class="btn next-btn">
          <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Next">
        </button>
      </div>
    </div>
  </div>
  <?php
  if (have_rows('event_space_details')):
    $tabIndex = 0;
    while (have_rows('event_space_details')):
      the_row();

      $sectionTitle = get_sub_field('space_title');
      $sectionDescription = get_sub_field('space_description');
      ?>
      <div class="content-section" data-tab-index="<?php echo $tabIndex; ?>" style="<?php echo $tabIndex === 0 ? '' : 'display: none;'; ?>">
        <div class="left">
          <div class="title-sec">
            <?php if ($sectionTitle) {
              ?>
              <h2 class="title"><?php echo $sectionTitle ?></h2>
              <?php
            }
            if ($sectionDescription) {
              ?>
              <p class="p-regular"><?php echo $sectionDescription ?></p>
              <?php
            }
            ?>
          </div>
          <!-- Event space details -->
          <?php
          if (have_rows('more_details_abouts_space')):
            ?>
            <div class="meta-details-container">
              <?php
              while (have_rows('more_details_abouts_space')):
                the_row();
                $valueOption = get_sub_field('value_type');
                $infoText = get_sub_field('info_text');
                ?>
                <div class="single-details">
                  <?Php
                  if ($valueOption == 'text') {
                    $valueText = get_sub_field('value');
                    ?>

                    <?php if ($valueText) {
                      ?>
                      <p class="value"><?php echo $valueText ?></p>
                      <?php
                      if ($infoText) {
                        ?>
                        <p class="info"><?php echo $infoText ?></p>
                        <?php
                      }
                    }
                  } else if ($valueOption == 'image') {
                    $valueimage = get_sub_field('icon');
                    if ($valueimage) {
                      echo wp_get_attachment_image($valueimage, 'full');
                      if ($infoText) {
                        ?>
                          <p class="info"><?php echo $infoText ?></p>
                        <?php
                      }
                    }
                  }
                  ?>
                </div>
                <?php
              endwhile;
              ?>
            </div>
            <?php
          endif;
          ?>
        </div>
        <div class="right">
          <div class="slider-container">
            <?php
            if (have_rows('slider_images')):
              while (have_rows('slider_images')):
                the_row();
                $slideImage = get_sub_field('slider_image');
                ?>
                <div class="img-div">
                  <?php echo wp_get_attachment_image($slideImage, 'full');
                  ?>
                </div>
                <?php
              endwhile;
            endif;
            ?>
          </div>
        </div>
      </div>
      <?php
      $tabIndex++;
    endwhile;
  endif;
  ?>
</div>
<!-- event-spaces ends here -->
