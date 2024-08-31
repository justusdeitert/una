<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php wp_head(); ?>

        <link href="https://fonts.googleapis.com/icon?family=Material+Icons&text=close,keyboard_arrow_up" rel="stylesheet">
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>

        <?php get_template_part('template-parts/page-wrapper'); ?>

        <?php if (is_front_page()) get_template_part('template-parts/event-draggable'); ?>

        <?php get_template_part('template-parts/colors-script'); ?>

        <?php wp_footer(); ?>
    </body>
</html>

