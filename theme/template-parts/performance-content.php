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
$body_second_column = get_field('body_second_column');
$body_wide_first_column = get_field('body_wide_first_column');
$body_align_bottom = get_field('body_align_bottom');
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
    <div class="performance-content">
        <a class="performance-close"
            href="<?= esc_url($close_url); ?>"
            data-performance-close
            aria-label="<?= esc_attr__('Close', 'una'); ?>">
            <svg viewBox="0 0 350 350" width="48" height="48" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                <path d="M337.664 0.41866L175 163.068L11.7085 0L0.41816 11.3038L163.501 175.209L0 338.696L11.4994 350L175 186.722L338.919 349.791L350 338.487L187.336 175.209L349.164 11.5132L337.664 0.41866Z" fill="currentColor"/>
            </svg>
        </a>

        <?php if ($heading) { ?>
            <div class="performance-heading">
                <p class="big"><?= wp_kses_post($heading); ?></p>
            </div>
        <?php } ?>

        <div class="<?= esc_attr($grid_classes); ?>">
            <?php if ($image) { ?>
                <figure class="performance-image">
                    <a class="smart-photo"
                        href="<?= esc_url($image['url']); ?>"
                        data-caption="<?= esc_attr($image_caption ?: $image['caption']); ?>">
                        <img <?= una_img_attrs($image, 'large'); ?>
                            alt="<?= esc_attr($image['alt'] ?: $image['caption']); ?>">
                    </a>
                    <?php if ($image_caption) { ?>
                        <figcaption class="performance-image-caption">
                            <?= wp_kses_post($image_caption); ?>
                        </figcaption>
                    <?php } ?>
                </figure>
            <?php } ?>

            <?php if ($body) { ?>
                <div class="performance-body<?= $body_second_column ? ' performance-body--has-second-column' : ''; ?><?= $body_wide_first_column ? ' performance-body--wide-first-column' : ''; ?><?= $body_align_bottom ? ' performance-body--align-bottom' : ''; ?>">
                    <div class="performance-body-col">
                        <?= apply_filters('the_content', $body); ?>
                    </div>
                    <?php if ($body_second_column) { ?>
                        <div class="performance-body-col">
                            <?= apply_filters('the_content', $body_second_column); ?>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</article>
