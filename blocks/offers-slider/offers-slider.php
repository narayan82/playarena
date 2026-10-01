<?php
/**
 * Offers Slider Block.
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
$class_name = 'block-offers-slider';
if (!empty($block['className'])) {
	$class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- offers-slider starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
	<div class="content-container">
		<div class="offer-slider" style="display:flex" role="region" aria-label="Image Carousel">
			<?php
			$args = array(
				'numberposts' => -1,
				'post_type' => 'specials',
				'orderby' => 'post_date',
				'order' => 'DESC',
			);
			$latest_specials = get_posts($args);
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
				<div class="single-slide" role="group" aria-roledescription="slide">
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
					<a class="button" target="_blank" href="<?php echo get_field('url', $specialId) ?>"><span>VIEW OFFER</span>
						<div class="icon-div"><svg xmlns="http://www.w3.org/2000/svg" width="19.79" height="19.79"
								viewBox="0 0 19.79 19.79">
								<path id="Diagonal_Arrow" data-name="Diagonal Arrow"
									d="M3.68,0V2.19H16.05L0,18.24l1.55,1.55L17.6,3.74V16.11h2.19V0Z" transform="translate(0)"
									fill="#007bfe" />
							</svg></div>
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
<!-- offers-slider ends here -->