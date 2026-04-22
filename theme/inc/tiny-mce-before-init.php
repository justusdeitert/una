<?php

// https://developer.wordpress.org/reference/hooks/tiny_mce_before_init/
add_filter('tiny_mce_before_init', function ($mce_init) {
    $block_formats = [
        'Paragraph=p',
        'Heading 1=h1',
        'Heading 2=h2',
        'Heading 3=h3',
    ];

    $mce_init['block_formats'] = implode(';', $block_formats);

    $style_formats = [
        [
            'title' => 'Medium Text',
            'block' => 'p',
            'classes' => 'medium',
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

// Add the "Formats" (styleselect) dropdown to the WYSIWYG toolbar so the
// custom style_formats above are selectable in the editor.
add_filter('mce_buttons_2', function ($buttons) {
    if (!in_array('styleselect', $buttons, true)) {
        array_unshift($buttons, 'styleselect');
    }

    return $buttons;
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
