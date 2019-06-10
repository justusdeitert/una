<?php
// ----------------------------------->
//	Register Custom Post Types & Taxonomies
// ----------------------------------->
add_action('init', function() {

    // Add new taxonomy, make it hierarchical (like categories)
    // register_taxonomy('categories', 'doors', array(
    //     'labels' => array(
    //         'name' => __( 'Categories', 'sage'),
    //         'menu_name' => __( 'Categories', 'sage'),
    //         'singular_name' => __( 'Category', 'sage'),
    //         'search_items' => __( 'Search Categories', 'sage'),
    //         'all_items' => __( 'All Categories', 'sage'),
    //         // 'parent_item' => __( 'Parent Department', 'sage'),
    //         // 'parent_item_colon' => __( 'Parent Fitness Type:', 'sage'),
    //         'edit_item' => __( 'Edit Categories', 'sage'),
    //         'update_item' => __( 'Update Categories', 'sage'),
    //         'add_new_item' => __( 'Add New Category', 'sage'),
    //         'new_item_name' => __( 'New Category Name', 'sage'),
    //     ),
    //     'hierarchical' => true,
    //     'public' => true,
    //     'show_in_nav_menus' => true,
    //     'show_ui' => true,
    //     'show_admin_column' => true,
    //     'query_var' => true,
    //     'rewrite' => array('slug' => 'innentueren', 'with_front' => false),
    // ));

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
        // 'taxonomies' => array('categories'),
        // 'rewrite' => array( 'slug' => 'innentueren/%categories%', 'with_front' => false)
        // 'rewrite' => array('slug' => 'innentueren')
        // 'show_ui'       => true,
        // 'show_in_menu'  => true,
    ));

    // register_post_type('Fittings', [
    //     'labels' => [
    //         'name' => __('Fittings', 'sage'),
    //         'singular_name'  => __('Fitting', 'sage'),
    //         'menu_name' => __('Fittings', 'sage'),
    //         'show_in_menu' => __('Fittings', 'sage'),
    //         'add_new_item' => __('Add New Fitting', 'sage'),
    //     ],
    //     'public' => true,
    //     'capability_type' => 'post',
    //     'has_archive' => false,
    //     'show_in_nav_menus' => true,
    //     'hierarchical' => false,
    //     'supports' => array('title', 'revisions', 'thumbnail'),
    //     'menu_icon' => 'dashicons-admin-post',
    //     'publicly queryable' => true,
    //     'rewrite' => array('slug' => 'fittings')
    //     // 'show_ui'       => true,
    //     // 'show_in_menu'  => true,
    //     // 'taxonomies'         => array('department')
    // ]);
});


