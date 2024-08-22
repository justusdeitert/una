<?php if (!get_field('split_up_on_mobile')) { ?>
    <div class="image-section-mobile-wrapper">
<?php } ?>

<?php if ($args['link']) { ?>
    <?php if (get_field('split_up_on_mobile')) { ?>
        <div class="section-mobile fp-scrollable">
    <?php } ?>

    <div class="section-mobile-inner">
        <a class="admin-prevent-click image-wrapper section-mobile-image-<?= $args['image']['ID']; ?>"
            href="<?= $args['link']['url']; ?>">
            <div class="hover-overlay"><?= $args['link']['title']; ?></div>
            <img data-src="<?= $args['image']['sizes']['large']; ?>" title="<?= $args['image']['caption']; ?>">
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
        <a data-caption="<?= $args['image']['caption']; ?>"
            class="admin-prevent-click image-wrapper smart-photo section-mobile-image-<?= $args['image']['ID']; ?>"
            href="<?= $args['image']['url']; ?>"
            data-group="mobile-group-<?= $args['image']['ID']; ?>">
            <div class="image-container">
                <img data-src="<?= $args['image']['sizes']['large']; ?>" title="<?= $args['image']['caption']; ?>">
                <div class="caption">
                    <div class="span">
                        <?= $args['image']['caption']; ?>
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
