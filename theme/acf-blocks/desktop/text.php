<div class="content-container text-container-accordion">
    <?php
        $accordion_class = '';
        $accordion_id = '';
        $accordion_height = 200;
    ?>
    <?php if (get_sub_field('accordion')) { ?>
        <?php
            $accordion_class = 'collapse';
            $accordion_id = get_sub_field_object('accordion')['key'];
            $accordion_height = get_sub_field('accordion_height');
        ?>
        <style>
            .<?= $accordion_id; ?>.collapse {
                display: block;
                overflow: hidden;
                height: <?= $accordion_height; ?>px;
            }

            .<?= $accordion_id; ?>.collapse.show {
                height: auto;
            }

            .<?= $accordion_id; ?>.collapsing {
                height: <?= $accordion_height; ?>px;
            }
        </style>
    <?php } ?>
    <div id="<?= $accordion_id; ?>" class="text-container <?= $accordion_id; ?> <?= $accordion_class; ?> <?php if (get_sub_field('full_width')) { ?>full-width<?php } ?>">
        <div class="row">
            <div class="col-12 col-md-10">
                <?php if (get_sub_field('text')) { ?>
                    <p><?= get_sub_field('text'); ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php if (get_sub_field('accordion')) { ?>
        <div class="row">
            <div class="col-12 col-md-10">
                <a role="button" class="accordion-button-bottom collapsed" data-toggle="collapse" href="#<?= $accordion_id; ?>" aria-expanded="false" aria-controls="collapseExample"></a>
            </div>
        </div>
    <?php } ?>
</div>