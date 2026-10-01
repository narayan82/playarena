<?php
/**
 * Date Picker Block.
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
$class_name = 'block-date-picker';
if (!empty($block['className'])) {
	$class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- date-picker starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
	<div class="top-section">
		<div class="input-div">
			<label for="date-input">
				<input type="text" id="date-input" aria-label="Date picker">
			</label>
		</div>
		<?php
		if (have_rows('special_offers_details', 'option')):
			while (have_rows('special_offers_details', 'option')):
				the_row();
				if (get_sub_field('message', 'option')) {
					?>
					<div class="warning <?php echo get_sub_field('select_day') ?>">
						<div class="warning-section">
							<?php echo get_sub_field('message'); ?>
						</div>
					</div>
					<?php
				}
			endwhile;
		endif;
		?>
	</div>
	<?php
	if (have_rows('special_offers_details', 'option')):
		while (have_rows('special_offers_details', 'option')):
			the_row();
			?>
			<div class="content-wrapper <?php echo get_sub_field('select_day') ?> "
				data-dayname="<?php echo get_sub_field('select_day') ?>">
				<div class="row-2">
					<?php
					if (have_rows('add_details')):
						while (have_rows('add_details')):
							the_row();
							?>
							<div class="single-row">
								<div class="left">
									<p>
										<?php echo get_sub_field('heading'); ?>
									</p>
								</div>
								<div class="right">
									<?php
									if (have_rows('add_content')):
										while (have_rows('add_content')):
											the_row();
											?>
											<div class="each-content">
												<div class="top">
													<?php
													$image = get_sub_field('icon');
													if ($image) {
														echo wp_get_attachment_image($image, 'full');
													}
													?>
													<div class="sub-title <?php if (get_sub_field('sub_title'))
														echo 'active'; ?>"> <?php echo get_sub_field('sub_title'); ?></div>
												</div>
												<div class="bottom-content"><?php echo get_sub_field('content'); ?></div>
											</div>
											<?php
										endwhile;
									endif;
									?>
								</div>
							</div>
							<?php
						endwhile;
					endif;
					?>
				</div>
				<div>
					<a href="https://booking.playarena.in/" class="booking-btn">Book Now</a>
				</div>
			</div>
			<?php
		endwhile;
	endif;
	?>
</div>
<!-- date-picker ends here -->