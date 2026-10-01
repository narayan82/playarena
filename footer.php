<footer class="main-footer">
	<?php if (is_front_page()) {
		?>
		<div class="top-footer">
			<div class="wrap">
				<a title="<?php bloginfo('name'); ?>" href="<?php bloginfo('url') ?>" class="logo">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.svg" alt="Footer Logo">
				</a>
				<div class="footer-content-wrapper">

					<div class="left">
						<?php
						$subscribeTitle = get_field('subscribe_title', 'option');
						if ($subscribeTitle) { ?>
							<h2 class="subscribe-title"><?php echo $subscribeTitle ?></h2>
							<?php
						}
						?>
						<?php echo do_shortcode('[gravityform id="2" title="true" description="false" ajax="true"]'); ?>
						<div class="mobile-only contact-sec">
							<a href="tel:+999000999221" aria-label="call this number"><img
									src="<?php echo get_stylesheet_directory_uri() ?>/img/phone-icon.svg" alt="Phone" width="25"
									height="25"></a>
							<a href="https://wa.me/919900099922" aria-label="whatsapp this number"><img
									src="<?php echo get_stylesheet_directory_uri() ?>/img/whatapp-icon.svg" alt="whatsapp" width="25"
									height="25"></a>
							<a href="https://maps.app.goo.gl/p6gqBPoXFDihX1jY6" aria-label="Google map location"><img
									src="<?php echo get_stylesheet_directory_uri() ?>/img/location-icon.svg" alt="location" width="25"
									height="25"></a>
					
						</div>
					</div>
					<div class="middle">
						<div class="address">
							<?php the_field('address', 'options'); ?>
						</div>
						<?php if (have_rows('social_media', 'options')): ?>
							<div class="social-media">
								<?php
								while (have_rows('social_media', 'options')):
									the_row();
									$image = get_sub_field('icon');
									if ($image) {
										?>
										<a href="<?php echo get_sub_field('link'); ?>" aria-label="go to social media">
											<?php echo wp_get_attachment_image($image, 'full'); ?>
										</a>
										<?php
									}
								endwhile;
								?>
							</div>
						<?php endif; ?>

					</div>
					<div class="right">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-menu-1',
								'container_class' => 'footer-navbar first',
								'container' => 'nav',
								'menu_class' => 'footer-nav first'
							)
						);
						?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer-menu-2',
								'container_class' => 'footer-navbar second',
								'container' => 'nav',
								'menu_class' => 'footer-nav second '
							)
						);
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	<div class="bottom-footer">
		<div class="wrap">
			<div class="content-container">

				<div class="cr">Copyright &copy;
					<?php echo date('Y'); ?>. All rights reserved.
				</div>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'footer-menu',
						'container_class' => 'footer-navbar',
						'container' => 'nav',
						'menu_class' => 'footer-nav'
					)
				);
				?>
			</div>
		</div>
	</div>
</footer>
<?php wp_footer(); ?>
</body>

</html>