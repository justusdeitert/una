<?php

// https://developer.wordpress.org/reference/hooks/allowed_block_types_all/
add_filter('allowed_block_types_all', function ($allowed_block_types) {
    return [
        // 'core/image',
        // 'core/paragraph',
        // 'core/heading',
        // 'core/separator',
        // 'core/list',
        // 'core/file',
        // 'core/button',
        // 'core/quote',
        // 'core/columns',
        // 'core/spacer',
        // 'core/html',
        'acf/content-section',
    ];
});
