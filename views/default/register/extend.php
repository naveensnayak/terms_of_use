<?php
/**
 * view to add terms of use form field to the user registration form
 */

//add the terms of use checkbox only if it has been enabled in the plugin setting
$plugin_entity = elgg_get_plugin_from_id('terms_of_use');
$plugin_settings = $plugin_entity->getAllSettings();
$terms_of_use_text = trim($plugin_settings['terms_of_use_text']);

$output = '';

if($plugin_settings['require_terms_of_use'] == 'on' &&  $terms_of_use_text != '') {

    //checkbox
    $checkbox_attr = array(
        'name' => 'checkbox-require-terms-of-use',
        'default' => '',
    );

    $output = "<div id='terms-of-use'>"
        . "<div id='terms-of-use-checkbox'>" . elgg_view('input/checkbox', $checkbox_attr) . "</div>"
        . "<div id='terms-of-use-text'>" . $terms_of_use_text . "</div>"
        . '</div><br>';
}

echo $output;