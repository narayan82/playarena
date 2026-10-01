<?php
/**
 * Academies Tab Block.
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
$class_name = 'block-academies-tab';
if (!empty($block['className'])) {
  $class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
  $class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- academies-tab starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
  <div class="academy-tab-section">
    <div class="wrap">
      	<div class="academy_desc">
			Whether it's skateboarding or beach volleyball, workshops, bootcamps and one-on-one coaching with our instructors will help you stay on top of your game. Explore our list of available programmes with some of the best coaching academies worldwide.


		</div>
		<div class="tab-wrap">
        <?php
        $tablabel = get_field('label_for_filter');
        if ($tablabel) {
          ?>
          <p class="p-regular"><?php echo $tablabel ?></p>
          <?php
        }
        ?>
        <div class="tab-container-wrap">
          <?php
          $academies = get_posts(['post_type' => 'academies', 'posts_per_page' => -1, 'order' => 'ASC', 'orderby' => 'menu_order']);
          $ageGroup = [];
          foreach ($academies as $academy) {
            if (!isset($ageGroup[get_field('age_group', $academy->ID)])) {
              $ageGroup[get_field('age_group', $academy->ID)] = [];
            }
            $ageGroup[get_field('age_group', $academy->ID)][] = $academy;
          }

          if (sizeof($ageGroup) > 0):
            $tabIndex = 0; // Add an index to keep track of tabs
            foreach ($ageGroup as $tabName => $value):
              if ($tabName) {
                ?>
                <div class="tab-container">
                  <button data-count="<?php echo sizeof($ageGroup[$tabName]) ?>" class="tab <?php echo $tabIndex === 0 ? 'active' : ''; ?>" data-tab-index="<?php echo $tabIndex; ?>">
                    <?php echo ucwords(str_replace('-', ' ', $tabName)); ?></button>
                </div>

                <?php
                $tabIndex++;
              }
            endforeach;
          endif;
          ?>
        </div>

        <div class="mobile-only-tab">
          <button id="academy-prev-button" class="btn prev-btn">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Previous">
          </button>
          <select id="academy-tab-select" class="tab-select">
            <?php
            if (sizeof($ageGroup) > 0):
              $tabIndex = 0;
              foreach ($ageGroup as $tabName => $value):
                if ($tabName) { ?>
                  <option value="<?php echo $tabIndex; ?>"><?php echo ucwords(str_replace('-', ' ', $tabName)); ?></option>
                  <?php
                  $tabIndex++;
                }
              endforeach;
            endif;
            ?>
          </select>
          <button id="academy-next-button" class="btn next-btn">
            <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Next">
          </button>
        </div>
      </div>
    </div>
  </div>
  <div class="academy-tab-content">
    <div class="wrap">
      <!-- <div class="academy-item-count"><span>We found</span> <strong></strong></div> -->
      <?php
      if (sizeof($ageGroup) > 0):
        $tabIndex = 0; // Reset the index for the content sections
        foreach ($ageGroup as $tabName => $academies):
          $academyCount = sizeof($ageGroup[$tabName]);
          if (sizeof($academies) > 0):
            ?>
            <div class="tab-pane <?php echo $tabIndex === 0 ? 'active' : ''; ?>" data-tab-index="<?php echo $tabIndex; ?>">
              <div class="academy-item-coun"><span>We found</span> <strong><?php echo $academyCount ?> Academies</strong>
              </div>
              <div class="tab-content-container">
                <?php
                foreach ($academies as $academy):
                  if ($academy):
                    setup_postdata($academy);
                    $postId = $academy->ID;
                    $title = get_field('title', $postId);
                    $description = get_field('description', $postId);
                    $thumbnail = get_field('thumbnail_image', $postId);
                    ?>
                    <a href="<?php echo isset($buttonText) ? $buttonLink : get_permalink($academy->ID) ?>" class="academy-item">
                      <div class="thumbnail">
                        <?php if ($thumbnail) {
                          echo wp_get_attachment_image($thumbnail, 'full');
                        } else {
                          echo get_the_post_thumbnail($post->ID, 'thumbnail');
                        }
                        ?>
                      </div>
                      <div class="title-div">

                        <?php if ($title) {
                          ?>
                          <h2><?php echo $title ?></h2>
                          <?php
                        } else {
                          ?>
                          <h2><?php the_title(); ?></h2>
                          <?php
                        }
                        ?>
                        <?php if ($description) {
                          ?>
                          <p class="description"><?php echo $description ?></p>
                          <?php
                        } else {
                          ?>
                          <div class="excerpt">
                            <?php the_excerpt(); ?>
                          </div>
                          <?php
                        }
                        ?>
                      </div>
                      <div class="button"><span>VIEW ACADEMY</span><div class="icon-div"><svg xmlns="http://www.w3.org/2000/svg" width="19.79" height="19.79" viewBox="0 0 19.79 19.79"><path id="Diagonal_Arrow" data-name="Diagonal Arrow" d="M3.68,0V2.19H16.05L0,18.24l1.55,1.55L17.6,3.74V16.11h2.19V0Z" transform="translate(0)" fill="#007bfe" /></svg></div>
                      </div>
                      <?php
                      ?>
                    </a>
                    <?php
                    wp_reset_postdata();
                  endif;
                endforeach;
                ?>
              </div>

            </div>
            <?php
          endif;
          $tabIndex++;
        endforeach;
      endif;
      ?>
    </div>
  </div>
</div>


<!-- academies-tab ends here -->