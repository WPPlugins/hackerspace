<?php

/**
 * Render the setting form for the plugin features
 *
 * @since 0.3
 */
class Settings_Features
{
    /** Constructor for the Settings_Features class */
    public function __construct()
    {
        // get features option and the plugin version
        $this->options = get_option('hackerspace_features');
        $this->plugin_version = get_option('hackerspace_version');
    }

    /**
     * Create the default features options
     *
     * @return stdClass object
     */
    public function set_default_features()
    {
        $features = new stdClass;
        $features->projects_enabled = true;
        $features->spaceapi_enabled = true;

        return $features;
    }

    /** Whitelist the features settings */
    public function register_settings()
    {
        register_setting('hackerspace_features', 'hackerspace_features', array($this, 'settings_validate'));

        add_settings_section('features_section', null, array($this, 'features_section'), 'hackerspace_features');

        add_settings_field('plugin_version', __('Hackerspace plugin version', 'wp-hackerspace'), array($this, 'version_field'), 'hackerspace_features', 'features_section');
        add_settings_field('projects_enabled', __('Projects', 'wp-hackerspace'), array($this, 'projects_field'), 'hackerspace_features', 'features_section');
        add_settings_field('spaceapi_enabled', __('Space Api', 'wp-hackerspace'), array($this, 'spaceapi_field'), 'hackerspace_features', 'features_section');

    }

    /**
     * Validate the plugin features settings
     *
     * @param array $input Inputed values from the settings form
     *
     * @return stdClass object
     */
    public function settings_validate($input)
    {
        // convert inputed array options to a stdClass object
        $output = json_decode(json_encode($input));
        // sanitization (checkboxes drop false values or set them to '1' instead of true)
        if (! isset($output->projects_enabled)) {
            $output->projects_enabled = false;
        } else if ($output->projects_enabled == '1') {
            $output->projects_enabled = true;
        }
        if (! isset($output->spaceapi_enabled)) {
            $output->spaceapi_enabled = false;
        } else if ($output->spaceapi_enabled == '1') {
            $output->spaceapi_enabled = true;
        }

        return $output;
    }

    /**
     * Generate an object to display on top help tab
     *
     * @return stdClass object
     */
    public function help_tab()
    {
        $help_tab = new stdClass;
        $help_tab->id = 'wp-hackerspace-features';
        $help_tab->title = __('Features', 'wp-hackerspace');
        $help_tab->content = '<p>Features help text</p>';

        return $help_tab;
    }

    /** Render the features section description text */
    public function features_section()
    {
    }

    /** Render the plugin version field (read only) */
    public function version_field()
    {
        echo '<input type="text" name="plugin_version" value="'.esc_attr($this->plugin_version).'" class="regular-text" readonly style="width: 5em;" />';
    }

    /** Render the Project custom post type feature field */
    public function projects_field()
    {
        echo '<input type="checkbox" name="hackerspace_features[projects_enabled]" value="1"'.checked(1, $this->options->projects_enabled, false).'" />';
        echo '<span class="description">'.__('Enable the custom post type for projects.', 'wp-hackerspace');
    }

    /** Render the Space Api feature field */
    public function spaceapi_field()
    {
        echo '<input type="checkbox" name="hackerspace_features[spaceapi_enabled]" value="1"'.checked(1, $this->options->spaceapi_enabled, false).'" />';
        echo '<span class="description">'.__('Enable the Space Api Json endpoint.', 'wp-hackerspace');
    }


}
