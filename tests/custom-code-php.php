<?php
// Run with PHP CLI; stubs keep these checks separate from WordPress and the database.
namespace PixelYourSite {
    function Facebook() { return $GLOBALS['native']; }
    function PYS() { return $GLOBALS['native']; }
}
namespace {
    function add_action(...$args) {}
    function CustomCSSandJS() { return $GLOBALS['plugin']; }
    function is_order_received_page() { return $GLOBALS['confirmation']; }
    function wp_script_is(...$args) { return true; }
    function get_query_var($name) { return $GLOBALS['order_id']; }
    function absint($value) { return abs((int) $value); }
    function wc_clean($value) { return trim($value); }
    function wp_unslash($value) { return $value; }
    function wc_get_order($id) { return $id === 42 ? $GLOBALS['order'] : false; }
    function wp_json_encode($value) { return json_encode($value); }
    function wp_add_inline_script($handle, $data, $position) { $GLOBALS['inline'][] = [$handle, $data, $position]; }
    function check($condition, $message) { if (!$condition) throw new \Exception($message); }
    $native = new class {
        public $active = false;
        function configured() { return $this->active; }
        function getOption($key) { return true; }
    };
    $order = new class {
        public $paid = true;
        public $tracked = false;
        function get_order_key() { return 'secret-order-key'; }
        function is_paid() { return $this->paid; }
        function meta_exists($key) { return $this->tracked; }
        function get_total() { return '1275.50'; }
        function get_currency() { return 'INR'; }
    };
    require __DIR__ . '/../inc/custom-code.php';
    $plugin = (object) ['search_tree' => [
        'frontend-css-header-internal' => ['1416.css', '9999.css'],
        'frontend-js-footer-internal' => ['2272.js','2273.js','2274.js'],
        'frontend-html-header-both' => ['2278.html'],
        'admin-css-header-internal' => ['1416.css'],
        'jquery' => true,
    ]];
    playarena_suppress_migrated_custom_code();
    check($plugin->search_tree['frontend-css-header-internal'] === ['9999.css'], 'Preserve new snippets');
    check($plugin->search_tree['frontend-js-footer-internal'] === [], 'Suppress duplicate JS');
    check($plugin->search_tree['frontend-html-header-both'] === [], 'Suppress old HTML script');
    check($plugin->search_tree['admin-css-header-internal'] === ['1416.css'], 'Preserve admin scope');
    check($plugin->search_tree['jquery'] === true, 'Preserve dependency flags');
    $confirmation = false; $order_id = 42; $_GET['key'] = 'secret-order-key'; $inline = [];
    playarena_prepare_purchase_event(); check(!$inline, 'No ordinary-page event');
    $confirmation = true; $_GET['key'] = 'incorrect';
    playarena_prepare_purchase_event(); check(!$inline, 'Reject invalid key');
    $_GET['key'] = ['bad'];
    playarena_prepare_purchase_event(); check(!$inline, 'Reject array key');
    $_GET['key'] = 'secret-order-key'; $order_id = 999;
    playarena_prepare_purchase_event(); check(!$inline, 'Reject nonexistent order');
    $order_id = 42; $order->paid = false;
    playarena_prepare_purchase_event(); check(!$inline, 'Reject unpaid order');
    $order->paid = true; $order->tracked = true;
    playarena_prepare_purchase_event(); check(!$inline, 'Defer to native Meta event');
    $order->tracked = false; $native->active = true;
    playarena_prepare_purchase_event(); check(!$inline, 'Defer to configured PixelYourSite');
    $native->active = false;
    playarena_prepare_purchase_event(); check(count($inline) === 1, 'Queue paid order');
    check($inline[0][0] === 'index-js' && $inline[0][2] === 'before', 'Place data before main JS');
    check(strpos($inline[0][1], '1275.5') !== false && strpos($inline[0][1], 'INR') !== false, 'Use actual total and currency');
    check(strpos($inline[0][1], 'secret-order-key') === false, 'Do not expose order key');
    echo "PHP: scoped suppression, order validation, paid totals, native tracker deferral and script placement passed.\n";
}
