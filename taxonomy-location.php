<?php get_header(); ?>
<?php
$term = get_queried_object();
$backgroundColor = get_field('location_color', $term);
?>
<div class="location-taxonomy-page" style="background-color: <?php echo $backgroundColor; ?>">
	<div class="top-section">
		<div class="wrap">
			<div class="top-section-content">
				<div class="left">
					<div class="row">
						<div class="mobile-only">
							<?php the_field('location_icon', $term); ?>
						</div>
						<h1>
							<?php echo $term->name; ?>
						</h1>
					</div>
					<p>
						<?php echo $term->description; ?>
					</p>
				</div>
				<div class="right">
					<?php the_field('location_icon', $term); ?>
				</div>

			</div>
		</div>
	</div>
	<div class="tab-section">
		<div class="wrap">
			<div class="tab-container">
				<?php
				$args = array(
					'post_type' => 'activity',
					'posts_per_page' => -1,
					'tax_query' => array(
						array(
							'taxonomy' => 'location',
							'field' => 'id',
							'terms' => $term->term_id,
						),
					),
				);
				$first = true;
				$query = new WP_Query($args);
				if ($query->have_posts()) {
					while ($query->have_posts()) {
						$query->the_post();
						$post_id = get_the_ID();
						$post_slug = get_post_field('post_name', $post_id);
						$class_name = 'each-tab';
						if ($first) {
							$class_name = 'each-tab active';
							$first = false;
						}
						?>
						<a href="#<?php echo $post_slug; ?>" class="<?php echo $class_name; ?>">
							<?php the_title(); ?>
						</a>
						<?php
					}
					wp_reset_postdata();
				}
				?>
			</div>

			<div class="mobile-only-tab-container">
				<button id="prev-button" class="btn prev-btn">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Previous">
				</button>
				<select id="activity-select">
					<?php
					$args = array(
						'post_type' => 'activity',
						'posts_per_page' => -1,
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
							$image = get_field('tab_icon');
							$title = get_the_title();
							echo '<option value="' . esc_attr($post_slug) . '">';
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
				<button id="next-button" class="btn next-btn"> <img
						src="<?php echo get_stylesheet_directory_uri() ?>/img/left-white.svg" alt="Next">
				</button>
			</div>
		</div>
	</div>
	<?php
	$args = array(
		'post_type' => 'activity',
		'posts_per_page' => -1,
		'tax_query' => array(
			array(
				'taxonomy' => 'location',
				'field' => 'id',
				'terms' => $term->term_id,
			),
		),
	);
	$first = true;
	$query = new WP_Query($args);
	if ($query->have_posts()) {
		?>
		<section class="section-1">
			<?php
			while ($query->have_posts()) {
				$query->the_post();
				$id = get_the_ID();
				$post_slug = get_post_field('post_name', $id);
				$class_name = 'activities-section';
				if ($first) {
					$class_name = 'activities-section active';
					$first = false;
				}
				?>
				<div id="<?php echo $post_slug; ?>" class="<?php echo $class_name; ?>">
					<div class="content-wrap">
						<div class="left">
							<div class="left-wrap">
								<div class="col">
									<?php
									$activityIcon = get_field('activity_icon');
									if ($activityIcon) {
										echo wp_get_attachment_image($activityIcon, "full");
									}
									?>
									<h2>
										<?php echo get_the_title(); ?>
									</h2>
									<p>
										<?php echo get_the_excerpt(); ?>
									</p>
									<div class="button-div">
										<a class="button" href="#">Book Now</a>
									</div>
								</div>
								<div class="meta-data-wrapper">
									<div class="mobile-only img-wrap">
										<?php
										if ($activityIcon) {
											echo wp_get_attachment_image($activityIcon, "full");
										}
										?>
									</div>
									<div class="content-wrap">
										<div class="row">
											<?php echo (get_field('price', $id)); ?>
										</div>
										<div class="row">
											<?php echo (get_field('duration', $id)); ?>
										</div>
										<div class="row">
											<?php
											$age_array = get_field('age_group', $id);
											echo $age_array;
											?>
										</div>
										<div class="row">
											<?php echo (get_field('maximum_players', $id)); ?>
										</div>
									</div>
								</div>

							</div>
						</div>
						<div class="right">
							<div class="activity-single-page-slider">
								<?php
								if (have_rows('images_for_slider')):
									while (have_rows('images_for_slider')):
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
						</div>
					</div>
				</div>
				<?php
			}
			?>
		</section>
		<?php
		wp_reset_postdata();
	}
	?>

	<section class="section-3">
		<div class="wrap">
			<div class="left">
				<h2>
					HOST A BOWLING EVENT
				</h2>
				<p>
					Lorem Ipsum is simply dummy text of the printing and typesetting industry.
				</p>
			</div>
			<div class="events-list">
				<?php
				$args = array(
					'numberposts' => 3,
					'post_type' => 'event'
				);

				$latest_event = get_posts($args);
				foreach ($latest_event as $event) {
					?>
					<a href="#" class="single-item">
						<?php
						$image = get_field('event_icon', $event->ID);
						if ($image) {
							echo wp_get_attachment_image($image, "full");
						} ?>
						<?php
						$title = get_field('title', $event->ID);
						if ($title) {
							?>
							<p><?php echo $title ?></p>
							<?php
						}
						?>
					</a>
					<?php
				}
				?>
				<a href="#" class="single-item">
					<img src="<?php echo get_stylesheet_directory_uri() ?>/img/light.svg" alt="Got Other ideas?">
					<p>Got other ideas?</p>
				</a>
			</div>
		</div>
	</section>
	<section class="section-4">
		<div class="top-section">
			<h2 class="event-title">BOWLING SPECIALS</h2>
		</div>
		<div class="offer-slider-wrapper">
			<div class="content-wrapper">
				<?php
				if (have_rows('offers_at_play', 'option')):
					while (have_rows('offers_at_play', 'option')):
						the_row();
						$image = get_sub_field('image');
						$title = get_sub_field('title');
						$subTitle = get_sub_field('subtitle');
						$description = get_sub_field('description');
						/* Date format */
						$startDate = get_sub_field('offer_starting_date'); // Assuming dates are in 'Y-m-d' format
						$endDate = get_sub_field('offer_end_date');

						?>
						<div class="single-slide">
							<?php
							if ($image) {
								echo wp_get_attachment_image($image, 'full');
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
					endwhile;
				endif;
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
	</section>
	<section class="section-5">
		<div class="top-section">
			<h2>BOWLING EVENTS</h2>
			<div class="button-div"><a href="#" class="button">View all events</a></div>
		</div>
		<div class="events-slider-wrapper">
			<div class="content-wrapper">
				<?php
				$args = array(
					'numberposts' => -1,
					'post_type' => 'event',
					'orderby' => 'post_date',
					'order' => 'DESC',
				);
				$latest_event = get_posts($args);
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
	</section>
	<section class="section-6">
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
	</section>
</div>
<?php get_footer(); ?>