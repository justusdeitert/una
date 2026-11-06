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
        // Env var on Docker hosts, wp-config constant on shared hosting (one.com)
        'fullpageLicenseKey' => getenv('FULLPAGE_LICENSE_KEY') ?: (defined('FULLPAGE_LICENSE_KEY') ? FULLPAGE_LICENSE_KEY : ''),
    ];
    echo '<script>window.themeConfig = ' . wp_json_encode($config) . ';</script>';
}

add_action('wp_head', 'theme_output_config');

function theme_preload_primary_font() {
    $assets_path = get_template_directory() . '/assets';
    if (!file_exists($assets_path)) {
        return;
    }

    $manifest_path = $assets_path . '/.vite/manifest.json';
    if (!file_exists($manifest_path)) {
        return;
    }

    $manifest = json_decode(file_get_contents($manifest_path), true);
    if (!is_array($manifest)) {
        return;
    }

    $assets_uri = get_template_directory_uri() . '/assets/';
    $fonts = [];
    foreach ($manifest as $entry) {
        if (!isset($entry['assets']) || !is_array($entry['assets'])) {
            continue;
        }
        foreach ($entry['assets'] as $asset) {
            if (str_contains($asset, 'geomanist_regular') && str_ends_with($asset, '.woff2')) {
                $fonts[$asset] = true;
            }
        }
    }

    foreach (array_keys($fonts) as $font_path) {
        $url = esc_url($assets_uri . $font_path);
        echo '<link rel="preload" as="font" type="font/woff2" href="' . $url . '" crossorigin>' . "\n";
    }
}

add_action('wp_head', 'theme_preload_primary_font', 1);

function una_img_attrs(
    array|false $image,
    string $size = 'large',
    string $layout = '',
): string {
    if (! $image) {
        return '';
    }

    $src = esc_url($image['sizes'][ $size ] ?? $image['url']);
    $srcset = wp_get_attachment_image_srcset($image['ID'], $size);
    $sizes = una_img_sizes($layout);

    // Intrinsic dimensions: prefer the selected size, fall back to the
    // original. Required so the browser can reserve aspect-ratio space
    // before the image decodes, preventing the "jumping" / "pop-in"
    // layout shift.
    $width = (int) ($image['sizes'][ $size . '-width' ] ?? $image['width'] ?? 0);
    $height = (int) ($image['sizes'][ $size . '-height' ] ?? $image['height'] ?? 0);

    $attrs = "src=\"$src\"";

    if ($srcset) {
        $srcset = esc_attr($srcset);
        $attrs .= " srcset=\"$srcset\"";
    }
    $attrs .= " sizes=\"$sizes\"";
    if ($width > 0 && $height > 0) {
        $attrs .= " width=\"$width\" height=\"$height\"";
    }
    $attrs .= ' decoding="async" loading="lazy"';

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
require_once get_template_directory() . '/inc/disable-comments.php';
require_once get_template_directory() . '/inc/init.php';
require_once get_template_directory() . '/inc/tiny-mce-before-init.php';

/**
 * Wrap lines that consist only of bold text in a block span, so their
 * line-height can be tightened without affecting the regular lines of the
 * same paragraph (inline line-height cannot go below the paragraph's own).
 */
function una_bold_lines(string $html): string
{
    // Line breaks often sit inside inline tags (`<span>2025<br /></span>`,
    // `<strong>Title<br /></strong>`): move trailing ones out, then close and
    // reopen the strong around any break left inside it and drop empty ones
    do {
        $html = preg_replace('#<br\s*/?>\s*(</(?:span|strong|b|em|i|a)>)#i', "$1<br />\n", $html, -1, $count);
    } while ($count > 0);

    $html = preg_replace_callback('#<strong>(.*?)</strong>#s', function ($s) {
        $parts = preg_split('#<br\s*/?>\s*#i', $s[1]);
        $parts = array_map(fn ($part) => trim($part) === '' ? '' : '<strong>' . $part . '</strong>', $parts);

        return implode("<br />\n", $parts);
    }, $html);

    return preg_replace_callback('#<p([^>]*)>(.*?)</p>#s', function ($p) {
        $lines = preg_split('#<br\s*/?>\s*#i', $p[2]);
        $out = '';
        $last = count($lines) - 1;
        foreach ($lines as $i => $line) {
            $rest = preg_replace(['#<strong>.*?</strong>#s', '#</?a\b[^>]*>#i'], '', $line);
            $is_bold = str_contains($line, '<strong>') && trim($rest) === '';
            if ($is_bold) {
                $out .= '<span class="bold-line">' . trim($line) . '</span>';
            } else {
                $out .= $line . ($i < $last ? "<br />\n" : '');
            }
        }

        return '<p' . $p[1] . '>' . $out . '</p>';
    }, $html);
}

// Apply to every SCF WYSIWYG field, after the field's own formatting (wpautop)
add_filter('acf/format_value/type=wysiwyg', function ($value) {
    if (!is_string($value)) {
        return $value;
    }

    // The editor's "Read More" tag marks where a "show more" text is cut off
    $value = preg_replace('#(<p>\s*)?<!--more(.*?)?-->(\s*</p>)?#', '<span class="collapse-marker"></span>', $value);

    return una_bold_lines($value);
}, 20);
