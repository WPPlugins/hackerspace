<?php

/**
 * Activate, update and deactivate the plugin
 *
 * @since 0.3
 */
class Plugin_Setup
{

    /** Constructor for the Hackerspace class */
    public function __construct()
    {
        // instantiate the required external classes
        $this->Post_Type_Project = new Post_Type_Project();
    }

    /** Activate the plugin */
    public function activate()
    {
        // check if the user have the right to do this
        if (! current_user_can('activate_plugins')) {
            return;
        }
        // set default values for options
        $this->set_default_options();
        // enable the 'hacker' role
        $this->add_hacker_role();
        // set capabilities
        $this->set_capabilities();
        // flush rewrite rules for custom post types permalinks
        flush_rewrite_rules();
    }

    /** Deactivate the plugin */
    public function deactivate()
    {
        // check if the user have the right to do this
        if (! current_user_can('activate_plugins')) {
            return;
        }
        // remove the 'hacker' role
        $this->remove_hacker_role();
        // remove capabilities
        $this->remove_capabilities();
        // flush rewrite rules for custom post types permalinks
        flush_rewrite_rules();
    }

    /**
     * Get the plugin version number from 'hackerspace_version' options
     *
     * @return text $plugin_version version number from the options
     */
    private function plugin_version()
    {
        // if no version exist, we assume then it's first install an set the current version
        if (false == get_option('hackerspace_version')) {
            add_option('hackerspace_version', HACKERSPACE_PLUGIN_VERSION);
        }
        // get the version number
        $plugin_version = get_option('hackerspace_version');

        return $plugin_version;
    }

    /** Update the plugin */
    public function update()
    {
        $plugin_version = $this->plugin_version();
        switch($plugin_version) {
            case '0.3':
                //placeholder for futures updates
                //update_option('hackerspace_version', HACKERSPACE_PLUGIN_VERSION);
        }
    }

    /** Set default values for options on first install */
    private function set_default_options()
    {
        $Settings_Features = new Settings_Features();
        $Space_Api = new Space_Api();
        // set default features options
        if (false == get_option('hackerspace_features')) {
            add_option('hackerspace_features', $Settings_Features->set_default_features());
        }
        // set default Space Api options
        if (false == get_option('hackerspace_spaceapi')) {
            add_option('hackerspace_spaceapi', $Space_Api->set_default_spaceapi());
        }
    }

    /**
     * Add and 'hacker' role with 'contributor' role capabilities
     *
     * This role can
     * - create blog post but not publish them
     * - create, edit, publish and delete his own custom post types (see in class-post-type files)
     * - read the privates custom post types
     * This role cannot
     * - manage the settings of the plugin
     * - edit and delete the custom post type from others
     */
    private function add_hacker_role()
    {
        $contributor = get_role('contributor');
        if (!get_role('hacker')) {
            add_role(
                'hacker',
                __('Hacker', 'wp-hackerspace'),
                $contributor->capabilities
            );
        }
    }

    /** remove the 'hacker' role */
    private function remove_hacker_role()
    {
        remove_role('hacker');
    }

    /** Set capabilities on custom post type */
    private function set_capabilities()
    {
        // limited cababilities for 'hacker' role
        // full capabilities for 'adminstrator' and 'editor' roles
        $this->Post_Type_Project->set_capabilities('administrator');
        $this->Post_Type_Project->set_capabilities('editor');
        $this->Post_Type_Project->set_capabilities('hacker');
    }

    /** Remove capabilities on custom post type */
    private function remove_capabilities()
    {
        // remove capabilities for 'adminstrator' and 'editor' roles
        $this->Post_Type_Project->remove_capabilities('administrator');
        $this->Post_Type_Project->remove_capabilities('editor');
    }

}

