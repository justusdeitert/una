<?php
// https://wordpress.stackexchange.com/questions/91177/save-camera-info-as-metadata-on-image-upload
// https://codex.wordpress.org/Function_Reference/wp_generate_attachment_metadata


// TODO: DOES NOT WORK!!!!
// define the wp_generate_attachment_metadata callback
function filter_wp_generate_attachment_metadata( $metadata, $attachment_id ) {
    // make filter magic happen here...
    return $metadata;
};

// add the filter
add_filter( 'wp_generate_attachment_metadata', 'filter_wp_generate_attachment_metadata', 10, 2 );
