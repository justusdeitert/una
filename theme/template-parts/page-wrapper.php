<div class="page-wrapper">
    <header>
        <a class="brand" href="<?= esc_url(home_url('/')); ?>">
            <?= esc_html(get_bloginfo('name', 'display')); ?>
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

    <div class="back-to-top colored-hover">
        <p>go up</p>
    </div>

    <div class="sidebar-nav d-block d-md-none">
        <div class="mobile-nav-clicker">
            <svg class="mobile-nav-label" viewBox="0 0 20 140" role="img" aria-label="Menu">
                <?php foreach (['M', 'E', 'N', 'U'] as $i => $letter) { ?>
                    <text x="0" y="<?= 20 + $i * 40; ?>" textLength="20" lengthAdjust="spacingAndGlyphs"><?= $letter; ?></text>
                <?php } ?>
            </svg>
        </div>
        <?php if (has_nav_menu('primary_navigation')) {
            wp_nav_menu([
                'theme_location' => 'primary_navigation',
                'container_class' => 'main-navigation',
            ]);
        } ?>
    </div>
</div>