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

    elgg_register_plugin_hook_handler('action', 'register', 'terms_of_use_check_form');

    //$action_path = elgg_get_plugins_path() . "terms_of_use/actions/terms_of_use";
    //elgg_register_action('register', "$action_path/register.php", 'public');
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


/**
 * @param $hook
 * @param $type
 * @param $returnvalue
 * @param $params
 *
 * @return bool
 *
 * function called when the below plugin trigger is initiated
 * @see /engine/lib/actions.php
 * @see elgg_trigger_plugin_hook('action', $action, null, $event_result);  [
 *
 * this hook is triggered for the action = "register"
 * this hooks is called before the default "register" action handler at /actions/register.php
 * checks if the terms of use checkbox is checked - if not register an error
 *
 * a terms of use checkbox is added to the "/register" page
 * @see Plugin Settings for Terms of Use plugin
 * @see /mod/terms_of_use/views/default/plugins/terms_of_use/settings.php
 */
function terms_of_use_check_form($hook, $type, $returnvalue, $params) {

    // retain entered form values and re-populate form fields if validation error
    elgg_make_sticky_form('register');

    /*-- check if the 'Require user to accept terms' Plugin setting is enabled --*/

    //fetch the plugin settings
    $plugin_obj = elgg_get_plugin_from_id('terms_of_use');
    $plugin_settings = $plugin_obj->getAllSettings();

    if($plugin_settings['require_terms_of_use'] == 'on') { //if the setting is enabled
        // Get POST variables
        $require_terms_of_use = get_input('checkbox-require-terms-of-use');

        if (trim($require_terms_of_use) != 'on') {
            register_error(elgg_echo('terms_of_use:registration_exception:require_checkbox'));
            forward(REFERER);
        }
    }

    return true;
}
