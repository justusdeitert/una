<?php
add_filter( 'wp_generate_attachment_metadata', 'manipulate_metadata_wpse_91177', 10, 2 );

function manipulate_metadata_wpse_91177( $metadata, $attachment_id ) {
    // var_dump( $metadata['image_meta'] );
    // Credit is inside $metadata['image_meta']['credit']
    return $metadata;
}
