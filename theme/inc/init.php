<?php

// https://developer.wordpress.org/reference/hooks/init/
add_action('init', function () {
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'una'),
    ]);

    register_post_type('events', [
        'labels' => [
            'name' => __('Events', 'una'),
            'singular_name' => __('Event', 'una'),
            'menu_name' => __('Events', 'una'),
            'show_in_menu' => __('Events', 'una'),
            'add_new_item' => __('Add New Event', 'una'),
        ],
        'public' => true,
        'capability_type' => 'post',
        'has_archive' => 'events',
        'show_in_nav_menus' => true,
        'hierarchical' => false,
        'supports' => ['title', 'revisions'],
        'menu_icon' => 'dashicons-tag',
        'publicly_queryable' => true,
        'show_in_rest' => true,
    ]);

    register_post_type('performance', [
        'labels' => [
            'name' => __('Performances', 'una'),
            'singular_name' => __('Performance', 'una'),
            'menu_name' => __('Performances', 'una'),
            'add_new_item' => __('Add New Performance', 'una'),
        ],
        'public' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'show_in_nav_menus' => false,
        'hierarchical' => false,
        'supports' => ['title', 'revisions'],
        'menu_icon' => 'dashicons-format-image',
        'publicly_queryable' => true,
        'show_in_rest' => true,
        'rewrite' => [
            'slug' => 'performance',
            'with_front' => false,
        ],
    ]);
});
