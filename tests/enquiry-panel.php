<?php
// Run with PHP CLI; no WordPress writes or notifications are performed.
$filters = array();
function add_action(...$args) {}
function add_filter($hook, $callback, $priority = 10, $count = 1) { global $filters; $filters[$hook][$priority][] = $callback; }
function is_page($id) { return $id === 1900; }
function is_email($value) { return filter_var($value, FILTER_VALIDATE_EMAIL); }
require __DIR__ . '/../inc/enquiry-panel.php';
function check($condition, $message) { if (!$condition) throw new RuntimeException($message); }
$_GET['enquiry_panel'] = '1';
$form = array('fields' => array(), 'button' => array());
foreach (array(42 => 'WrapperBegin', 7 => 'html', 9 => 'text', 10 => 'text', 11 => 'text', 14 => 'select', 20 => 'checkbox', 40 => 'html', 41 => 'textarea', 44 => 'WrapperEnd') as $id => $type) {
    $form['fields'][] = (object) array('id' => $id, 'type' => $type, 'cssClass' => '', 'label' => 'Label*', 'isRequired' => in_array($id, array(9, 10, 11)));
}
$panel = playarena_panel_form($form);
check(array_column($panel['fields'], 'id') === array(9, 10, 11, 41, 14, 20), 'Contact fields must precede all original event fields.');
check(!$panel['fields'][3]->isRequired, 'Notes must remain optional.');
$_POST = array('playarena_enquiry_intent' => 'callback', 'input_9' => 'Example', 'input_41' => 'Notes', 'input_14' => 'Birthday', 'input_20_1' => 'Play Time', 'gform_submit' => '4');
$filters['gform_pre_validation_4'][20][0]($panel);
check(isset($_POST['input_9'], $_POST['input_41'], $_POST['gform_submit']), 'Callback must keep contact, notes, and submission token.');
check(!isset($_POST['input_14'], $_POST['input_20_1']), 'Callback must omit optional event choices.');
$result = $filters['gform_field_validation_4_11'][10][0](array('is_valid' => true), 'not-email');
check(!$result['is_valid'], 'Invalid email must fail server validation.');
unset($_GET['enquiry_panel']);
check(playarena_panel_form($form) === $form, 'Normal Gravity Forms rendering must remain unchanged.');
echo "Enquiry panel field order, callback payload, email validation and normal-form fallback passed.\n";
