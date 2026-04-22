<?php
$accordion = get_sub_field('accordion');
$text = get_sub_field('text');
$full_width = get_sub_field('full_width');
$width = get_sub_field('width') ?: 'default';
$container_padding = get_sub_field('container_padding') ?: 'default';
$accordion_id = '';
$accordion_lines = 8;

$width_class_map = [
    'default' => 'col-md-10',
    'wide' => 'col-md-12',
    'narrow' => 'col-md-8',
];
$column_class = $width_class_map[$width] ?? $width_class_map['default'];

$content_container_classes = ['content-container', 'text-container-accordion'];
if ($container_padding === 'narrow') {
    $content_container_classes[] = 'content-container-narrow';
}

$text_container_classes = ['text-container'];

if ($accordion) {
    $accordion_id = get_sub_field_object('accordion')['key'];
    $accordion_lines = get_sub_field('accordion_lines') ?: 8;
    $text_container_classes[] = $accordion_id;
    $text_container_classes[] = 'collapse';
}

if ($full_width) {
    $text_container_classes[] = 'full-width';
}
?>
<div class="<?= esc_attr(implode(' ', $content_container_classes)); ?>">
    <div<?php if ($accordion_id) { ?> id="<?= esc_attr($accordion_id); ?>"<?php } ?> class="<?= esc_attr(implode(' ', $text_container_classes)); ?>"<?php if ($accordion) { ?> data-collapse-lines="<?= intval($accordion_lines); ?>" style="height: <?= round((intval($accordion_lines) + 0.5) * 16 * 1.4); ?>px"<?php } ?>>
        <div class="row">
            <div class="col-12 <?= esc_attr($column_class); ?>">
                <?php if ($text) { ?>
                    <p><?= wp_kses_post($text); ?></p>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php if ($accordion) { ?>
        <div class="row">
            <div class="col-12 <?= esc_attr($column_class); ?>">
                <a role="button" class="accordion-button-bottom collapsed" data-toggle="collapse" href="#<?= $accordion_id; ?>" aria-expanded="false" aria-controls="collapseExample"></a>
            </div>
        </div>
    <?php } ?>
</div>