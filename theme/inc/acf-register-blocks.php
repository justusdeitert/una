<?php

function acf_block_render_callback($block) {
    $slug = str_replace('acf/', '', $block['name']);
    $template = locate_template("acf-blocks/{$slug}.php");

    if ($template) {
        include($template);
    }
}

add_action('acf/init', function () {
    if (!function_exists('acf_register_block_type')) {
        return;
    }

    $blocks_path = locate_template('acf-blocks/');

    if (!is_dir($blocks_path)) {
        error_log('ACF blocks directory does not exist: ' . $blocks_path);
        return;
    }

    $dir = new DirectoryIterator($blocks_path);

    foreach ($dir as $fileinfo) {
        if (!$fileinfo->isFile() || $fileinfo->getExtension() !== 'php') {
            continue;
        }

        $slug = str_replace('.php', '', $fileinfo->getFilename());
        $file_path = $blocks_path . $fileinfo->getFilename();

        $file_headers = get_file_data($file_path, [
            'title' => 'Title',
            'description' => 'Description',
            'category' => 'Category',
            'icon' => 'Icon',
            'keywords' => 'Keywords',
        ]);

        if (empty($file_headers['title'])) {
            wp_die('This block needs a title: ' . esc_html($file_path));
        }

        if (empty($file_headers['category'])) {
            wp_die('This block needs a category: ' . esc_html($file_path));
        }

        acf_register_block_type([
            'name' => $slug,
            'title' => $file_headers['title'],
            'description' => $file_headers['description'],
            'category' => $file_headers['category'],
            'icon' => $file_headers['icon'],
            'keywords' => explode(' ', $file_headers['keywords']),
            'render_callback' => 'acf_block_render_callback',
            'mode' => 'preview',
            'supports' => [
                'align' => false,
            ],
        ]);
    }
});
