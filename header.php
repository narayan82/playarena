<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<script src="https://analytics.ahrefs.com/analytics.js" data-key="1uI32Uue0KKokw9vIq5wvQ" async></script>
	<meta charset="<?php bloginfo('charset'); ?>" />
	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="title" content="Play Arena:Bangalore’s Ultimate Fun and Games Spot " />
	<meta name="description"
		content="Play Arena in Bangalore the ultimate destination for sports, fun games, events, delicious food, team-building,birthday parties and a vibrant venue for all ages " />

	<meta name="keywords"
		content="go karting,go kart go kart,go karts near me, go kart track, adventure resorts in bangalore, best resorts in bangalore for day outing,places to visit in bangalore,1st birthday decorations,birthday party venues near me" />

	<?php if (is_page('sleepover-best-hotel-in-bangalore')) { ?>
		<link rel="preload" as="video" href="https://playarena.in/wp-content/uploads/2025/12/18-Rooms_Gossip_2.webm" type="video/webm"> <?php } ?>
	<?php #get_template_part('parts/favicon', ''); ?>
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=AW-11332844209">
	</script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag() { dataLayer.push(arguments); }
		gtag('js', new Date());
		gtag('config', 'AW-11332844209');
	</script>
	<meta name="google-site-verification" content="S-jw5nLqxuWqIFWYwrS75j5KrC85lk4taT-SwiKGi2o" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header class="header-main">
		<div class="wrap">
			<div class="header-outer-wrapper">
				<div class="mobile-only hamburger">
					<div class="line"></div>
				</div>
				<a title="<?php bloginfo('name'); ?>" href="<?php bloginfo('url') ?>" class="logo">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/img/logo.svg" alt="Play Arena" width="60" height="30">
				</a>
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'header-menu',
						'container_class' => 'header-navbar',
						'container' => 'nav',
						'menu_class' => 'header-nav flex-row',
						'walker' => new AWP_Menu_Walker()
					)
				);
				?>
			</div>
			<div class="mobile-only-icons-wrapper">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'mobile-menu-icons',
						'container_class' => 'header-navbar-mobile',
						'container' => 'nav',
						'menu_class' => 'header-nav flex-row',
					)
				);
				?>
			</div>
		</div>
	</header>