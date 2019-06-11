<?php
// https://wordpress.stackexchange.com/questions/91177/save-camera-info-as-metadata-on-image-upload
// https://codex.wordpress.org/Function_Reference/wp_generate_attachment_metadata


// TODO: DOES NOT WORK!!!!
// add_filter( 'wp_generate_attachment_metadata', 'manipulate_metadata_wpse_91177', 10, 2 );
//
// function manipulate_metadata_wpse_91177( $metadata, $attachment_id ) {
//     // var_dump( $metadata['image_meta'] );
//     // Credit is inside $metadata['image_meta']['credit']
//     return $metadata;
// }
