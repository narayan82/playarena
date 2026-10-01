<?php
/** Present the existing enquiry form in an isolated, same-origin panel document. */
function playarena_is_enquiry_panel() {
    return is_page(1900) && isset($_GET['enquiry_panel']) && $_GET['enquiry_panel'] === '1';
}
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('playarena-enquiry-panel', get_template_directory_uri() . '/js/enquiry-panel.js', array('jquery'), DEP_VERSION, true);
});

function playarena_panel_form($form) {
    if (!playarena_is_enquiry_panel()) return $form;
    $contact = array();
    $event = array();
    foreach ($form['fields'] as $field) {
        if (in_array($field->type, array('WrapperBegin', 'WrapperEnd'), true) || in_array((int) $field->id, array(7, 13, 40), true)) continue;
        $first = in_array((int) $field->id, array(9, 10, 11, 41), true);
        if ($first && (int) $field->id !== 41) $field->label = rtrim($field->label, '* ');
        $field->cssClass .= $first ? ' enquiry-contact-field' : ' enquiry-event-field';
        if ($field->type === 'checkbox') $field->description = '';
        if (in_array((int) $field->id, array(14, 15, 67, 68, 17, 18), true)) $field->cssClass .= ' enquiry-half-field';
        if ((int) $field->id === 41) {
            $field->label = 'Is there anything else we should know? (Optional)';
            $field->labelPlacement = 'top_label';
        }
        if ($first) $contact[] = $field;
        else $event[] = $field;
    }
    $form['fields'] = array_merge($contact, $event);
    $form['button']['text'] = 'Send my enquiry';
    return $form;
}
foreach (array('gform_pre_render_4', 'gform_pre_validation_4', 'gform_pre_submission_filter_4') as $hook) {
    add_filter($hook, 'playarena_panel_form');
}
// A callback request contains contact details and notes, not default event choices.
add_filter('gform_pre_validation_4', function ($form) {
    if (!playarena_is_enquiry_panel() || ($_POST['playarena_enquiry_intent'] ?? '') !== 'callback') return $form;
    foreach ($form['fields'] as $field) {
        if (in_array((int) $field->id, array(9, 10, 11, 41), true)) continue;
        $key = 'input_' . (int) $field->id;
        foreach (array_keys($_POST) as $posted_key) {
            if ($posted_key === $key || strpos($posted_key, $key . '_') === 0) unset($_POST[$posted_key]);
        }
    }
    return $form;
}, 20);
add_filter('gform_field_validation_4_11', function ($result, $value) {
    if (playarena_is_enquiry_panel() && !is_email($value)) {
        $result['is_valid'] = false;
        $result['message'] = 'Please enter a valid email address.';
    }
    return $result;
}, 10, 2);

add_action('template_redirect', function () {
    if (!playarena_is_enquiry_panel() || !function_exists('gravity_form')) return;
    nocache_headers();
    $requested_form = isset($_GET['enquiry_form']) ? (int) $_GET['enquiry_form'] : 4;
    $panel_form_id = in_array($requested_form, array(4, 5, 6), true) ? $requested_form : 4;
    gravity_form_enqueue_scripts($panel_form_id, true);
    ?>
    <!doctype html><html <?php language_attributes(); ?>>
    <head><meta charset="<?php bloginfo('charset'); ?>"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Plan your event | Play Arena</title><?php wp_head(); ?></head>
    <body class="enquiry-panel-document" data-enquiry-form="<?php echo (int) $panel_form_id; ?>">
    <main class="enquiry-flow">
        <header class="enquiry-flow-heading">
            <p class="enquiry-eyebrow">GOOD TIMES START HERE</p>
            <p class="enquiry-progress" aria-live="polite">01 / Your details</p>
            <h1 tabindex="-1">Let’s make it a day to remember.</h1>
            <p class="enquiry-intro">A birthday, a team day out, or something entirely your own. Share your details and we’ll help bring it to life.</p>
        </header>
        <?php gravity_form($panel_form_id, false, false, false, null, true); ?>
    </main>
    <?php wp_footer(); ?></body></html>
    <?php
    exit;
});

// The comments field was configured as numeric; accept actual questions in this panel.
foreach (array('gform_pre_render_6', 'gform_pre_validation_6', 'gform_pre_submission_filter_6') as $hook) {
    add_filter($hook, function ($form) {
        if (!playarena_is_enquiry_panel()) return $form;
        foreach ($form['fields'] as $index => $field) {
            if ((int) $field->id === 10) {
                $properties = get_object_vars($field);
                $properties['type'] = 'textarea';
                $properties['inputType'] = 'textarea';
                $form['fields'][$index] = GF_Fields::create($properties);
            }
        }
        return $form;
    });
}
