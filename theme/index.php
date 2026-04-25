<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php wp_head(); ?>

        <style>html.performance-restoring body{visibility:hidden}</style>
        <script>(function(){if(window.location.hash.indexOf('from_performance')>-1){document.documentElement.classList.add('performance-restoring');}})();</script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons&text=close,keyboard_arrow_up" as="style" onload="this.onload=null;this.rel='stylesheet'">
        <noscript><link href="https://fonts.googleapis.com/icon?family=Material+Icons&text=close,keyboard_arrow_up" rel="stylesheet"></noscript>
    </head>

    <body <?php body_class(); ?>>
        <?php wp_body_open(); ?>

        <?php get_template_part('template-parts/page-wrapper'); ?>

        <?php if (is_front_page()) {
            get_template_part('template-parts/event-draggable');
        } ?>

        <?php get_template_part('template-parts/colors-script'); ?>

        <?php wp_footer(); ?>
    </body>
</html>

