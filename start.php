<?php
/**
 * Terms of use for user registration
 * 
 */

// register the plugin hook handler
elgg_register_event_handler('init', 'system', 'terms_of_use_init');

/**
 * init function for the plugin
 */
function terms_of_use_init() {

    elgg_register_plugin_hook_handler('action', 'register', 'terms_of_use_check_form');
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
