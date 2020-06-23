<?php
// Generic Functions
// Darken Color Function for Footer Form
function darken_color($rgb, $darker=2) {

    $hash = (strpos($rgb, '#') !== false) ? '#' : '';
    $rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);
    if(strlen($rgb) != 6) return $hash.'000000';
    $darker = ($darker > 1) ? $darker : 1;

    list($R16,$G16,$B16) = str_split($rgb,2);

    $R = sprintf("%02X", floor(hexdec($R16)/$darker));
    $G = sprintf("%02X", floor(hexdec($G16)/$darker));
    $B = sprintf("%02X", floor(hexdec($B16)/$darker));

    return $hash.$R.$G.$B;
}

// --------------------->
// Redirect if only one search result
add_action('template_redirect', 'single_result');
function single_result() {
    if (is_search()) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
        }
    }
}

// Query more posts when search!
// ----------------------------->
add_filter('pre_get_posts', function($query) {
    if ( $query->is_search ) // Make sure it is a search page
        $query->query_vars['posts_per_page'] = 999; // Change 10 to the number of posts you would like to show

    return $query; // Return our modified query variables
}); // Hook our custom function onto the request filter

// Return Bootstrap Grid classes Depending on the number of Columns
// --------------------------------->
function returnColumnClasses($columns) {
    $col_classes = 'col-6 col-md-4 col-lg-3';

    if($columns <= 3) {
        $col_classes = 'col-6 col-md-4';
    }

    if($columns == 4) {
        $col_classes = 'col-6 col-md-4 col-lg-3';
    }

    if($columns > 4 && $columns <= 7) {
        $col_classes = 'col-6 col-md-4';
    }

    if($columns > 7) {
        $col_classes = 'col-6 col-md-4 col-lg-3';
    }

    return $col_classes;
}
