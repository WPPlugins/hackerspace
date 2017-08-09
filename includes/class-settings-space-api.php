<?php

/**
 * Render the setting form for the Space Api
 *
 * @since 0.3
 */
class Settings_Space_Api
{
    /** Constructor for the Settings_Features class */
    public function __construct()
    {
        $this->options = get_option('hackerspace_spaceapi');
    }

    /** Whitelist the Space Api settings */
    public function register_settings()
    {
        register_setting('hackerspace_spaceapi', 'hackerspace_spaceapi', array($this, 'settings_validate'));

        add_settings_section('about_section', null, null, 'hackerspace_spaceapi');
        add_settings_section('main_section', __('Main informations', 'wp-hackerspace'), array($this, 'main_section'), 'hackerspace_spaceapi');
        add_settings_section('location_section', __('Location', 'wp-hackerspace'), array($this, 'location_section'), 'hackerspace_spaceapi');
        add_settings_section('contact_section', __('Contact', 'wp-hackerspace'), array($this, 'contact_section'), 'hackerspace_spaceapi');
        add_settings_section('other_section', __('Other', 'wp-hackerspace'), array($this, 'other_section'), 'hackerspace_spaceapi');

        add_settings_field('api', __('Space Api version', 'wp-hackerspace'), array($this, 'api_field'), 'hackerspace_spaceapi', 'about_section');
        add_settings_field('space', __('Space name', 'wp-hackerspace'), array($this, 'space_field'), 'hackerspace_spaceapi', 'main_section');
        add_settings_field('url', __('Space url', 'wp-hackerspace'), array($this, 'url_field'), 'hackerspace_spaceapi', 'main_section');
        add_settings_field('logo', __('Logo url', 'wp-hackerspace'), array($this, 'logo_field'), 'hackerspace_spaceapi', 'main_section');
        add_settings_field('address', __('Address', 'wp-hackerspace'), array($this, 'address_field'), 'hackerspace_spaceapi', 'location_section');
        add_settings_field('lat', __('Latitude', 'wp-hackerspace'), array($this, 'lat_field'), 'hackerspace_spaceapi', 'location_section');
        add_settings_field('lon', __('Longitude', 'wp-hackerspace'), array($this, 'lon_field'), 'hackerspace_spaceapi', 'location_section');
        add_settings_field('email', __('Email', 'wp-hackerspace'), array($this, 'email_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('phone', __('Phone', 'wp-hackerspace'), array($this, 'phone_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('sip', __('SIP', 'wp-hackerspace'), array($this, 'sip_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('irc', __('IRC', 'wp-hackerspace'), array($this, 'irc_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('twitter', __('Twitter', 'wp-hackerspace'), array($this, 'twitter_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('facebook', __('Facebook', 'wp-hackerspace'), array($this, 'facebook_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('identica', __('Identica', 'wp-hackerspace'), array($this, 'identica_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('foursquare', __('Foursquare', 'wp-hackerspace'), array($this, 'foursquare_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('ml', __('Mailling list', 'wp-hackerspace'), array($this, 'ml_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('jabber', __('Jabber', 'wp-hackerspace'), array($this, 'jabber_field'), 'hackerspace_spaceapi', 'contact_section');
        add_settings_field('issue_report_channel', __('Issue report channel', 'wp-hackerspace'), array($this, 'issue_report_channel_field'), 'hackerspace_spaceapi', 'other_section');
        add_settings_field('cache_schedule', __('Cache schedule', 'wp-hackerspace'), array($this, 'cache_schedule_field'), 'hackerspace_spaceapi', 'other_section');
    }

    /**
     * Validate the Space Api settings
     *
     * @param array $input Inputed values from the settings form
     *
     * @return stdClass object
     */
    public function settings_validate($input)
    {
        // convert inputed array options to a stdClass object
        $output = json_decode(json_encode($input));
        // sanitization
        $output->location->lat = (float)$output->location->lat; // html form have saved this as text instead off numbers
        $output->location->lon = (float)$output->location->lon;

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
        $help_tab->id = 'wp-hackerspace-spaceapi';
        $help_tab->title = __('Space Api', 'wp-hackerspace');
        $help_tab->content = '<p>Space Api help text</p>';

        return $help_tab;
    }

    /** Render the main section description text */
    public function main_section()
    {
        _e('Main informations about your space.', 'wp-hackerspace');
    }

    /** Render the location section description text */
    public function location_section()
    {
        _e('Position data such as a postal address or geographic coordinates.', 'wp-hackerspace');
    }

    /** Render the contact section description text */
    public function contact_section()
    {
        _e('Contact information about your space. You must define at least one.', 'wp-hackerspace');
    }

    /** Render the other section description text */
    public function other_section()
    {
        _e('Other various settings.', 'wp-hackerspace');
    }

    /** Render the Space Api version field (read only) */
    public function api_field()
    {
        echo '<input type="text" name="hackerspace_spaceapi[api]" value="'.esc_attr($this->options->api).'" class="regular-text" readonly style="width: 5em;" />';
    }

    /** Render the Space name field */
    public function space_field()
    {
        echo '<input type="text" name="hackerspace_spaceapi[space]" value="'.esc_attr($this->options->space).'" class="regular-text" required="required" />';
        echo '<p class="description">'.__('The name of your space.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space url field */
    public function url_field()
    {
        echo '<input type="url" name="hackerspace_spaceapi[url]" value="'.esc_attr($this->options->url).'" class="regular-text code" required="required" />';
        echo '<p class="description">'.__('URL to your space website.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space logo url field */
    public function logo_field()
    {
        echo '<input type="url" name="hackerspace_spaceapi[logo]" value="'.esc_attr($this->options->logo).'" class="regular-text code" required="required" />';
        echo '<p class="description">'.__('URL to your space logo.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space street address field */
    public function address_field()
    {
        echo '<input type="text" name="hackerspace_spaceapi[location][address]" value="'.esc_attr($this->options->location->address).'" class="regular-text" />';
        echo '<p class="description">'.__('The postal address of your space. Example: Netzladen e.V., Breite Straße 74, 53111 Bonn, Germany', 'wp-hackerspace').'</p>';
    }

    /** Render the Space latitude field */
    public function lat_field()
    {
        echo '<input type="number" name="hackerspace_spaceapi[location][lat]" value="'.esc_attr($this->options->location->lat).'" class="small-text" required="required" />';
        echo '<p class="description">'.__('Latitude of your space location, in degree with decimal places. Use positive values for locations north of the equator, negative values for locations south of equator.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space longitude field */
    public function lon_field()
    {
        echo '<input type="number" name="hackerspace_spaceapi[location][lon]" value="'.esc_attr($this->options->location->lon).'" min="-180.000000" max="180.000000" class="small-text" required="required" />';
        echo '<p class="description">'.__('Longitude of your space location, in degree with decimal places. Use positive values for locations west of Greenwich, and negative values for locations east of Greenwich.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space email field */
    public function email_field()
    {
        echo '<input type="email" name="hackerspace_spaceapi[contact][email]" value="'.esc_attr($this->options->contact->email).'" class="regular-text ltr" required="required" />';
        echo '<p class="description">'.__('E-mail address for contacting your space.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space phone number field */
    public function phone_field()
    {
        echo '<input type="tel" name="hackerspace_spaceapi[contact][phone]" value="'.esc_attr($this->options->contact->phone).'" class="regular-text" />';
        echo '<p class="description">'.__('Phone number, including country code with a leading plus sign. Example: +1 800 555 4567', 'wp-hackerspace').'</p>';
    }

    /** Render the Space SIP field */
    public function sip_field()
    {
        echo '<input type="url" name="hackerspace_spaceapi[contact][sip]" value="'.esc_attr($this->options->contact->sip).'" class="regular-text code" />';
        echo '<p class="description">'.__('URI for Voice-over-IP via SIP. Example: sip:yourspace@sip.example.org', 'wp-hackerspace').'</p>';
    }

    /** Render the Space IRC chanel field */
    public function irc_field()
    {
        echo '<input type="url" name="hackerspace_spaceapi[contact][irc]" value="'.esc_attr($this->options->contact->irc).'" class="regular-text code" />';
        echo '<p class="description">'.__('URL of the IRC channel, in the form irc://example.org/#channelname', 'wp-hackerspace').'</p>';
    }

    /** Render the Space Twitter field */
    public function twitter_field()
    {
        echo '<input type="text" name="hackerspace_spaceapi[contact][twitter]" value="'.esc_attr($this->options->contact->twitter).'" class="regular-text" />';
        echo '<p class="description">'.__('Twitter handle, with leading @', 'wp-hackerspace').'</p>';
    }

    /** Render the Space Facebook field */
    public function facebook_field()
    {
        echo '<input type="text" name="hackerspace_spaceapi[contact][facebook]" value="'.esc_attr($this->options->contact->facebook).'" class="regular-text" />';
        echo '<p class="description">'.__('Facebook account name.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space Identica/StatusNet field */
    public function identica_field()
    {
        echo '<input type="email" name="hackerspace_spaceapi[contact][identica]" value="'.esc_attr($this->options->contact->identica).'" class="regular-text ltr" />';
        echo '<p class="description">'.__('Identi.ca or StatusNet account, in the form yourspace@example.org', 'wp-hackerspace').'</p>';
    }

    /** Render the Space Foursquare field */
    public function foursquare_field()
    {
        echo '<input type="text" name="hackerspace_spaceapi[contact][foursquare]" value="'.esc_attr($this->options->contact->foursquare).'" class="regular-text" />';
        echo '<p class="description">'.__('Foursquare ID, in the form 4d8a9114d85f3704eab301dc', 'wp-hackerspace').'</p>';
    }

    /** Render the Space mailling list field */
    public function ml_field()
    {
        echo '<input type="email" name="hackerspace_spaceapi[contact][ml]" value="'.esc_attr($this->options->contact->ml).'" class="regular-text ltr" />';
        echo '<p class="description">'.__('The e-mail address of your mailing list.', 'wp-hackerspace').'</p>';
    }

    /** Render the Space Jabber field */
    public function jabber_field()
    {
        echo '<input type="email" name="hackerspace_spaceapi[contact][jabber]" value="'.esc_attr($this->options->contact->jabber).'" class="regular-text ltr" />';
        echo '<p class="description">'.__('A public Jabber/XMPP multi-user chatroom in the form chatroom@conference.example.net', 'wp-hackerspace').'</p>';
    }

    /** Render the issue report channel field (read only)*/
    public function issue_report_channel_field()
    {
        echo '<input type="text" name="hackerspace_spaceapi[issue_report_channels][0]" value="'.esc_attr($this->options->issue_report_channels[0]).'" class="regular-text" readonly />';
        echo '<p class="description">'.__('Communication channels where you want to get automated issue reports about your SpaceAPI endpoint from the validator.', 'wp-hackerspace').'</p>';
    }

    /** Render the cache schedule field (read only) */
    public function cache_schedule_field() //read only field
    {
        echo '<input type="text" name="hackerspace_spaceapi[cache][schedule]" value="'.esc_attr($this->options->cache->schedule).'" class="regular-text" readonly />';
        echo '<p class="description">'.__('Cache update cycle of your SpaceAPI endpoint.', 'wp-hackerspace').'</p>';
    }

}
