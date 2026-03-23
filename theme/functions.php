<?php

define('VITE_DEV_SERVER', 'http://localhost:5173');

function theme_enqueue_styles_scripts() {
    $assets_path = get_template_directory() . '/assets';
    $theme_version = wp_get_theme()->get('Version');

    if (!file_exists($assets_path)) {
        add_action('wp_head', function () {
            echo '<script type="module" src="' . VITE_DEV_SERVER . '/@vite/client"></script>' . "\n";
            echo '<script type="module" src="' . VITE_DEV_SERVER . '/ts/main.ts"></script>' . "\n";
        }, 2);
    } else {
        wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/main.css', array(), $theme_version);
        wp_enqueue_script('main-script', get_template_directory_uri() . '/assets/js/main.js', array(), $theme_version, true);
        add_filter('script_loader_tag', function ($tag, $handle) {
            if ($handle === 'main-script') {
                return str_replace('<script ', '<script type="module" ', $tag);
            }
            return $tag;
        }, 10, 2);
    }
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles_scripts');

function theme_output_config() {
    $config = array(
        'fullpageLicenseKey' => 'REMOVED',
    );
    echo '<script>window.themeConfig = ' . wp_json_encode($config) . ';</script>';
}

add_action('wp_head', 'theme_output_config');

function una_img_attrs( array|false $image, string $size = 'large', bool $fullpage_lazy = false ): string {
    if ( ! $image ) {
        return '';
    }

    $src    = esc_url( $image['sizes'][ $size ] );
    $srcset = esc_attr( wp_get_attachment_image_srcset( $image['ID'], $size ) );
    $sizes  = esc_attr( wp_get_attachment_image_sizes( $image['ID'], $size ) );

    if ( $fullpage_lazy ) {
        return "data-src=\"$src\" data-srcset=\"$srcset\" sizes=\"$sizes\" decoding=\"async\"";
    }

    return "src=\"$src\" srcset=\"$srcset\" sizes=\"$sizes\" loading=\"lazy\" decoding=\"async\"";
}

require_once get_template_directory() . '/inc/acf-add-options-page.php';
require_once get_template_directory() . '/inc/acf-register-blocks.php';
require_once get_template_directory() . '/inc/after-theme-setup.php';
require_once get_template_directory() . '/inc/allowed-block-types-all.php';
require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/tiny-mce-before-init.php';