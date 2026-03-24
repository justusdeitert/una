<?php

// https://developer.wordpress.org/reference/hooks/after_setup_theme
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('responsive-embeds');
    add_theme_support('customize-selective-refresh-widgets');
    add_theme_support('align-wide');
    add_theme_support('editor-color-palette', [
        [
            'name' => __('Blue', 'una'),
            'slug' => 'blue',
            'color' => '#0687B4',
        ],
        [
            'name' => __('Orange', 'una'),
            'slug' => 'orange',
            'color' => '#F4952E',
        ],
        [
            'name' => __('Pink', 'una'),
            'slug' => 'pink',
            'color' => '#AC2E87',
        ],
        [
            'name' => __('Green', 'una'),
            'slug' => 'green',
            'color' => '#006256',
        ],
        [
            'name' => __('Grey One', 'una'),
            'slug' => 'grey_one',
            'color' => '#53575A',
        ],
        [
            'name' => __('Grey Two', 'una'),
            'slug' => 'grey_two',
            'color' => '#A6A7A9',
        ],
        [
            'name' => __('White', 'una'),
            'slug' => 'white',
            'color' => '#FFF',
        ],
        [
            'name' => __('Black', 'una'),
            'slug' => 'black',
            'color' => '#000',
        ],
    ]);

    remove_theme_support('core-block-patterns');
    remove_theme_support('block-templates');

    add_image_size('column', 480, 0, false);
});

add_filter('intermediate_image_sizes_advanced', function (array $sizes): array {
    unset($sizes['thumbnail']);

    return $sizes;
});
