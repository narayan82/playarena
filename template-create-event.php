<?php
/*Template Name: Create Event */
?>
<?php get_header(); ?>
<?php $id = get_the_ID(); ?>
<div class="single-page-banner">
  <div class="wrap">
    <div class="content-wrap">
      <h1>
        <?php echo get_the_title(); ?>
      </h1>
      <p>
        <?php echo get_the_excerpt(); ?>
      </p>
      <a href="">Enquire Now</a>
    </div>
  </div>
</div>

<div class="event-spaces-section">
  <div class="wrap">
    <h2>Pick a Space</h2>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. ?</p>
  </div>
  <div class="event-spaces-container">
    <?php
    $spaces = get_field('spaces', $id);
    if ($spaces): ?>
      <?php foreach ($spaces as $space): ?>
        <div class="each-space">
          <h2>
            <?php echo esc_html($space->name); ?>
          </h2>
          <p>
            <?php echo esc_html($space->description); ?>
          </p>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<div class="activity-slider-section">
  <div class="wrap">
    <h2>Add some Fun</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis quisquam modi expedita quis quia quae eum
      dolorum impedit odit vero, ipsa soluta, reprehenderit ullam facilis ex minus illum quos aperiam.</p>
  </div>
  <?php $activities = get_field('activities', $id); ?>
  <?php
  $age_groups = get_field('select_an_age_group');
  if ($age_groups): ?>

    <?php echo $age_groups; ?>

  <?php endif; ?>
  <div class="activity-slider-container">
    <?php
    if ($activities) {
      foreach ($activities as $activity) {
        ?>
        <div class="each-activity">
          <h2>
            <?php echo $activity->post_title; ?>
          </h2>
          <p>
            <?php echo $activity->post_excerpt; ?>
          </p>
        </div>
        <?php
      }
    } ?>
  </div>
</div>

<div class="entertainment-section">
  <?php $entertainment_activities = get_field('entertainment', $id); ?>
  <div class="wrap">
    <h2>Entertainment and Merchandise</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Perspiciatis quisquam modi expedita quis quia quae eum
      dolorum impedit odit vero, ipsa soluta, reprehenderit ullam facilis ex minus illum quos aperiam.</p>
  </div>
  <div class="activity-slider-container">
    <?php
    $count = 0;
    if ($entertainment_activities) {
      foreach ($entertainment_activities as $entertainment_activity) {
        ?>
        <div class="each-activity">
          <h2>
            <?php echo $entertainment_activity->post_title; ?>
          </h2>
          <p>
            <?php echo $entertainment_activity->post_excerpt; ?>
          </p>
        </div>
        <?php
      }
    } ?>
  </div>
</div>

<div class="food-and-beverage-section">
  <div class="wrap">
    <h2>Add Food and Beverages</h2>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Error tempore cupiditate repellat itaque libero sunt
      pariatur, </p>
    <div class="food-container">
      <?php
      $cusines = get_field('food_and_beverages', $id);
      if ($cusines): ?>
        <?php foreach ($cusines as $cusine): ?>
          <div class="each-card">
            <h2>
              <?php echo esc_html($cusine->name); ?>
            </h2>
            <p>
              <?php echo esc_html($cusine->description); ?>
            </p>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
  </div>
</div>



<div class="facilities-section">
  <div class="wrap">
    <h2>
      Facilities that make PLaY Great
    </h2>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Temporibus doloribus nam in excepturi. </p>
    <div class="facilities-container">
      <?php
      if (have_rows('facilities')):
        while (have_rows('facilities')):
          the_row();
          ?>
          <div class="each-content">
            <?php echo (get_sub_field('facility')); ?>
            <?php
            $image = get_sub_field('image_for_facility');
            $size = 'full';
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

<div class="event-stories-section">
  <div class="wrap">
    <h2>
      Event Stories
    </h2>
    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Temporibus doloribus nam in excepturi. </p>
    <div class="stories-container">
      <?php
      if (have_rows('stories')):
        while (have_rows('stories')):
          the_row();
          ?>
          <div class="each-story">
            <h2>
              <?php echo (get_sub_field('name')); ?>
            </h2>
            <h2>
              <?php echo (get_sub_field('story_user_name')); ?>
            </h2>
            <?php
            $video = get_sub_field('story_video');
            ?>
            <video loop playsinline autoplay muted loading="lazy" preload="none" src="<?php echo $video; ?>" width="300"
              height="535" class="video video-glightbox"></video>
            <?php ?>
          </div>
          <?php
        endwhile;
      endif;
      ?>
    </div>
  </div>
</div>

<div class="form-section">
  <div class="wrap">
    <?php echo do_shortcode('[gravityform id="1" title="false" description="false" ajax="true"]'); ?>
  </div>
</div>
<?php get_footer(); ?>