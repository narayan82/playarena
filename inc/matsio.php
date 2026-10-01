<?php
/* Add Theme Support */
add_action('after_setup_theme', 'matsio_thumbnail_support');
function matsio_thumbnail_support()
{
  add_theme_support('post-thumbnails');
  add_theme_support('automatic-feed-links');
  add_theme_support('title-tag');
}

/* Branding the login page */
add_action('login_head', 'matsio_login_branding');
function matsio_login_branding()
{
  /*
  Branding for the forget password
  page.
  */
  $primary_color = LOGIN_COLORS['primary_color'];
  $primary_color_gradient = LOGIN_COLORS['primary_color_gradient'];
  $primary_color_shadow = LOGIN_COLORS['primary_color_shadow'];
  $secondary_color = LOGIN_COLORS['secondary_color'];
  $secondary_color_shadow = LOGIN_COLORS['secondary_color_shadow'];
  echo '
  <style type="text/css">
    :focus {
      outline : none !important;
    }
    body {
      background: -webkit-linear-gradient(' . $primary_color . ' 0%, ' . $primary_color_gradient . ' 100%);
      background: -o-linear-gradient(' . $primary_color . ' 0%, ' . $primary_color_gradient . ' 100%);
      background: linear-gradient(' . $primary_color . ' 0%, ' . $primary_color_gradient . ' 100%);
    }
    .login .message {
      border-left: 4px solid
    }
    h1 a {
      background-image:url(' . get_stylesheet_directory_uri() . '/img/logo.svg) !important;
      height: 30px !important;
      width: 268px !important;
      background-size: contain !important;
      margin-left: -40px;
    }
    .wp-core-ui .button-primary,
    .wp-core-ui .button-primary:active {
      background: ' . $secondary_color . ' !important;
      border-color: ' . $secondary_color . ' !important;
      text-shadow: 0 0px 0px ' . $secondary_color . ', 0px 0 0px ' . $secondary_color . ' !important;
      box-shadow: 0 1px 0 ' . $secondary_color_shadow . ';
    }
    .wp-core-ui .button-primary:active {
      box-shadow: inset 0 2px 0 ' . $primary_color_shadow . ';
    }
    .wp-core-ui .button-primary:hover,
    .wp-core-ui .button-primary:focus {
      background: ' . $primary_color . ' !important;
      border-color: ' . $primary_color . ' !important;
      text-shadow: 0 0px 0px ' . $primary_color . ', 0px 0 0px ' . $primary_color . ' !important;
      box-shadow: 0 1px 0 ' . $primary_color . ', 0 0 2px 1px ' . $primary_color_shadow . ';
    }
    .privacy-policy-link,
    .login #backtoblog a,
    .login #nav a {
      color: ' . $secondary_color . ' !important;
    }
  </style>';
}

/* IE 11 skip-link bug fix */
add_action('wp_print_footer_scripts', 'matsio_skip_link_focus_fix');
function matsio_skip_link_focus_fix()
{
  ?>
  <script>
    /(trident|msie)/i.test(navigator.userAgent) && document.getElementById && window.addEventListener && window.addEventListener("hashchange", function () { var t, e = location.hash.substring(1); /^[A-z0-9_-]+$/.test(e) && (t = document.getElementById(e)) && (/^(?:a|select|input|button|textarea)$/i.test(t.tagName) || (t.tabIndex = -1), t.focus()) }, !1);
  </script>
  <?php
}

/* Move YOAST SEO to bottom */
function matsio_yoasttobottom()
{
  return 'low';
}
add_filter('wpseo_metabox_prio', 'matsio_yoasttobottom');

/* Backend Dev Credit */
function matsio_footer_branding()
{
  echo 'Developed by <a rel="nofollow" target="_blank" href="https://matsio.com">Matsio</a>';
}
add_filter('admin_footer_text', 'matsio_footer_branding');

/* Widget in Dashboard */
function matsio_wpc_dashboard_widget_function()
{
  ?>
  <ul>
    <li>This site is proudly powered by Matsio.</li>
    <li>Support: <a href="mailto:hello@matsio.com">hello@matsio.com</a></li>
  </ul>
  <?php
}
function matsio_wpc_add_dashboard_widgets()
{
  wp_add_dashboard_widget('wp_dashboard_widget', 'Welcome', 'matsio_wpc_dashboard_widget_function');
}
add_action('wp_dashboard_setup', 'matsio_wpc_add_dashboard_widgets');

/* Change the title when hovered over the logo */
function matsio_change_title_on_logo()
{
  return CLIENT_NAME;
}
add_filter('login_headertitle', 'matsio_change_title_on_logo');

/* Remove unwanted widgets */
function matsio_remove_dashboard_meta()
{
  remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
  remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
  remove_meta_box('dashboard_primary', 'dashboard', 'side');
  remove_meta_box('dashboard_secondary', 'dashboard', 'normal');
  remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
  remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');
  remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
  remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
  remove_meta_box('dashboard_activity', 'dashboard', 'normal'); //since 3.8
  remove_meta_box('wpseo-dashboard-overview', 'dashboard', 'side');
}
add_action('admin_init', 'matsio_remove_dashboard_meta');

/* Remove unwanted sidebard widgets */
function matsio_remove_default_widgets()
{
  unregister_widget('WP_Widget_Pages');
  unregister_widget('WP_Widget_Calendar');
  unregister_widget('WP_Widget_Archives');
  unregister_widget('WP_Widget_Links');
  unregister_widget('WP_Widget_Meta');
  unregister_widget('WP_Widget_Text');
  unregister_widget('WP_Widget_RSS');
  unregister_widget('WP_Widget_Tag_Cloud');
  unregister_widget('Akismet_Widget');
  unregister_widget('WP_Nav_Menu_Widget');
}
add_action('widgets_init', 'matsio_remove_default_widgets', 11);

/* Login Logo Link */
function matsio_loginpage_custom_link()
{
  return get_bloginfo('url');
}
add_filter('login_headerurl', 'matsio_loginpage_custom_link');

/* Remove the default thumbnail sizes */
function matsio_update_default_image_size($old_theme_name, $old_theme = false)
{
  update_option('thumbnail_size_w', 0);
  update_option('thumbnail_size_h', 0);
  update_option('medium_size_w', 0);
  update_option('medium_size_h', 0);
  update_option('large_size_w', 0);
  update_option('large_size_h', 0);
}
add_action('after_switch_theme', 'matsio_update_default_image_size', 10, 2);