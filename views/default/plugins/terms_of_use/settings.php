<?php
/**
 * Terms of use plugin settings.
 *
 */


$require_terms_of_use = '';
$terms_of_use_text = '';

if (isset($vars['entity'])) {
    $terms_of_use_text = $vars['entity']->terms_of_use_text;
    $require_terms_of_use = $vars['entity']->require_terms_of_use;
}

$form_body = '<div>';
$form_body .= '<br>';

//checkbox
$options = array(
    'name' => 'params[require_terms_of_use]',
    'default' => '',
);
if($require_terms_of_use != '') $options['checked'] = '';

$form_body .= "<div>"
    . elgg_view("input/checkbox", $options)
    . '<b>'. elgg_echo('terms_of_use:require_terms_of_use') .'</b>'
    . "</div>";

$form_body .= "<br><br>";

//textarea
$form_body .= '<b>' . elgg_echo('terms_of_use:terms_of_use_text') . "</b><br />";
$form_body .= elgg_view('input/longtext', array(
    'name' => 'params[terms_of_use_text]',
    'value' => $terms_of_use_text
));

$form_body .= "</div>";

echo $form_body;

