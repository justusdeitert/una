<?php

function remove_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
}

add_action('wp_enqueue_scripts', 'remove_block_library_css', 100);