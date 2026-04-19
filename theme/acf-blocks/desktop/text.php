<?php
$accordion = get_sub_field('accordion');
$text = get_sub_field('text');
$full_width = get_sub_field('full_width');
$accordion_class = '';
$accordion_id = '';
$accordion_lines = 8;
?>
<div class="content-container text-container-accordion">
    <?php if ($accordion) { ?>
        <?php
            $accordion_class = 'collapse';
        $accordion_id = get_sub_field_object('accordion')['key'];
        $accordion_lines = get_sub_field('accordion_lines') ?: 8;
        ?>
    <?php } ?>
    <div id="<?= $accordion_id; ?>" class="text-container <?= $accordion_id; ?> <?= $accordion_class; ?> <?php if ($full_width) { ?>full-width<?php } ?>" <?php if ($accordion) { ?>data-collapse-lines="<?= intval($accordion_lines); ?>" style="height: <?= round((intval($accordion_lines) + 0.5) * 16 * 1.4); ?>px"<?php } ?>>
        <div class="row">
            <div class="col-12 col-md-10">
                <?php if ($text) { ?>
                    <p><?= wp_kses_post($text); ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php if ($accordion) { ?>
        <div class="row">
            <div class="col-12 col-md-10">
                <a role="button" class="accordion-button-bottom collapsed" data-toggle="collapse" href="#<?= $accordion_id; ?>" aria-expanded="false" aria-controls="collapseExample"></a>
            </div>
        </div>
    <?php } ?>
</div>