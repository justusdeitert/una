<?php if (!get_field('split_up_on_mobile')) { ?>
    <div class="image-section-mobile-wrapper">
<?php } ?>

<?php if ($args['link']) { ?>
    <?php if (get_field('split_up_on_mobile')) { ?>
        <div class="section-mobile fp-scrollable">
    <?php } ?>

    <div class="section-mobile-inner">
        <a class="admin-prevent-click image-wrapper section-mobile-image-<?= $args['image']['ID']; ?>"
            href="<?= esc_url($args['link']['url']); ?>">
            <div class="hover-overlay"><?= esc_html($args['link']['title']); ?></div>
            <img <?= una_img_attrs($args['image'], 'large', true, 'hero'); ?>
                title="<?= esc_attr($args['image']['caption']); ?>">
        </a>
    </div>

    <?php if (get_field('split_up_on_mobile')) { ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <?php if (get_field('split_up_on_mobile')) { ?>
        <div class="section-mobile fp-scrollable">
    <?php } ?>

    <div class="section-mobile-inner">
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

    <?php if (get_field('split_up_on_mobile')) { ?>
        </div>
    <?php } ?>
<?php } ?>

<?php if (!get_field('split_up_on_mobile')) { ?>
    </div>
<?php } ?>
