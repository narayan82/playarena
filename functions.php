<?php
define('DEP_VERSION', time());
define('CLIENT_NAME', 'Play Arena');
define('LOGIN_COLORS', [
	'primary_color' => '#000000',
	'primary_color_gradient' => '#000000',
	'primary_color_shadow' => '#000000',
	'secondary_color' => '#007BFF',
	'secondary_color_shadow' => '#007BFF',
]);

require_once(__DIR__ . '/inc/matsio.php');
require_once(__DIR__ . '/inc/block-management.php');
require_once(__DIR__ . '/inc/custom-code.php');
require_once(__DIR__ . '/inc/enquiry-panel.php');

/* Use as required */
// set_post_thumbnail_size( 150, 150 );
// add_image_size( 'custom-size', 220, 180, true );


/* Loads Inline Styles */
add_action('wp_head', 'hook_css');
function hook_css()
{
	?>
	<style>
		<?php echo str_replace(
			'../',
			get_stylesheet_directory_uri() . '/',
			file_get_contents(__DIR__ . '/css/above-the-fold.min.css')
		); ?>
	</style>
	<style>
		<?php echo str_replace(
			'../',
			get_stylesheet_directory_uri() . '/',
			file_get_contents(__DIR__ . '/css/screen.min.css')
		); ?>
	</style>
	<?php
}

/* Loads Scripts and Styles */
add_action('wp_enqueue_scripts', 'matsio_front_end');
function matsio_front_end()
{
	wp_enqueue_script('jquery');
	if (is_singular('activity')) {
		wp_enqueue_style('activity-member-benefits', get_template_directory_uri() . '/blocks/member-benefits/css/member-benefits.min.css', array(), DEP_VERSION);
	}

	$dep = array('jquery');
	foreach (glob(get_template_directory() . '/js/vendor/*.js') as $file) {
		array_push($dep, basename($file));
		wp_enqueue_script(basename($file), get_template_directory_uri() . '/js/vendor/' . basename($file));
	}
	wp_enqueue_script('index-js', get_template_directory_uri() . '/js/index.js', $dep, DEP_VERSION, true);
}

/* Register Menus */
function register_menus()
{
	register_nav_menus(
		array(
			'header-menu' => __('Header Menu'),
			'footer-menu' => __('Footer Menu Terms'),
			'footer-menu-1' => __('Footer Menu First'),
			'footer-menu-2' => __('Footer Menu Second'),
			'mobile-menu-icons' => __('Mobile Menu Icons'),
		)
	);
}
add_action('init', 'register_menus');

if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
		'page_title' => 'Common Settings',
		'menu_title' => 'Common Settings',
		'menu_slug' => 'common-settings',
		'capability' => 'edit_posts',
		'redirect' => false,
	]);
}

class AWP_Menu_Walker extends Walker_Nav_Menu
{
	function start_el(&$output, $item, $depth = 0, $args = [], $id = 0)
	{
		$output .= "<li class='" . implode(" ", $item->classes) . "'>";

		if ($item->url && $item->url != '#') {
			$output .= '<a href="' . $item->url . '">';
		} else {
			$output .= '<a href="' . $item->url . '">';
		}

		$output .= $item->title;

		if ($item->url && $item->url != '#') {
			$output .= '</a>';
		} else {
			$output .= '</a>';
		}
		if (!empty($item->description)) {
			$output .= '<div class="description">' . $item->description . '</div>';
		}
	}
}

function checkArray($array)
{
	if ($array && is_array($array) && sizeof($array)) {
		return true;
	}
	return false;
}

function dequeue_dashicons()
{
	if (!is_user_logged_in() && !is_admin()) {
		wp_deregister_style('dashicons');
		wp_dequeue_style('dashicons');
	}
}
add_action('wp_enqueue_scripts', 'dequeue_dashicons');
function add_lazy_loading_attribute($content)
{
	return preg_replace('/(<img[^>]+)(\/?>)/', '$1 loading="lazy" $2', $content);
}
add_filter('the_content', 'add_lazy_loading_attribute');
add_filter('post_thumbnail_html', 'add_lazy_loading_attribute');
add_filter('get_avatar', 'add_lazy_loading_attribute');
