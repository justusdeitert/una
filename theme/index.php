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

<?php if (is_front_page()) { ?>
    <?php get_template_part('template-parts/event-draggable'); ?>
<?php } ?>

<?php get_footer(); ?>

<?php get_template_part('template-parts/colors-script'); ?>