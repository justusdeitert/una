<?php

function una_vite_dev_server() {
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    // Strip any existing port, keep only the hostname/IP
    $host = preg_replace('/:\d+$/', '', $host);

    return 'http://' . $host . ':5173';
}

function theme_enqueue_styles_scripts() {
    $assets_path = get_template_directory() . '/assets';

    if (!file_exists($assets_path)) {
        add_action('wp_head', function () {
            $dev_server = una_vite_dev_server();
            echo '<script type="module" src="' . esc_url($dev_server) . '/@vite/client"></script>' . "\n";
            echo '<script type="module" src="' . esc_url($dev_server) . '/ts/main.ts"></script>' . "\n";
        }, 2);
    } else {
        $manifest_path = $assets_path . '/.vite/manifest.json';
        $manifest = json_decode(file_get_contents($manifest_path), true);
        $entry = $manifest['ts/main.ts'];

        $assets_uri = get_template_directory_uri() . '/assets/';
        wp_enqueue_style('main-style', $assets_uri . $entry['css'][0], [], null);
        wp_enqueue_script_module('main-script', $assets_uri . $entry['file']);
    }
}

add_action('wp_enqueue_scripts', 'theme_enqueue_styles_scripts');

function theme_output_config() {
    $config = [
        'fullpageLicenseKey' => getenv('FULLPAGE_LICENSE_KEY') ?: '',
    ];
    echo '<script>window.themeConfig = ' . wp_json_encode($config) . ';</script>';
}

add_action('wp_head', 'theme_output_config');

function una_img_attrs(
    array|false $image,
    string $size = 'large',
    bool $fullpage_lazy = false,
    string $layout = '',
): string {
    if (! $image) {
        return '';
    }

    $src = esc_url($image['sizes'][ $size ] ?? $image['url']);
    $srcset = wp_get_attachment_image_srcset($image['ID'], $size);
    $sizes = una_img_sizes($layout);

    $attrs = $fullpage_lazy ? "data-src=\"$src\"" : "src=\"$src\"";

    if ($srcset) {
        $srcset = esc_attr($srcset);
        $attrs .= $fullpage_lazy ? " data-srcset=\"$srcset\"" : " srcset=\"$srcset\"";
    }
    $attrs .= " sizes=\"$sizes\"";
    $attrs .= ' decoding="async"';

    if (! $fullpage_lazy) {
        $attrs .= ' loading="lazy"';
    }

    return $attrs;
}

function una_img_sizes(string $layout): string {
    // 860px = fullpage.js responsive breakpoint
    return match ($layout) {
        'column' => '(max-width: 860px) 60vw, 230px',
        'column-small' => '(max-width: 860px) 30vw, 115px',
        'hero' => '(max-width: 860px) 90vw, 80vw',
        default => '100vw',
    };
}

require_once get_template_directory() . '/inc/acf-add-options-page.php';
require_once get_template_directory() . '/inc/acf-register-blocks.php';
require_once get_template_directory() . '/inc/after-theme-setup.php';
require_once get_template_directory() . '/inc/allowed-block-types-all.php';
require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/tiny-mce-before-init.php';
