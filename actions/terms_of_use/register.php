<?php

/**
 * this file overrides the default /actions/register.php
 * a terms of use checkbox is added to the "/register" page
 * @see Plugin Settings for Terms of Use plugin
 * @see /mod/terms_of_use/views/default/plugins/terms_of_use/settings.php
 *
 */

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

/*-- call the default /actions/register.php file to take care of the rest of the register process --*/
$default_register_action_path = elgg_get_root_path() . 'actions/register.php';
require_once $default_register_action_path;