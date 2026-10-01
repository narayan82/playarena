<?php
/**
 * Events Block.
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
$class_name = 'block-events';
if (!empty($block['className'])) {
	$class_name .= ' ' . $block['className'];
}
if (!empty($block['align'])) {
	$class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
?>
<!-- events starts here -->
<div <?php echo $anchor; ?> class="<?php echo esc_attr($class_name); ?>">
	<div class="content-wrapper">
		<?php
		$display_option = get_field('display_option');
		if ($display_option === 'selected') {
			if (have_rows('event_list')):
				while (have_rows('event_list')):
					the_row();
					$event = get_sub_field('event');
					if ($event):
						$id = $event->ID;
						$title = get_field('title', $id);
						$icon = get_field('event_icon', $id);
						?>
						<div class="each-content">
							<div class="top-sec">
								<?php
								if ($icon) {
									echo wp_get_attachment_image($icon, "full");
								}
								if ($title) {
									?>
									<p class="event-title"><?php echo esc_html($title); ?></p>
									<?php
								}
								?>
							</div>
							<div class="img-div">
								<?php echo get_the_post_thumbnail($id); ?>
							</div>
							<div class="content-div">
								<div class="top">
									<p><?php echo esc_html($event->post_excerpt); ?></p>
								</div>
								<div class="btn-container">
									<a href="<?php echo get_permalink($id); ?>" class="button" title="Find out More">Find out more
										<svg xmlns="http://www.w3.org/2000/svg" width="18" height="15.379" viewBox="0 0 18 15.379">
											<path id="Path_498" data-name="Path 498"
												d="M7.689,0,0,7.689,1.244,8.934l5.565-5.56V18H8.57V3.373l5.561,5.56,1.248-1.244Z"
												transform="translate(18) rotate(90)" />
										</svg>
									</a>
								</div>
							</div>
						</div>
						<?php
					endif;
				endwhile;
			endif;
		} else {

			$args = array(
				'numberposts' => 3,
				'post_type' => 'event',
				'orderby' => 'post_date',
				'order' => 'DESC',
			);

			$latest_event = get_posts($args);
			foreach ($latest_event as $event) {
				$id = $event->ID;
				?>
				<div class="each-content">
					<div class="top-sec">
						<?php
						$title = get_field('title', $id);
						$icon = get_field('event_icon', $id);
						if ($icon) {
							echo wp_get_attachment_image($icon, "full");
						}
						if ($title) {
							?>
							<p class="event-title"><?php echo $title ?></p>
							<?php
						}
						?>
					</div>
					<div class="img-div">
						<?php
						echo get_the_post_thumbnail($id)
							?>
					</div>
					<div class="content-div">
						<div class="top">
							<p>
								<?php echo ($event->post_excerpt); ?>
							</p>
						</div>

						<div class="btn-container">
							<a href="<?php echo get_permalink($id); ?>" class="button" title="Find out More">Find out more
								<svg xmlns="http://www.w3.org/2000/svg" width="18" height="15.379" viewBox="0 0 18 15.379">
									<path id="Path_498" data-name="Path 498"
										d="M7.689,0,0,7.689,1.244,8.934l5.565-5.56V18H8.57V3.373l5.561,5.56,1.248-1.244Z"
										transform="translate(18) rotate(90)" />
								</svg>
							</a>
						</div>
					</div>
				</div>
				<?php
			}
		}
		?>
	</div>
</div>
<!-- events ends here -->