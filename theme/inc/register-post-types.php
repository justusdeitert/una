<?php
// ----------------------------------->
//	Register Custom Post Types & Taxonomies
// ----------------------------------->
add_action('init', function() {
    register_post_type('Events', array(
        'labels' => [
            'name' => __('Events', 'sage'),
            'singular_name'  => __('Event', 'sage'),
            'menu_name' => __('Events', 'sage'),
            'show_in_menu' => __('Events', 'sage'),
            'add_new_item' => __('Add New Event', 'sage'),
        ],
        'public' => true,
        'capability_type' => 'post',
        'has_archive' => 'events',
        'show_in_nav_menus' => true,
        'hierarchical' => false,
        'supports' => array('title', 'revisions'/*, 'thumbnail'*/),
        'menu_icon' => 'dashicons-tag',
        'publicly queryable' => true,
    ));
});


