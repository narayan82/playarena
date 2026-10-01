<?php get_header(); ?>
<div class="event-archive-page">
  <?php
  $args = array(
    'post_type' => 'event',
    'orderby' => 'post_date',
    'order' => 'DESC',
  );
  $post_type = get_post_type();
  $latest_event = get_posts($args);
  $count = $GLOBALS['wp_query']->post_count;
  $post_type_obj = get_post_type_object($post_type);
  if (isset($post_type_obj->description)) {
    $description = $post_type_obj->description;
  } else {
    $description = '';
  }
  ?>
  <div class="top-section">
    <div class="wrap">
      <h2>
        Events at PLaY
      </h2>
		<img src="https://playarena.in/wp-content/uploads/2024/09/eventsmascot.svg" class="events_icon">
      <p>Put your game-face on! Paintball shootouts, laser tag battles, football tournaments and more — join our championships or give us a call to organise one just for your gang of friends. Choose your side and fight it out in a range of events organised by Play.
        <!--<?php echo $description;
        ?> -->
      </p>
    </div>
  </div>

  <div class="wrap">
    <div class="content-wrapper">
      <p class="count">
        <?php echo $count; ?> Events Found
      </p>
      <div class="event-outer-wrapper">
        <?php
        foreach ($latest_event as $event) {
          $id = $event->ID;
          if ($event):
            $id = $event->ID;
            $date = get_field('event_date', $id);
            $day = date('d', strtotime($date));
            $month = date('M', strtotime($date));
            $description = get_field('event_description', $id);
            $eventColor = get_field('event_color', $id);
            ?>
            <div class="each-event">
              <div class="top">
                <div class="left">
                  <h2><?php echo esc_html($event->post_title); ?></h2>
                </div>
                <div class="right">
                  <?php
                  $date = get_field('event_date', $id);
                  $dayName = date('l', strtotime($date));
                  $day = date('d', strtotime($date));
                  $month = date('M’y', strtotime($date));
                  $description = get_field('event_description', $id)
                    ?>
                  <div class="date">
                    <div class="day">
                      <?php echo $day; ?>
                    </div>
                    <div class="month">
                      <?php echo $month; ?>
                    </div>
                  </div>
                  <div class="day">
                    <?php echo $dayName ?>
                  </div>

                </div>
              </div>
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
          endif;
        }
        ?>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>