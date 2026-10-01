<?php get_header(); ?>
<div class="single-page-activity">
  <?php $activity_id = get_the_ID(); ?>
  <?php
  $terms = get_the_terms($post->ID, 'location');
  if ($terms) {
    foreach ($terms as $term) {
      $location = $term->name;
      $description = $term->description;
      $location_slug = $term->slug;
      $location_image = get_field('image', $term);
      $backgroundColor = get_field('location_color', $term);
    }
  } else {
    $location = "";
  }
  ?>
  <div class="sec-1-top-section " style=" background-color: <?php echo $backgroundColor; ?>">
    <div class=" wrap">
      <div class="top-section-content">
        <div class="left">
          <div class="row">
            <div class="activity-category-icon" aria-hidden="true">
              <?php
              // Use the same category artwork as the Play mega menu.
              $menu_icon_names = array('pixel', 'studio', 'union', 'prime', 'junior');
              $category_icon_name = sanitize_title($location);
              if (in_array($category_icon_name, $menu_icon_names, true)) {
                echo '<img src="' . esc_url(get_template_directory_uri() . '/img/' . $category_icon_name . '.svg') . '" alt="" width="40" height="40">';
              } else {
                the_field('location_icon', $term);
              }
              ?>
            </div>
            <h1><?php echo $location; ?></h1>
          </div>
          <p><?php echo $description ?></p>
        </div>
      </div>
    </div>
  </div>
  <div class="tab-section " style=" background-color: <?php echo $backgroundColor; ?>">
    <div class="wrap">
      <div class="tab-container">
        <?php
        $args = array(
          'post_type' => 'activity',
          'posts_per_page' => -1,
          "orderby" => 'menu_order',
          'order' => 'ASC',
          'tax_query' => array(
            array(
              'taxonomy' => 'location',
              'field' => 'id',
              'terms' => $term->term_id,
            ),
          ),
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
          while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $post_slug = get_post_field('post_name', $post_id);
            $post_url = home_url('/activity/' . $post_slug . '/');
            $class_name = 'each-tab';
            if ($activity_id === $post_id) {
              $class_name = 'each-tab active';
            } else {
              $class_name = 'each-tab';
            }
            echo '<a href="' . esc_url($post_url) . '" class="' . $class_name . '">' . get_the_title() . '</a>';
          }
          wp_reset_postdata();
        }
        ?>
      </div>
      <div class="mobile-only-tab-container">
        <button type="button" aria-label="Previous activity" id="activity-page-prev-button" class="btn prev-btn">
          <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Previous">
        </button>
        <select aria-label="Choose an activity" id="activity-page-select" onchange="location = this.value;">
          <?php
          $query = new WP_Query($args); // Reuse the same query args
          if ($query->have_posts()) {
            while ($query->have_posts()) {
              $query->the_post();
              $post_id = get_the_ID();
              $post_slug = get_post_field('post_name', $post_id);
              $post_url = home_url('/activity/' . $post_slug . '/');
              $image = get_field('tab_icon');
              $title = get_the_title();
              $selected = ($activity_id === $post_id) ? 'selected' : ''; // Determine if this is the active item
              echo '<option value="' . esc_url($post_url) . '" ' . $selected . '>';
              if ($image) {
                echo wp_get_attachment_image($image, 'full', false, array('class' => 'tab-icon'));
              }
              echo esc_html($title);
              echo '</option>';
            }
            wp_reset_postdata();
          }
          ?>
        </select>
        <button type="button" aria-label="Next activity" id="activity-page-next-button" class="btn next-btn">
          <img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Next">
        </button>
      </div>
    </div>
  </div>

  <div class="main-content">
    <?php $slug = $post->post_name; ?>
    <section class="section-1" id="<?php echo $slug ?>">
      <div class="activity-overview">
        <div class="activity-details">
          <div class="activity-title-row">
            <?php
            $activityIcon = get_field('activity_icon');
            if ($activityIcon) echo wp_get_attachment_image($activityIcon, 'full', false, array('class' => 'activity-title-icon'));
            ?>
            <h2><?php the_title(); ?></h2>
          </div>
          <p class="activity-description"><?php echo get_the_excerpt(); ?></p>
          <div class="activity-facts">
            <?php foreach (array('price', 'duration', 'age_group', 'maximum_players') as $fact): ?>
              <div class="activity-fact"><?php echo wp_kses_post(get_field($fact, $activity_id)); ?></div>
            <?php endforeach; ?>
          </div>
          <?php $link = get_field('button_link'); if ($link): ?>
            <a class="activity-book-button" href="<?php echo esc_url($link); ?>">Book This Activity</a>
          <?php endif; ?>
        </div>
        <div class="activity-gallery">
          <div class="activity-single-page-slider">
            <?php
            if (have_rows('images_for_slider')):
              while (have_rows('images_for_slider')):
                the_row();
                $image = get_sub_field('image');
                $size = 'full';
                ?>
                <div class="img-div">
                  <?php
                  if ($image) {
                    echo wp_get_attachment_image($image, $size);
                  }
                  ?>
                </div>
                <?php
              endwhile;
            endif;
            ?>
          </div>
        </div>
      </div>
    </section>
    <?php
    if (have_rows('events_for_the_activity')) {
      ?>
      <section class="section-3">
        <div class="wrap">
          <div class="left">
            <?php
            $titleEventSec = get_field('title_for_host_this_activity');
            $descriptionEventSec = get_field('description_for_host_event');
            if ($titleEventSec) {
              ?>
              <h2><?php echo $titleEventSec ?></h2>
              <?php
            }
            if ($descriptionEventSec) {
              ?>
              <p><?php echo $descriptionEventSec ?></p>
              <?php
            }
            ?>
          </div>
          <div class="events-list">
            <?php
            while (have_rows('events_for_the_activity')):
              the_row();
              $eventName = get_sub_field('event_name');
              $icon = get_sub_field('icon');
              $link = get_sub_field('link');
              ?>
              <a href="<?php echo $link ? $link : '' ?>" class="single-item">
                <?php
                if ($icon) {
                  echo wp_get_attachment_image($icon, "full");
                }
                if ($eventName) {
                  ?>
                  <p><?php echo $eventName ?></p><?php
                }
                ?>
              </a>
              <?php
            endwhile;
            ?>
          </div>
        </div>
      </section>
      <?php
    }
    $args = array(
      'numberposts' => -1,
      'post_type' => 'specials',
      'orderby' => 'post_date',
      'order' => 'DESC',
      'meta_query' => array(
        array(
          'key' => 'activities', // The name of the ACF field for activities
          'value' => '"' . $activity_id . '"', // The ID of the current activity
          'compare' => 'LIKE'
        )
      )
    );
    $latest_specials = get_posts($args);
    if (!empty($latest_specials)) {
      ?>
      <section class="section-4">
        <div class="top-section">
          <div class="wrap">
            <?php
            $titleSpecialSec = get_field('specials_section_title', 'options');
            $imageSpecialSec = get_field('specials_section_image', 'options');
            if ($titleSpecialSec) {
              ?>
              <h2 class="event-title"><?php echo $titleSpecialSec ?></h2><?php
            }
            ?>
            <?php
            if ($imageSpecialSec) {
              echo wp_get_attachment_image($imageSpecialSec, 'full');
            }
            ?>
          </div>

        </div>
        <div class="offer-slider-outer">
          <div class="offer-slider-wrapper">
            <div class="content-wrapper">
              <?php
              foreach ($latest_specials as $special) {
                $specialId = $special->ID;
                $image = get_field('thumbnail_image', $specialId);
                $title = get_field('title', $specialId);
                $subTitle = get_field('subtitle', $specialId);
                $description = get_field('description', $specialId);
                /* Date format */
                $startDate = get_field('offer_start_date', $specialId); // Assuming dates are in 'Y-m-d' format
                $endDate = get_field('offer_end_date', $specialId);
                ?>
                <div class="single-slide">
                  <?php
                  if ($image) {
                    echo wp_get_attachment_image($image, 'full');
                  } else {
                    ?>
                    <img src="<?php echo get_the_post_thumbnail_url($specialId, 'full'); ?>">
                    <?php
                  }
                  ?>
                  <?php if ($title) {
                    ?>
                    <h2><?php echo $title ?></h2>
                    <?php
                  }
                  if ($subTitle) {
                    ?>
                    <p class="sub-title"><?php echo $subTitle ?></p>
                    <?php
                  }
                  if ($description) {
                    ?>
                    <p class="description"><?php echo $description ?></p>
                    <?php
                  } ?>
                  <div class="bottom">
                    <a href="#">
                      <?php
                      if ($startDate) { ?>
                        <span><?php echo $startDate ?></span>
                        <?php
                      } ?>
                      <span>To</span>
                      <?php
                      if ($endDate) { ?>
                        <span><?php echo $endDate ?></span>
                        <?php
                      }
                      ?>
                    </a>
                  </div>

                </div>
                <?php
              }
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
                    <path id="if_chevron-right_406199_copy" data-name="if_chevron-right_406199 copy" d="M15.606,12.757,7,21.2l2.317,2.317L20.239,12.757,9.317,2,7,4.317Z"
                      transform="translate(-7 -2)" fill="#fff" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php
    }
    $args = array(
      'numberposts' => -1,
      'post_type' => 'event',
      'orderby' => 'post_date',
      'order' => 'DESC',
      'meta_query' => array(
        array(
          'key' => 'activities', // The name of the ACF field for activities
          'value' => '"' . $activity_id . '"', // The ID of the current activity
          'compare' => 'LIKE'
        )
      )
    );
    $latest_event = get_posts($args);
    if (!empty($latest_event)) {
      ?>
      <section class="section-5">
        <?php
        $eventSecTitle = get_field('events_section_title', 'options');
        $eventSecButtonText = get_field('events_section_button_text', 'options');
        ?>
        <?php if ($eventSecTitle) {
          ?>
          <div class="top-section">
            <?php
            if ($eventSecTitle) {
              ?>
              <h2><?php echo $eventSecTitle ?></h2>
              <?php
            }
            ?>
            <?php
            if ($eventSecButtonText) {
              ?>
              <div class="button-div"><a href="#" class="button"><?php echo $eventSecButtonText ?></a></div>
              <?php
            }
            ?>
          </div>
          <?php
        }
        ?>
        <div class="events-slider-outer">
          <div class="events-slider-wrapper">
            <div class="content-wrapper">
              <?php

              foreach ($latest_event as $event) {
                $id = $event->ID;
                ?>
                <div class="each-event">
                  <div class="top">
                    <div class="left">
                      <h2>
                        <?php echo ($event->post_title); ?>
                      </h2>
                    </div>
                    <div class="right">
                      <?php
                      $date = get_field('event_date', $id);
                      $dayName = date('l', strtotime($date));
                      $day = date('d', strtotime($date));
                      $month = date('M’y', strtotime($date));
                      $description = get_field('event_description', $id);
                      $eventColor = get_field('event_color', $id);

                      ?>
                      <div class="date">
                        <div class="day" style="color:<?php echo $eventColor ?>">
                          <?php echo $day; ?>
                        </div>
                        <div class="month" style="color:<?php echo $eventColor ?>">
                          <?php echo $month; ?>
                        </div>
                      </div>
                      <div class="day-name" style="background:<?php echo $eventColor ?>">
                        <?php echo $dayName ?>
                      </div>
                    </div>
                  </div>
                  <?php
                  ?>
                  <a href="<?php echo get_permalink($id); ?>" class="content-div ">
                    <p>
                      <?php if ($event->post_excerpt) {
                        echo ($event->post_excerpt);
                      } else {
                        echo $description;
                      }
                      ?>
                    </p>
                    <img src="<?php echo get_stylesheet_directory_uri() ?>/img/diagonal-arrow.svg" alt="Go">
                  </a>

                </div>
                <?php
              }
              ?>
            </div>
            <div class="pager-div">
              <div class="pager">
                <div class="prev">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12.728" height="9.091" xmlns:v="https://vecta.io/nano">
                    <path
                      d="M11.819 5.41H3.101l2.082 2.082a.91.91 0 0 1-.38 1.572.91.91 0 0 1-.902-.29L.265 5.138a.91.91 0 0 1 0-1.282L3.901.22a.91.91 0 0 1 1.282 1.282L3.101 3.593h8.718a.91.91 0 0 1 .787 1.364.91.91 0 0 1-.787.454z"
                      fill="#fff" />
                  </svg>
                </div>
                <div class="next">
                  <svg xmlns="http://www.w3.org/2000/svg" width="12.728" height="9.091" xmlns:v="https://vecta.io/nano">
                    <path
                      d="M11.819 5.41H3.101l2.082 2.082a.91.91 0 0 1-.38 1.572.91.91 0 0 1-.902-.29L.265 5.138a.91.91 0 0 1 0-1.282L3.901.22a.91.91 0 0 1 1.282 1.282L3.101 3.593h8.718a.91.91 0 0 1 .787 1.364.91.91 0 0 1-.787.454z"
                      fill="#fff" />
                  </svg>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
      <?php
    }
    ?>
    <?php get_template_part('blocks/member-benefits/member-benefits'); ?>
  </div>
  <?php get_footer(); ?>
