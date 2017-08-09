<?php
/**
 * Template for the admin settings page
 */

// get the active settings tab, default to 'features'
if (isset($_GET['tab'])) {
    $active_tab = $_GET['tab'];
} else {
    $active_tab = 'features';
}

echo '<div class="wrap">';
echo '<h2>'.__('Hackerspace settings', 'wp-hackerspace').'</h2>';
echo '<h2 class="nav-tab-wrapper">';

// Feature tab
if ($active_tab == 'features') {
    echo '<a href="?page=hackerspace_options&tab=features" class="nav-tab nav-tab-active">'.__('Features', 'wp-hackerspace').'</a>';
} else {
    echo '<a href="?page=hackerspace_options&tab=features" class="nav-tab">'.__('Features', 'wp-hackerspace').'</a>';
}

// Space Api tab (displayed only if enabled)
$spaceapi_enabled = get_option('hackerspace_features')->spaceapi_enabled;
if ($spaceapi_enabled == true) {
    if ($active_tab == 'spaceapi') {
        echo '<a href="?page=hackerspace_options&tab=spaceapi" class="nav-tab nav-tab-active">'.__('Space Api', 'wp-hackerspace').'</a>';
    } else {
        echo '<a href="?page=hackerspace_options&tab=spaceapi" class="nav-tab">'.__('Space Api', 'wp-hackerspace').'</a>';
    }
}

echo '</h2>';
echo '<form action="options.php" method="post">';

// display settings fields
if ($active_tab == 'features') {
    settings_fields('hackerspace_features');
    do_settings_sections('hackerspace_features');
} elseif ($active_tab == 'spaceapi') {
    settings_fields('hackerspace_spaceapi');
    do_settings_sections('hackerspace_spaceapi');
}
submit_button();

echo'</form></div>';
