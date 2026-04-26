<?php
$mobile_caption_text = $args['caption_text'] ?? '';
$mobile_caption_link = $args['caption_link'] ?? null;
$mobile_has_caption = ($mobile_caption_text !== '' && $mobile_caption_text !== null) || !empty($mobile_caption_link);
$from_image_group = !empty($args['from_image_group']);
$is_last_in_group = !empty($args['is_last_in_group']);
$wrapper_classes = trim(
    'image-section-mobile-wrapper'
    . ($from_image_group ? ' image-section-mobile-wrapper--group' : '')
    . ($from_image_group && $is_last_in_group ? ' image-section-mobile-wrapper--group-last' : '')
);
?>

<?php if (!get_field('split_up_on_mobile')) { ?>
    <div class="<?= esc_attr($wrapper_classes); ?>">
<?php } ?>

<?php if ($args['link']) { ?>
    <?php if (get_field('split_up_on_mobile')) { ?>
        <div class="section-mobile fp-scrollable">
    <?php } ?>

    <div class="section-mobile-inner<?= $from_image_group ? ' section-mobile-inner--group' : ''; ?>">
        <a class="admin-prevent-click image-wrapper section-mobile-image-<?= $args['image']['ID']; ?>"
            href="<?= esc_url($args['link']['url']); ?>">
            <div class="hover-overlay"><?= esc_html($args['link']['title']); ?></div>
            <img <?= una_img_attrs($args['image'], 'large', true, 'hero'); ?>
                title="<?= esc_attr($args['image']['caption']); ?>">
        </a>
    </div>
    <?php if ($mobile_has_caption) {
        get_template_part('acf-blocks/mobile/image-caption', '', [
            'caption_text' => $mobile_caption_text,
            'caption_link' => $mobile_caption_link,
        ]);
    } ?>

    <?php if (get_field('split_up_on_mobile')) { ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <?php if (get_field('split_up_on_mobile')) { ?>
        <div class="section-mobile fp-scrollable">
    <?php } ?>

    <div class="section-mobile-inner<?= $from_image_group ? ' section-mobile-inner--group' : ''; ?>">
        <a data-caption="<?= esc_attr($args['image']['caption']); ?>"
            class="admin-prevent-click image-wrapper smart-photo section-mobile-image-<?= $args['image']['ID']; ?>"
            href="<?= esc_url($args['image']['url']); ?>"
            data-group="mobile-group-<?= $args['image']['ID']; ?>">
            <div class="image-container">
                <img <?= una_img_attrs($args['image'], 'large', true, 'hero'); ?>
                    title="<?= esc_attr($args['image']['caption']); ?>">
                <div class="caption">
                    <div class="span">
                        <?= esc_html($args['image']['caption']); ?>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <?php if ($mobile_has_caption) {
        get_template_part('acf-blocks/mobile/image-caption', '', [
            'caption_text' => $mobile_caption_text,
            'caption_link' => $mobile_caption_link,
        ]);
    } ?>

    <?php if (get_field('split_up_on_mobile')) { ?>
        </div>
    <?php } ?>
<?php } ?>

<?php if (!get_field('split_up_on_mobile')) { ?>
    </div>
<?php } ?>
