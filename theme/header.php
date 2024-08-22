<!doctype html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <?php
    function new_title()
    {
        echo str_replace(' ', '', wp_title('', false));
    }
    function new_description()
    {
        echo str_replace(' ', '', bloginfo('description'));
    }
    ?>

    <title><?php bloginfo('name'); ?>: <?php is_front_page() ? new_description() : new_title(); ?></title>

    <meta name="google-site-verification" content="ciWuq4bh-v2OypfzSbKRdhCO10qDmoRUncd1O1rX6fs" />

    <?php if (get_field('page_description', 'option')) : ?>
        <meta name="description" content="<?php echo get_field('page_description', 'option'); ?>" />
        <meta property="og:description" content="<?php echo get_field('page_description', 'option'); ?>" />
    <?php endif; ?>

    <?php if (get_field('favicon', 'option')) : ?>
        <link href="<?php echo get_field('favicon', 'option')['url']; ?>" rel="shortcut icon" />
    <?php endif; ?>

    <?php if (get_field('touch_icon', 'option')) : ?>
        <link href="<?php echo get_field('touch_icon', 'option')['url']; ?>" rel="apple-touch-icon-precompiled" />
        <meta name="msapplication-TileImage" content="<?php echo get_field('touch_icon', 'option')['url']; ?>">
    <?php endif; ?>

    <meta property="og:type" content="website" />
    <meta property="og:title" content="<?php echo get_bloginfo('name'); ?>: <?php new_description(); ?>" />
    <meta property="og:url" content="<?php echo get_home_url(); ?>" />

    <?php
        if (get_field('open_graph_images', 'option')) {
            $images = get_field('open_graph_images', 'option');
            foreach ($images as $image) {
                if (isset($image['url'])) {
                    echo '<meta property="og:image" content="' . $image['url'] . '" />';
                }
            }
        }
    ?>

    <?php wp_head(); ?>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons&text=close,keyboard_arrow_up" rel="stylesheet">
</head>
<body <?php body_class(); ?>>
