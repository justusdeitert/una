<?php

// https://www.advancedcustomfields.com/resources/acf_add_options_page/
if (function_exists('acf_add_options_page')) {
    acf_add_options_page([
        'page_title' => __('Info', 'una'),
        'menu_title' => __('Info', 'una'),
        'menu_slug' => 'info',
        'capability' => 'edit_posts',
        'position' => 50.2,
        'parent_slug' => '',
        'icon_url' => 'dashicons-info',
        'redirect' => false,
    ]);
}
