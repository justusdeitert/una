<?php if (!get_sub_field('hide_on_desktop')) { ?>
    <?php
        $image = get_sub_field('image');
        $link = get_sub_field('link');
        $image_width = get_sub_field('image_width');
        $position_top = get_sub_field('position_top');
        $position_right = get_sub_field('position_right');
        $position_bottom = get_sub_field('position_bottom');
        $position_left = get_sub_field('position_left');
    ?>
    <div class="image-section">
        <?php if ($image) { ?>
            <?php if ($link) { ?>
                <a class="admin-prevent-click image-wrapper section-image-<?= $image['ID']; ?>" href="<?= esc_url($link['url']); ?>">
                    <div class="image-container" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                        <div class="hover-overlay"><?= esc_html($link['title']); ?></div>
                        <img data-src="<?= esc_url($image['sizes']['large']); ?>"
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
                        <img data-src="<?= esc_url($image['sizes']['large']); ?>"
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
                    <?php if ($image_width) { ?> width: <?= floatval($image_width); ?>%; <?php } ?>
                    <?php if ($position_top) { ?> top: <?= floatval($position_top); ?>%; <?php } ?>
                    <?php if ($position_right) { ?> right: <?= floatval($position_right); ?>%; <?php } ?>
                    <?php if ($position_bottom) { ?> bottom: <?= floatval($position_bottom); ?>%; <?php } ?>
                    <?php if ($position_left) { ?> left: <?= floatval($position_left); ?>%; <?php } ?>
                }
            </style>
        <?php } ?>
    </div>
<?php } ?>