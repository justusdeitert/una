<?php

function theme_enqueue_styles_scripts() {
    $assets_path = get_template_directory() . '/assets';
    $theme_version = wp_get_theme()->get('Version');

    wp_enqueue_script('jquery');

    if (!file_exists($assets_path)) {
        wp_enqueue_script_module('vite-js', 'http://localhost:5173/@vite/client');
        wp_enqueue_script_module('theme-main-script', 'http://localhost:5173/js/main.js');
    } else {
        wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version);
        wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array(), $theme_version, true);
    }

    wp_localize_script('jquery', 'themeConfig', array(
        'fullpageLicenseKey' => 'REMOVED',
    ));
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles_scripts');

require_once get_template_directory() . '/inc/acf-add-options-page.php';
require_once get_template_directory() . '/inc/acf-register-blocks.php';
require_once get_template_directory() . '/inc/after-theme-setup.php';
require_once get_template_directory() . '/inc/allowed-block-types-all.php';
require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/template-functions.php';
require_once get_template_directory() . '/inc/tiny-mce-before-init.php';