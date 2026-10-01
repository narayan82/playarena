<?php
/**
 * Hero Slider Block.
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
$class_name = 'block-hero-slider';
if (!empty($block['className'])) {
	$class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- hero-slider starts here -->
<?php
/* since this is above the fold, I am loading the css inline */
?>
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
	<?php
	$terms = get_terms(
		array(
			'taxonomy' => 'location',
			'hide_empty' => false,
			'orderby' => 'meta_value_num',
			'order' => 'ASC',
			'meta_query' => array(
				'relation' => 'OR',
				array(
					'key' => 'activity_order',
					'compare' => 'NOT EXISTS'
				),
				array(
					'key' => 'activity_order',
					'value' => 0,
					'compare' => '>='
				)
			),
		)
	);
	$count = 0;
	?>
	<div class="img-section" style="display:flex">
		<?php
		foreach ($terms as $term) {
			$color = get_field('location_color', $term);
			?>
			<div class="each-content each-content-<?php echo $count; ?> <?php if ($count == 0)
						echo 'active'; ?>" data-count="<?php echo $count; ?>">
				<?php
				$video = get_field('location-video', $term);
				$image = get_field('location_image', $term);
				if ($video) {
					echo '<video playsinline autoplay muted loop poster="' . esc_url($image) . '"><source src="' . esc_url($video) . '" type="video/mp4"></video>';
				} elseif ($image) {
					echo '<img src="' . esc_url($image) . '" alt="Location Image" />';
				}
				?>
				<div class="progress">
					<div class="progress-bar" style="background-color: <?php echo esc_attr($color); ?>"></div>
				</div>
			</div>
			<?php
			$count++;
		}
		?>
	</div>
	<div class="mobile-tab-section">
		<?php
		$count = 0;
		foreach ($terms as $term) {
			$color = get_field('location_color', $term);
			?>
			<div class="single-tab single-tab-<?php echo $count; ?> <?php if ($count == 0)
						echo 'active'; ?>" data-count="<?php echo $count; ?>">
				<?php echo get_field('location_icon', $term); ?>
			</div>
			<style>
				.single-tab-<?php echo $count; ?> path {
					fill:
						<?php echo $color; ?>
					;
				}

				.active.single-tab-<?php echo $count; ?>,
				.single-tab-<?php echo $count; ?>:hover {
					background-color:
						<?php echo $color; ?>
					;
				}

				.active.single-tab-<?php echo $count; ?> path,
				.single-tab-<?php echo $count; ?>:hover path {
					fill: #000;
				}
			</style>
			<?php
			$count++;
		}
		?>
	</div>
	<div class="tab-section" style="display:flex">
		<?php
		$count = 0;
		foreach ($terms as $term) {
			$color = get_field('location_color', $term);
			?>
			<div class="single-tab single-tab-<?php echo $count; ?> <?php if ($count == 0)
						echo 'active'; ?>" style="--hero-tab-color: <?php echo esc_attr($color); ?>; background-color: <?php echo esc_attr($color); ?>" data-count="<?php echo $count; ?>">
				<div class="top-section">
					<div class="title-section">
						<?php echo get_field('location_icon', $term); ?>
						<h2>
							<?php echo ($term->name); ?>
						</h2>
					</div>
					<p>
						<?php echo ($term->description); ?>
					</p>
				</div>
				<div class="button-div">


					<?php
					// Get the first post for the current term
					$first_activity_query = new WP_Query(
						array(
							'post_type' => 'activity',
							'tax_query' => array(
								array(
									'taxonomy' => 'location',
									'field' => 'term_id',
									'terms' => $term->term_id,
								),
							),
							'posts_per_page' => 1,
						)
					);

					if ($first_activity_query->have_posts()) {
						$first_activity_query->the_post();
						$first_activity_url = get_permalink();
						?>
						<a href="<?php echo esc_url($first_activity_url); ?>" class="button">
							View All
							<?php
							$termCount = $term->count;
							if ($termCount > 1) {
								echo $termCount . ' Activities';
							} else {
								echo $termCount . ' Activity';
							}
							?>
						</a>
						<?php
						wp_reset_postdata(); // Reset post data after custom query
					} else {
						?>
						<span>No Activities Available</span>
						<?php
					}
					?>

					<!-- old style, redirect to the taxonamy location page -->
					<?php /*
																																																																 <a href="<?php echo esc_url($first_activity_url); ?>" class="button">
																																																																	 View All
																																																																	 <?php
																																																																	 $termCount = $term->count;
																																																																	 if ($termCount > 1) {
																																																																		 echo $termCount . ' Activities';
																																																																	 } else {
																																																																		 echo $termCount . ' Activity';
																																																																	 }
																																																																	 ?>
																																																																 </a>
																																																																 */ ?>
				</div>
			</div>
			<?php
			$count++;
		}
		?>
	</div>

</div>