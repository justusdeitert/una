<?php
$section_id = $args['section_id'];
$accordion_class = '';
$accordion_id = '';
$accordion_height = 200;
?>
<?php if (get_field('split_up_on_mobile')) { ?>
    <div class="section-mobile fp-scrollable">
<?php } ?>

<div class="content-container text-container-accordion">
    <?php if ($args['accordion']) { ?>
        <?php
            $accordion_class = 'collapse';
        $accordion_id = 'accordion-mobile-text-' . $section_id;
        $accordion_height = $args['accordion_height'];
        ?>
        <style>
            .<?= $accordion_id; ?>.collapse {
                display: block;
                overflow: hidden;
                height: <?= intval($accordion_height); ?>px;
            }

            .<?= $accordion_id; ?>.collapse.show {
                height: auto;
            }

            .<?= $accordion_id; ?>.collapsing {
                height: <?= intval($accordion_height); ?>px;
            }
        </style>
    <?php } ?>
    <div id="<?= $accordion_id; ?>" class="text-container <?= $accordion_id; ?> <?= $accordion_class; ?>">
        <div class="row">
            <div class="col-12 col-md-11">
                <?php if ($args['text']) { ?>
                    <p><?= wp_kses_post($args['text']); ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php if ($args['accordion']) { ?>
        <div class="row">
            <div class="col-12 col-md-10">
                <a role="button" class="accordion-button-bottom collapsed" data-toggle="collapse" href="#<?= $accordion_id; ?>" aria-expanded="false" aria-controls="collapseExample"></a>
            </div>
        </div>
    <?php } ?>
</div>

<?php if (get_field('split_up_on_mobile')) { ?>
    </div>
<?php } ?>