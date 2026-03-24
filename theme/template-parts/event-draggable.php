<?php

$current_event = new WP_Query([
    'post_type' => 'events',
    'posts_per_page' => 1,
]);

if ($current_event->have_posts()) {
    $current_event->the_post();
    $image = get_field('event_image', $current_event->post->ID);
    $image_link_url = get_field('image_link_url', $current_event->post->ID);
    $text = get_field('event_text', $current_event->post->ID);
    $width = get_field('drag_and_drop_panel_width', $current_event->post->ID);
    ?>

    <div id="draggable">
        <i class="material-icons">close</i>
        <?php if ($image_link_url) { ?>
            <a href="<?= esc_url($image_link_url); ?>">
        <?php } ?>
        <div class="image-wrapper">
            <div class="image-container">
                <img src="<?= esc_url($image['sizes']['large']); ?>" alt="<?= esc_attr($image['alt']); ?>">
            </div>
        </div>
        <?php if ($image_link_url) { ?>
            </a>
        <?php } ?>
        <div class="text-container">
            <?= wp_kses_post($text); ?>
        </div>
    </div>

    <?php if ($width) { ?>
        <style>
            #draggable {
                width: <?= intval($width); ?>px !important;
            }
        </style>
    <?php }
    }

wp_reset_postdata();
