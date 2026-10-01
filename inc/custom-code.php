<?php
/** Migrated Simple Custom CSS and JS entries. See docs/CUSTOM-CODE-MIGRATION.md. */

// Leave the originals in the database for rollback; suppress only migrated frontend files.
function playarena_suppress_migrated_custom_code() {
    if (!function_exists('CustomCSSandJS')) {
        return;
    }
    $plugin = CustomCSSandJS();
    if (!is_array($plugin->search_tree)) {
        return;
    }
    $migrated = array(577, 871, 1416, 1434, 1700, 1870, 1899, 2272, 2273, 2274, 2275, 2278);
    foreach ($plugin->search_tree as $location => $files) {
        if (strpos($location, 'frontend-') !== 0 || !is_array($files)) {
            continue;
        }
        $plugin->search_tree[$location] = array_values(array_filter($files, function ($file) use ($migrated) {
            return !preg_match('/^(\d+)\.(?:css|js|html)(?:\?.*)?$/', $file, $match)
                || !in_array((int) $match[1], $migrated, true);
        }));
    }
}
add_action('after_setup_theme', 'playarena_suppress_migrated_custom_code', 20);

// Runs after order-confirmation rendering and before WordPress prints footer scripts.
function playarena_prepare_purchase_event() {
    if (!function_exists('is_order_received_page') || !is_order_received_page()
        || !function_exists('wc_get_order') || !wp_script_is('index-js', 'enqueued')) {
        return;
    }
    $order_id = absint(get_query_var('order-received'));
    $key = isset($_GET['key']) && is_string($_GET['key']) ? wc_clean(wp_unslash($_GET['key'])) : '';
    $order = $order_id ? wc_get_order($order_id) : false;
    if (!$order || !$key || !hash_equals($order->get_order_key(), $key) || !$order->is_paid()) {
        return;
    }

    // Let configured native integrations own their purchase events and consent behavior.
    if ($order->meta_exists('_meta_purchase_tracked_browser') || $order->meta_exists('_meta_purchase_tracked_server')) {
        return;
    }
    if (function_exists('PixelYourSite\\Facebook') && function_exists('PixelYourSite\\PYS')
        && \PixelYourSite\Facebook()->configured()
        && \PixelYourSite\Facebook()->getOption('woo_purchase_enabled')
        && \PixelYourSite\PYS()->getOption('woo_purchase_enabled')) {
        return;
    }

    $event = array(
        'eventId' => 'playarena-purchase-' . hash('sha256', $order->get_order_key()),
        'value' => (float) $order->get_total(),
        'currency' => $order->get_currency(),
    );
    wp_add_inline_script('index-js', 'window.playarenaPurchase = ' . wp_json_encode($event) . ';', 'before');
}
add_action('wp_footer', 'playarena_prepare_purchase_event', 5);
