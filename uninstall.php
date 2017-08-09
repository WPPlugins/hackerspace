<?php
/**
 * Uninstall the plugin
 *
 * Delete the plugin options from the database
 *
 * @since 0.3
 */

/** Uninstall the plugin */
function hackerspace_uninstall()
{
    // security checks
    if (! current_user_can('activate_plugins')) {
        return;
    }
    if (! defined('WP_UNINSTALL_PLUGIN')) {
        return;
    }
    // delete the plugin options from the database
    delete_option('hackerspace_features');
    delete_option('hackerspace_spaceapi');
}


hackerspace_uninstall();
