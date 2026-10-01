<?php
/**
 * Tab block Block.
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
$class_name = 'block-tab-block';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- tab-block starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <div class="tab-section">
    <div class="wrap">
      <?php ob_start();
      if (is_page(array(834, 36, 1495))):
        // Keep each age group's heading connected to the existing filter state.
        foreach ((array) get_field('tab_details') as $headingIndex => $ageGroup):
          $filterHeading = $ageGroup['slider_section'][0]['slider_section_title'] ?? '';
          $filterDescription = $ageGroup['slider_section'][0]['slider_section_description'] ?? '';
          if ($filterHeading): ?>
            <h2 class="h2 age-filter-heading content-section" data-tab-index="<?php echo esc_attr($headingIndex); ?>" style="<?php echo $headingIndex === 0 ? '' : 'display: none;'; ?>"><?php echo esc_html($filterHeading); ?></h2>
          <?php endif;
          if ($filterDescription): ?>
            <p class="p-regular age-filter-subtitle content-section" data-tab-index="<?php echo esc_attr($headingIndex); ?>" style="<?php echo $headingIndex === 0 ? '' : 'display: none;'; ?>"><?php echo wp_kses_post($filterDescription); ?></p>
          <?php endif;
        endforeach;
      endif;
      $filter_heading_markup = ob_get_clean();
      if (!is_page(1495)) echo $filter_heading_markup; ?>
      <div class="tab-wrap">
        <?php
        $tablabel = get_field('label_for_tab');
        if ($tablabel) {
          ?>
          <p class="p-regular"><?php echo $tablabel ?></p>
          <?php
        }
        ?>
        <div class="tab-container-wrap">
          <?php
          if (have_rows('tab_details')):
            $tabIndex = 0; // Add an index to keep track of tabs
            while (have_rows('tab_details')):
              the_row();
              $tabName = get_sub_field('tab_name');
              ?>
              <?php if ($tabName) {
                ?>
                <div class="tab-container">
                  <button class="tab <?php echo $tabIndex === 0 ? 'active' : ''; ?> " data-tab-index="<?php echo $tabIndex; ?>">
                    <?php echo $tabName ?></button>
                </div>
                <?php
                $tabIndex++;
              }
            endwhile;
          endif;
          ?>
        </div>
        <div class="mobile-only-tab">
          <button id="single-event-prev-button" class="btn prev-btn">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Previous">
          </button>
          <select id="single-event-tab-select" class="tab-select" aria-label="<?php echo esc_attr($tablabel ?: 'Select an option'); ?>">
            <?php
            if (have_rows('tab_details')):
              $tabIndex = 0;
              while (have_rows('tab_details')):
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
          <button id="single-event-next-button" class="btn next-btn">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Next">
          </button>
        </div>
      </div>
      <?php if (is_page(1495)) echo $filter_heading_markup; ?>
    </div>
  </div>

  <?php
  if (have_rows('tab_details')):
    $tabIndex = 0; // Reset the index for the content sections
    while (have_rows('tab_details')):
      the_row();
      if (have_rows('slider_section')):
        $sectionIndex = 0;
        while (have_rows('slider_section')):
          the_row();
          $sectionTitle = get_sub_field('slider_section_title');
          $sectionDescription = get_sub_field('slider_section_description');
          ?>
          <?php if (!(is_page(array(834, 36, 1495)) && $sectionIndex === 0)): ?>
          <div class="slider-top-sec content-section<?php echo $sectionIndex === 0 ? ' age-group-suggestions' : ($sectionIndex === 1 ? ' age-group-entertainment' : ''); ?>" data-tab-index="<?php echo $tabIndex; ?>" style="<?php echo $tabIndex === 0 ? '' : 'display: none;'; ?>">
            <div class="wrap">
              <?php if ($sectionTitle && !(is_page(array(834, 36, 1495)) && $sectionIndex === 0)) {
                ?>
                <h2 class="h2"><?php echo $sectionTitle ?></h2>
                <?php
              }
              if ($sectionDescription) {
                ?>
                <p class="p-regular"><?php echo $sectionDescription ?></p>
                <?php
              }
              ?>
            </div>
          </div>
          <?php endif; ?>
          <?php
          if (have_rows('slide')):
            ?>
            <div class="slider-sec-outer content-section<?php echo $sectionIndex === 0 ? ' age-group-suggestions' : ($sectionIndex === 1 ? ' age-group-entertainment' : ''); ?>" data-tab-index="<?php echo $tabIndex; ?>" style="<?php echo $tabIndex === 0 ? '' : 'display: none;'; ?>">
              <div class="slider-container">
                <?php
                $slider = 1;
                while (have_rows('slide')):
                  the_row();
                  $slideTitle = get_sub_field('slide_title');
                  $buttonText = get_sub_field('button_text');
                  $buttonLink = get_sub_field('button_link');
                  $slideThumbnail = get_sub_field('thumbnail');
                  $slideDescription = get_sub_field('description');
                  ?>
                  <div class="single-slide <?php echo 'slider-' . $slider++; ?>">
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
                      <a href="<?php echo isset($buttonText) ? $buttonLink : '#' ?>" class="button">
                        <span>
                          <?php echo $buttonText ?>
                        </span>
                        <div class="icon-div">
                          <svg xmlns="http://www.w3.org/2000/svg" width="19.79" height="19.79" viewBox="0 0 19.79 19.79">
                            <path id="Diagonal_Arrow" data-name="Diagonal Arrow" d="M3.68,0V2.19H16.05L0,18.24l1.55,1.55L17.6,3.74V16.11h2.19V0Z" transform="translate(0)" fill="#007bfe" />
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
                      <path id="if_chevron-right_406199_copy" data-name="if_chevron-right_406199 copy" d="M11.634,12.757l8.606,8.44-2.317,2.317L7,12.757,17.922,2l2.317,2.317Z"
                        transform="translate(-7 -2)" fill="#fff" />
                    </svg>
                  </div>
                  <div class="next">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13.239" height="21.514" viewBox="0 0 13.239 21.514">
                      <path id="if_chevron-right_406199_copy" data-name="if_chevron-right_406199 copy" d="M15.606,12.757,7,21.2l2.317,2.317L20.239,12.757,9.317,2,7,4.317Z" transform="translate(-7 -2)"
                        fill="#fff" />
                    </svg>

                  </div>
                </div>
              </div>
            </div>

            <?php
          endif;
          $sectionIndex++;
        endwhile;
      endif;
      $tabIndex++;
    endwhile;
  endif;
  ?>
</div>


<!-- tab-block ends here -->