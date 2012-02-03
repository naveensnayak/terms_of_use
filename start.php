<?php
/**
 * Terms of use for user registration
 * 
 */

//register the plugin hook handler  
elgg_register_event_handler('init', 'system', 'terms_of_use_init');

/**
 * init function for the plugin
 */
function terms_of_use_init() {

    elgg_register_plugin_hook_handler('view', 'forms/register', 'terms_of_use_register');

    $action_path = elgg_get_plugins_path() . "terms_of_use/actions/terms_of_use";
    elgg_register_action('register', "$action_path/register.php", 'public');
}

/**
 * function to add a checkbox to the registration page
 * modifies the view /views/default/forms/register.php
 *
 * @param $hook
 * @param $type
 * @param $returnvalue
 * @param $params
 *
 * @return bool
 */
function terms_of_use_register($hook, $type, $returnvalue, $params) {

    //add the terms of use checkbox only if it has been enabled in the plugin setting
    $plugin_obj = elgg_get_plugin_from_id('terms_of_use');
    $plugin_settings = $plugin_obj->getAllSettings();
    $terms_of_use_text = trim($plugin_settings['terms_of_use_text']);

    if($plugin_settings['require_terms_of_use'] == 'on' &&  $terms_of_use_text != '') {

        //checkbox
        $checkbox_attr = array(
            'name' => 'checkbox-require-terms-of-use',
            'default' => '',
        );
        $terms_of_use_option = "<div id='terms-of-use'>"
            . "<div id='terms-of-use-checkbox'>" . elgg_view('input/checkbox', $checkbox_attr) . "</div>"
            . "<div id='terms-of-use-text'>" . $terms_of_use_text . "</div>"
            . '</div><br>';

        $pattern = '<div class="elgg-foot">';
        $replace = $pattern . $terms_of_use_option;

        $returnvalue = str_replace($pattern, $replace, $returnvalue);
    }

    return $returnvalue;
}

