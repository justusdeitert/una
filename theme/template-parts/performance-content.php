<?php
/*
 * Renders the performance page content.
 *
 * Used both by the standalone single template and by the JS overlay
 * loader (which fetches the full page and extracts `.performance-page`).
 * Expects the loop to be set up by the caller.
 */

$heading = get_field('heading');
$image = get_field('image');
$image_caption = get_field('image_caption');
$image_position = get_field('image_position') ?: 'left';
$body = get_field('body');
$grid_classes = 'performance-body-grid';
if ($image_position === 'right') {
    $grid_classes .= ' performance-body-grid--image-right';
}
$slug = get_post_field('post_name', get_the_ID());
$close_url = home_url('/');
if ($slug) {
    $performance_url = get_permalink(get_the_ID());
    global $wpdb;
    $referrer_id = $wpdb->get_var($wpdb->prepare(
        "SELECT ID FROM {$wpdb->posts}
         WHERE post_status = 'publish'
           AND post_type IN ('page', 'post')
           AND post_content LIKE %s
         ORDER BY post_type = 'page' DESC, post_modified DESC
         LIMIT 1",
        '%' . $wpdb->esc_like($performance_url) . '%'
    ));
    if ($referrer_id) {
        $close_url = get_permalink((int) $referrer_id) . '#from_performance=' . rawurlencode($slug);
    } else {
        $close_url = home_url('/#from_performance=' . rawurlencode($slug));
    }
}
?>
<article class="performance-page" data-performance-page>
    <a class="performance-close"
        href="<?= esc_url($close_url); ?>"
        data-performance-close
        aria-label="<?= esc_attr__('Close', 'una'); ?>">
        <svg viewBox="0 0 24 24" width="48" height="48" aria-hidden="true">
            <line x1="4" y1="4" x2="20" y2="20" stroke="currentColor" stroke-width="1.5" />
            <line x1="20" y1="4" x2="4" y2="20" stroke="currentColor" stroke-width="1.5" />
        </svg>
    </a>

    <div class="performance-content">
        <?php if ($heading) { ?>
            <div class="performance-heading">
                <p class="big"><?= wp_kses_post($heading); ?></p>
            </div>
        <?php } ?>

        <div class="<?= esc_attr($grid_classes); ?>">
            <?php if ($image) { ?>
                <figure class="performance-image">
                    <img <?= una_img_attrs($image, 'large'); ?>
                        alt="<?= esc_attr($image['alt'] ?: $image['caption']); ?>">
                    <?php if ($image_caption) { ?>
                        <figcaption class="performance-image-caption">
                            <?= wp_kses_post($image_caption); ?>
                        </figcaption>
                    <?php } ?>
                </figure>
            <?php } ?>

            <?php if ($body) { ?>
                <div class="performance-body">
                    <?= apply_filters('the_content', $body); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</article>
