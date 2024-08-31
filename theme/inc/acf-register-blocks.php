<?php

function acf_block_render_callback($block) {
    $slug = str_replace('acf/', '', $block['name']);
    $block['slug'] = $slug;
    $block['classes'] = implode(' ', [$block['slug'], $block['align']]);

    if (file_exists(locate_template("acf-blocks/${slug}.php"))) {
        include(locate_template("acf-blocks/${slug}.php"));
    }
}

add_action('acf/init', function () {
    if (function_exists('acf_register_block_type')) {

        $template_path = locate_template("acf-blocks/");

        if (!is_dir($template_path)) {
            error_log('ACF blocks directory does not exist: ' . $template_path);
            return;
        }

        $dir = new DirectoryIterator(locate_template("acf-blocks/"));

        foreach ($dir as $fileinfo) {
            if ($fileinfo->isFile() && $fileinfo->getExtension() === 'php') {

                $slug = str_replace('.php', '', $fileinfo->getFilename());
                $file_path = locate_template("acf-blocks/${slug}.php");

                $file_headers = get_file_data($file_path, [
                    'title' => 'Title',
                    'description' => 'Description',
                    'category' => 'Category',
                    'icon' => 'Icon',
                    'keywords' => 'Keywords',
                    'align' => 'Align',
                ]);

                if (empty($file_headers['title'])) {
                    die(_e('This block needs a title: ' . $file_path));
                }

                if (empty($file_headers['category'])) {
                    die(_e('This block needs a category: ' . $file_path));
                }

                if (!empty($file_headers['align'])) {
                    $align = [$file_headers['align']];
                }

                $args = [
                    'name' => $slug,
                    'title' => $file_headers['title'],
                    'description' => $file_headers['description'],
                    'category' => $file_headers['category'],
                    'icon' => $file_headers['icon'],
                    'keywords' => explode(' ', $file_headers['keywords']),
                    'render_callback'  => 'acf_block_render_callback',
                    'mode' => 'preview',
                    'supports' => [
                        'align' => false,
                    ],
                ];

                acf_register_block($args);
            }
        }
    }
});
