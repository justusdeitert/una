<?php
/*
 * Renders a single positioned image inside an `.image-group`.
 *
 * Expects `$args` with keys:
 *   image, link, image_width, position_top, position_right,
 *   position_bottom, position_left, hide_on_desktop,
 *   caption_text, caption_link
 *
 * The wrapper is intentionally absolute; the containing
 * `.image-group` establishes a `position: relative; height: 100vh;`
 * context so percentage positions resolve against one viewport.
 *
 * Optional `caption_text` and `caption_link` are rendered directly
 * underneath the image, left-aligned, inside the same positioned
 * wrapper so the image's anchor point stays unchanged.
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
$caption_text = $args['caption_text'] ?? '';
$caption_link = $args['caption_link'] ?? null;
$has_caption = ($caption_text !== '' && $caption_text !== null) || !empty($caption_link);
?>
<div class="image-item section-image-<?= $image['ID']; ?>">
    <?php if ($link) { ?>
        <a class="admin-prevent-click image-wrapper" href="<?= esc_url($link['url']); ?>">
            <div class="image-container" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                <div class="hover-overlay"><?= esc_html($link['title']); ?></div>
                <img <?= una_img_attrs($image, 'large', true, 'hero'); ?>
                    alt="<?= esc_attr($image['caption']); ?>"
                    itemprop="contentUrl">
            </div>
        </a>
    <?php } else { ?>
        <a data-caption="<?= esc_attr($image['caption']); ?>"
            class="admin-prevent-click image-wrapper smart-photo"
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
    <?php if ($has_caption) { ?>
        <div class="image-item-caption">
            <?php if ($caption_text !== '' && $caption_text !== null) { ?>
                <span class="image-item-caption-text"><?= nl2br(esc_html($caption_text)); ?></span>
            <?php } ?>
            <?php if (!empty($caption_link)) { ?>
                <a class="image-item-caption-link"
                    href="<?= esc_url($caption_link['url']); ?>"
                    <?php if (!empty($caption_link['target'])) { ?>target="<?= esc_attr($caption_link['target']); ?>" rel="noopener"<?php } ?>>
                    <?= esc_html($caption_link['title']); ?>
                </a>
            <?php } ?>
        </div>
    <?php } ?>
</div>
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
