<?php

// https://developer.wordpress.org/reference/hooks/tiny_mce_before_init/
add_filter('tiny_mce_before_init', function ($mce_init) {
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

    $mce_init['style_formats'] = wp_json_encode($style_formats);

    return $mce_init;
});

// Strip non-breaking spaces and empty inline tags from WYSIWYG fields on save
add_filter('acf/update_value/type=wysiwyg', function ($value) {
    if (is_string($value)) {
        $value = str_replace(["\xC2\xA0", '&nbsp;', '&thinsp;', "\xE2\x80\x89"], ' ', $value);
        // Remove inline tags that only contain whitespace (e.g. <i> </i>, <b> </b>)
        $value = preg_replace('/<(i|b|em|strong|span)>\s*<\/\1>/', ' ', $value);
        // Collapse multiple consecutive spaces into one
        $value = preg_replace('/  +/', ' ', $value);
    }

    return $value;
});
