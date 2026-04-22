<?php
/*
 * Renders a single positioned image inside an `.image-group`.
 *
 * Expects `$args` with keys:
 *   image, link, image_width, position_top, position_right,
 *   position_bottom, position_left, hide_on_desktop
 *
 * The wrapper is intentionally absolute; the containing
 * `.image-group` establishes a `position: relative; height: 100vh;`
 * context so percentage positions resolve against one viewport.
 */

if (!empty($args['hide_on_desktop'])) {
    return;
}

$image = $args['image'] ?? null;

if (!$image) {
    return;
}

$link = $args['link'] ?? null;
$image_width = $args['image_width'] ?? '';
$position_top = $args['position_top'] ?? '';
$position_right = $args['position_right'] ?? '';
$position_bottom = $args['position_bottom'] ?? '';
$position_left = $args['position_left'] ?? '';
?>
<?php if ($link) { ?>
    <a class="admin-prevent-click image-wrapper section-image-<?= $image['ID']; ?>" href="<?= esc_url($link['url']); ?>">
        <div class="image-container" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <div class="hover-overlay"><?= esc_html($link['title']); ?></div>
            <img <?= una_img_attrs($image, 'large', true, 'hero'); ?>
                alt="<?= esc_attr($image['caption']); ?>"
                itemprop="contentUrl">
        </div>
    </a>
<?php } else { ?>
    <a data-caption="<?= esc_attr($image['caption']); ?>"
        class="admin-prevent-click image-wrapper smart-photo section-image-<?= $image['ID']; ?>"
        href="<?= esc_url($image['url']); ?>"
        data-group="desktop-group-<?= $image['ID']; ?>">
        <div class="image-container" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
            <img <?= una_img_attrs($image, 'large', true, 'hero'); ?>
                title="<?= esc_attr($image['caption']); ?>"
                itemprop="contentUrl">
            <div class="caption">
                <div class="span" itemprop="description">
                    <?= esc_html($image['caption']); ?>
                </div>
            </div>
        </div>
    </a>
<?php } ?>
<style>
    .section-image-<?= $image['ID']; ?> {
        position: absolute;
        <?php if ($image_width !== '' && $image_width !== null) { ?> width: <?= floatval($image_width); ?>%; <?php } ?>
        <?php if ($position_top !== '' && $position_top !== null) { ?> top: <?= floatval($position_top); ?>%; <?php } ?>
        <?php if ($position_right !== '' && $position_right !== null) { ?> right: <?= floatval($position_right); ?>%; <?php } ?>
        <?php if ($position_bottom !== '' && $position_bottom !== null) { ?> bottom: <?= floatval($position_bottom); ?>%; <?php } ?>
        <?php if ($position_left !== '' && $position_left !== null) { ?> left: <?= floatval($position_left); ?>%; <?php } ?>
    }
</style>
