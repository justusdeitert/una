<?php get_header(); ?>

<div class="page-wrapper">
    <header>
        <a class="brand" href="<?php echo home_url('/'); ?>">
            <?php echo get_bloginfo('name', 'display'); ?>
        </a>
    </header>

    <div class="wrap container" role="document">
        <div class="content">
            <main class="main">
                <div id="fullpage">
                    <?php the_content(); ?>
                </div>
            </main>
        </div>
    </div>

    <div class="sidebar-desktop">
        <?php if (has_nav_menu('primary_navigation')) { ?>
            <?= wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container_class' => 'main-navigation',
            ]) ?>
        <?php } ?>
    </div>

    <div class="mobile-nav-clicker d-block d-md-none"></div>

    <div class="back-to-top colored-hover">
        <p>go up</p>
    </div>

    <div sidebarjs class="sidebar-wrapper-mobile d-block d-md-none">
        <?php if (has_nav_menu('primary_navigation')): ?>
            <?= wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container_class' => 'main-navigation',
            ]); ?>
        <?php endif; ?>
    </div>
</div>

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
        <?php if ($image_link_url): ?>
            <a href="<?php echo $image_link_url; ?>">
        <?php endif; ?>
        <div class="image-wrapper">
            <div class="image-container">
                <img src="<?php echo $image['sizes']['large']; ?>">
            </div>
        </div>
        <?php if ($image_link_url): ?>
            </a>
        <?php endif; ?>
        <div class="text-container">
            <?php echo $text; ?>
        </div>
    </div>
    <?php if ($width): ?>
        <style>
            #draggable {
                width: <?php echo $width; ?>px !important;
            }
        </style>
    <?php endif;
}
wp_reset_postdata();
?>

<?php get_footer(); ?>

<?php
$link_colors = [];
$colors = get_field('link_colors', 'option');

if ($colors) {
    foreach ($colors as $color) {
        $link_colors[] = $color['color'];
    }
}
?>
