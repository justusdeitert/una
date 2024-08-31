<?php

// Darken Color Function for Footer Form
function darken_color($rgb, $darker = 2) {
    $hash = (strpos($rgb, '#') !== false) ? '#' : '';
    $rgb = (strlen($rgb) == 7) ? str_replace('#', '', $rgb) : ((strlen($rgb) == 6) ? $rgb : false);

    if (strlen($rgb) != 6) return $hash . '000000';

    $darker = ($darker > 1) ? $darker : 1;

    list($R16, $G16, $B16) = str_split($rgb, 2);

    $R = sprintf("%02X", floor(hexdec($R16) / $darker));
    $G = sprintf("%02X", floor(hexdec($G16) / $darker));
    $B = sprintf("%02X", floor(hexdec($B16) / $darker));

    return $hash . $R . $G . $B;
}

// Return Bootstrap Grid classes Depending on the number of Columns
function returnColumnClasses($columns) {
    $col_classes = 'col-6 col-md-4 col-lg-3';

    if ($columns <= 3) $col_classes = 'col-6 col-md-4';
    if ($columns == 4) $col_classes = 'col-6 col-md-4 col-lg-3';
    if ($columns > 4 && $columns <= 7) $col_classes = 'col-6 col-md-4';
    if ($columns > 7) $col_classes = 'col-6 col-md-4 col-lg-3';

    return $col_classes;
}
