<?php
/*
 * Standalone template for a single performance.
 *
 * Renders the performance page content as a full-screen page. When
 * the visitor reached this URL by clicking through fullpage.js the
 * frontend script fetches just the `.performance-page` element and
 * mounts it as an overlay; in that case this template is not used.
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <?php wp_head(); ?>
    </head>

    <body <?php body_class('performance-standalone'); ?>>
        <?php wp_body_open(); ?>

        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                get_template_part('template-parts/performance-content');
            }
        }
        ?>

        <?php wp_footer(); ?>
    </body>
</html>
