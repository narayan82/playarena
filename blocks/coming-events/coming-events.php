<?php
/**
 * Coming Events Block.
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
if ( ! empty( $block['anchor'] ) ) {
	$anchor = 'id="' . esc_attr( $block['anchor'] ) . '" ';
}

// Create class attribute allowing for custom "className" and "align" values.
$class_name = 'block-coming-events';
if ( ! empty( $block['className'] ) ) {
	$class_name .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
	$class_name .= ' align' . $block['align'];
}

// Build a valid style attribute for background and text colors.
$args = array(
	'numberposts' => -1,
	'post_type' => 'event',
);

$query = new WP_Query( $args );
if ( $query->have_posts() ) {
	?>
	<!-- coming-events starts here -->
	<div <?php echo $anchor; ?> class="<?php echo esc_attr( $class_name ); ?>">
		<div class="block-header-section">
			<div class="wrap">
				<h2>
					<?php the_field( 'coming_event_title' ); ?>
				</h2>
				<?php
				if ( get_field( 'show_more_button' ) ) {
					?>
					<div class="button-div">
						<a href="<?php echo get_site_url(); ?>/event/" class="button">View All Events</a>
					</div>
					<?php
				}
				?>
			</div>
		</div>
		<div class="events-outer-wrap">
			<div class="events-inner-container">
				<div class="content-wrapper">
					<?php
					$display_option = get_field( 'display_option' );
					if ( $display_option === 'selected' ) {
						if ( have_rows( 'event_list' ) ) :
							while ( have_rows( 'event_list' ) ) :
								the_row();
								$event = get_sub_field( 'event' );
								if ( $event ) :
									$id = $event->ID;
									$date = get_field( 'event_date', $id );
									$day = date( 'd', strtotime( $date ) );
									$month = date( 'M', strtotime( $date ) );
									$description = get_field( 'event_description', $id );
									$eventColor = get_field( 'event_color', $id );
									?>
									<div class="each-event">
										<div class="top">
											<div class="left">
												<h2><?php echo esc_html( $event->post_title ); ?></h2>
											</div>
											<div class="right">
												<?php
												$date = get_field( 'event_date', $id );
												$dayName = date( 'l', strtotime( $date ) );
												$day = date( 'd', strtotime( $date ) );
												$month = date( 'M’y', strtotime( $date ) );
												$description = get_field( 'event_description', $id )
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
										<a href="<?php echo get_permalink( $id ); ?>" class="content-div ">
											<p>
												<?php if ( $event->post_excerpt ) {
													echo ( $event->post_excerpt );
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
							endwhile;
						endif;
					} else {
						$args = array(
							'numberposts' => -1,
							'post_type' => 'event',
							'orderby' => 'post_date',
							'order' => 'DESC',
						);
						$latest_event = get_posts( $args );
						foreach ( $latest_event as $event ) {
							$id = $event->ID;
							?>
							<div class="each-event">
								<div class="top">
									<div class="left">
										<h2>
											<?php echo ( $event->post_title ); ?>
										</h2>
									</div>
									<div class="right">
										<?php
										$date = get_field( 'event_date', $id );
										$dayName = date( 'l', strtotime( $date ) );
										$day = date( 'd', strtotime( $date ) );
										$month = date( 'M’y', strtotime( $date ) );
										$description = get_field( 'event_description', $id );
										$eventColor = get_field( 'event_color', $id );
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
								<a href="<?php echo get_permalink( $id ); ?>" class="content-div ">
									<p>
										<?php if ( $event->post_excerpt ) {
											echo ( $event->post_excerpt );
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
	</div>
	<!-- coming-events ends here -->
	<?php
}
?>
