<?php
// Adjust Wp Admin Menus, etc..
// -------------------->

// Custom Plugin Menu Name(s)
// Rename admin menus added by plugins
add_action('admin_init', function() {
    global $menu;

    // Define your changes here
    $updates = array(
        'MailPoet' => array(
            'name' => __('Newsletter', 'sage'),
            'icon' => 'dashicons-email'
        ),
        'Contact' => array(
            'name' => __('Contact Forms', 'sage'),
            'icon' => 'dashicons-text',
        ),
        'Contact Forms' => array(
            'name' => __('Messages', 'sage'),
            'icon' => 'dashicons-email',
        )
    );

    foreach ( $menu as $k => $props ) {

        // Check for new values
        $new_values = ( isset( $updates[ $props[0] ] ) ) ? $updates[ $props[0] ] : false;
        if ( ! $new_values ) continue;

        // Change menu name
        $menu[$k][0] = $new_values['name'];

        // Optionally change menu icon
        if ( isset( $new_values['icon'] ) )
            $menu[$k][6] = $new_values['icon'];
    }
});


// Disable Default Dashboard Widgets
// @ https://digwp.com/2014/02/disable-default-dashboard-widgets/
// ------------------------->
add_action('wp_dashboard_setup', 'disable_default_dashboard_widgets', 999);
function disable_default_dashboard_widgets() {
    global $wp_meta_boxes;
    // wp..
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
    unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
    // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
    unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
    // unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
}

// Removing Welcome Panel in Admin Dashboard
// ------------------------->
remove_action('welcome_panel', 'wp_welcome_panel');

// ------------------------------------------------------------------------->

// https://developer.wordpress.org/reference/functions/add_menu_page/
// ---------------->
add_action( 'admin_menu', function() {
    global $menu;

    $menu_slug = "redirect_to_customizer"; // just a placeholder for when we call add_menu_page
    $menu_pos = 49; // whatever position you want your menu to appear

    // create the top level menu, using $menu_slug as a placeholder for the link
    add_menu_page(
        'redirect_to_customizer',
        'Customizer',
        'read',
        $menu_slug,
        '',
        'dashicons-admin-customizer',
        $menu_pos
    );

    // replace the slug with your external url
    $menu[$menu_pos][2] = get_admin_url() . 'customize.php';
}
);

// Add to WP Admin head https://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
// Add inline CSS in the admin head with the style tag
add_action( 'admin_head', function() {
    echo '<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">';
    echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">';
});
