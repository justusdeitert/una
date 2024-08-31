<?php

// https://developer.wordpress.org/reference/hooks/tiny_mce_before_init/
add_filter('tiny_mce_before_init', function($mce_init) {
    $block_formats = [
        'Paragraph=p',
        'Heading 3=h3',
    ];

    $mce_init['block_formats'] = implode(';', $block_formats);

    $style_formats = [
        [
            'title' => 'Dark Text',
            'block' => 'p',
            'classes' => 'dark',
            'wrapper' => false,
        ],
        [
            'title' => 'Big Text',
            'block' => 'p',
            'classes' => 'big',
            'wrapper' => false,
        ],
    ];

    $mce_init['style_formats'] = json_encode($style_formats);

    return $mce_init;
});
