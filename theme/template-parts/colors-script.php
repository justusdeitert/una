<?php
$link_colors = [];
$colors = get_field('link_colors', 'option');

if ($colors) {
    foreach ($colors as $color) {
        $link_colors[] = $color['color'];
    }
}
?>

<div id="theme-colors" data-colors="<?= esc_attr(wp_json_encode($link_colors)); ?>" hidden></div>
