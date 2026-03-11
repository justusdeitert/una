<div class="content-container">
    <div class="column-container">
        <div class="row">
            <div class="col-12 col-md-11">
                <?php
                    $section_id = $args['section_id'];
                    $iterator = 0;
                ?>
                <div id="accordion-<?= $section_id; ?>" class="accordion">
                    <div class="row">
                        <?php foreach ($args['column'] as $column) { ?>
                            <?php
                                $iterator++;
                                $header_id = 'accordion-header-' . $section_id . '-' . $iterator;
                                $body_id = 'accordion-body-' . $section_id . '-' . $iterator;
                            ?>
                            <div class="col-12">
                                <div class="column-text-container">
                                    <div class="accordion-header colored-hover" data-toggle="collapse" data-target="#<?= $body_id; ?>" id="<?= $header_id; ?>">
                                        <h3><?= esc_html($column['headline']); ?></h3>
                                        <i class="material-icons"></i>
                                    </div>
                                    <div class="accordion-body collapse" aria-labelledby="<?= $header_id; ?>" id="<?= $body_id; ?>" data-parent=".accordion">
                                        <div class="accordion-body-wrapper">
                                            <div class="row">
                                                <?php if ($column['column']) { ?>
                                                    <?php foreach ($column['column'] as $sub_column) { ?>
                                                        <?php if ($sub_column['acf_fc_layout'] === 'image') { ?>
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <a data-caption="<?= esc_attr($sub_column['image']['caption']); ?>" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-<?= $sub_column['image']['ID']; ?>" href="<?= esc_url($sub_column['image']['url']); ?>" data-group="mobile-group-<?= $sub_column['image']['ID']; ?>">
                                                                            <div class="image-container">
                                                                                <img src="<?= esc_url($sub_column['image']['sizes']['medium']); ?>" title="<?= esc_attr($sub_column['image']['caption']); ?>">
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($sub_column['acf_fc_layout'] === 'text') { ?>
                                                            <div class="col-12">
                                                                <div class="row">
                                                                    <div class="col-8">
                                                                        <?= $sub_column['text']; ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                        <?php if ($sub_column['acf_fc_layout'] === 'text_and_image') { ?>
                                                            <div class="col-12">
                                                                <div class="row text-and-image-container">
                                                                    <div class="col-8">
                                                                        <?= $sub_column['text']; ?>
                                                                    </div>
                                                                    <div class="col-4">
                                                                        <a data-caption="<?= esc_attr($sub_column['image']['caption']); ?>" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-<?= $sub_column['image']['ID']; ?>" href="<?= esc_url($sub_column['image']['url']); ?>" data-group="mobile-group-<?= $sub_column['image']['ID']; ?>">
                                                                            <div class="image-container">
                                                                                <img src="<?= esc_url($sub_column['image']['sizes']['medium']); ?>" title="<?= esc_attr($sub_column['image']['caption']); ?>">
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>