<?php
/*
 * Renders the optional image-group caption (text + link) on mobile,
 * directly underneath the last image of the group. Mirrors the
 * desktop `.image-item-caption` markup so the styles in
 * `_fullpage.scss` apply to both layouts.
 */

$caption_text = $args['caption_text'] ?? '';
$caption_link = $args['caption_link'] ?? null;
$has_text = $caption_text !== '' && $caption_text !== null;
$has_link = !empty($caption_link);

if (!$has_text && !$has_link) {
    return;
}
?>
<div class="image-item-caption">
    <?php if ($has_text) { ?>
        <span class="image-item-caption-text"><?= nl2br(esc_html($caption_text)); ?></span>
    <?php } ?>
    <?php if ($has_link) { ?>
        <a class="image-item-caption-link"
            href="<?= esc_url($caption_link['url']); ?>"
            <?php if (!empty($caption_link['target'])) { ?>target="<?= esc_attr($caption_link['target']); ?>" rel="noopener"<?php } ?>>
            <?= esc_html($caption_link['title']); ?>
        </a>
    <?php } ?>
</div>
