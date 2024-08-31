<div class="page-wrapper">
    <header>
        <a class="brand" href="<?= home_url('/'); ?>">
            <?= get_bloginfo('name', 'display'); ?>
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
        <?php if (has_nav_menu('primary_navigation')) {
            wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container_class' => 'main-navigation',
            ]);
        } ?>
    </div>

    <div class="mobile-nav-clicker d-block d-md-none"></div>

    <div class="back-to-top colored-hover">
        <p>go up</p>
    </div>

    <div sidebarjs class="sidebar-wrapper-mobile d-block d-md-none">
        <?php if (has_nav_menu('primary_navigation')) {
            wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container_class' => 'main-navigation',
            ]);
        } ?>
    </div>
</div>