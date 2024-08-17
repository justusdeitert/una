<?php if (!get_sub_field('hide_on_desktop')) { ?>
    <div class="image-section">
        <?php if (get_sub_field('image')) { ?>
            <?php if (get_sub_field('link')) { ?>
                <a class="admin-prevent-click image-wrapper section-image-<?= get_sub_field('image')['ID']; ?>" href="<?= get_sub_field('link')['url']; ?>">
                    <div class="image-container" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                        <div class="hover-overlay"><?= get_sub_field('link')['title']; ?></div>
                        <img data-src="<?= get_sub_field('image')['sizes']['large']; ?>"
                            alt="<?= get_sub_field('image')['caption']; ?>"
                            itemprop="contentUrl">
                    </div>
                </a>
            <?php } else { ?>
                <a data-caption="<?= get_sub_field('image')['caption']; ?>"
                    class="admin-prevent-click image-wrapper smart-photo section-image-<?= get_sub_field('image')['ID']; ?>"
                    href="<?= get_sub_field('image')['url']; ?>"
                    data-group="desktop-group-<?= get_sub_field('image')['ID']; ?>">
                    <div class="image-container" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                        <img data-src="<?= get_sub_field('image')['sizes']['large']; ?>"
                            title="<?= get_sub_field('image')['caption']; ?>"
                            itemprop="contentUrl">
                        <div class="caption">
                            <div class="span" itemprop="description">
                                <?= get_sub_field('image')['caption']; ?>
                            </div>
                        </div>
                    </div>
                </a>
            <?php } ?>
            <style>
                .section-image-<?= get_sub_field('image')['ID']; ?> {
                    position: absolute;
                    <?php if (get_sub_field('image_width')) { ?> width: <?= get_sub_field('image_width'); ?>%; <?php } ?>
                    <?php if (get_sub_field('position_top')) { ?> top: <?= get_sub_field('position_top'); ?>%; <?php } ?>
                    <?php if (get_sub_field('position_right')) { ?> right: <?= get_sub_field('position_right'); ?>%; <?php } ?>
                    <?php if (get_sub_field('position_bottom')) { ?> bottom: <?= get_sub_field('position_bottom'); ?>%; <?php } ?>
                    <?php if (get_sub_field('position_left')) { ?> left: <?= get_sub_field('position_left'); ?>%; <?php } ?>
                }
            </style>
        <?php } ?>
    </div>
<?php } ?>