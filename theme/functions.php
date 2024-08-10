<?php

function theme_enqueue_styles_scripts() {
    $assets_path = get_template_directory() . '/assets';
    $theme_version = wp_get_theme()->get('Version');

    if (!file_exists($assets_path)) {
        wp_enqueue_script_module('vite-js', 'http://localhost:5173/@vite/client', [], null, true);
        wp_enqueue_script_module('theme-main-script', 'http://localhost:5173/js/main.js', [], null, true);
    } else {
        wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version);
        wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array(), $theme_version, true);
    }
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles_scripts');

require_once get_template_directory() . '/inc/acf-options-page.php';
require_once get_template_directory() . '/inc/acf-register-blocks.php';
require_once get_template_directory() . '/inc/add-theme-support.php';
require_once get_template_directory() . '/inc/adjust-wp-wysiwyg.php';
require_once get_template_directory() . '/inc/editor-color-palette.php';
require_once get_template_directory() . '/inc/generic-template-functions.php';
require_once get_template_directory() . '/inc/register-post-types.php';
require_once get_template_directory() . '/inc/wp-block-filters.php';