<div class="content-container">
    <div class="column-container <?php if (get_sub_field('full_width')) { ?>full-width<?php } ?>">
        <div class="row">
            <div class="col-12 col-md-10">
                <div class="row" itemscope itemtype="http://schema.org/ImageGallery">
                    <?php foreach (get_sub_field('column') as $column) { ?>
                        <div class="col-3">
                            <div class="column-text-container">
                                <h3><?= $column['headline']; ?></h3>
                                <?php if ($column['column']) { ?>
                                    <?php foreach ($column['column'] as $sub_column) { ?>
                                        <?php if ($sub_column['acf_fc_layout'] === 'image') { ?>
                                            <a data-caption="<?= $sub_column['image']['caption']; ?>" class="admin-prevent-click image-wrapper smart-photo section-desktop-image-<?= $sub_column['image']['ID']; ?>" href="<?= $sub_column['image']['url']; ?>" data-group="mobile-group-<?= $sub_column['image']['ID']; ?>" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                <div class="image-container">
                                                    <img src="<?= $sub_column['image']['sizes']['large']; ?>" title="<?= $sub_column['image']['caption']; ?>" itemprop="contentUrl">
                                                </div>
                                            </a>
                                        <?php } ?>
                                        <?php if ($sub_column['acf_fc_layout'] === 'text') { ?>
                                            <?= $sub_column['text']; ?>
                                        <?php } ?>
                                        <?php if ($sub_column['acf_fc_layout'] === 'text_and_image') { ?>
                                            <?= $sub_column['text']; ?>
                                            <a data-caption="<?= $sub_column['image']['caption']; ?>" class="admin-prevent-click image-wrapper smart-photo section-desktop-image-<?= $sub_column['image']['ID']; ?>" href="<?= $sub_column['image']['url']; ?>" data-group="mobile-group-<?= $sub_column['image']['ID']; ?>" itemprop="associatedMedia" itemscope itemtype="http://schema.org/ImageObject">
                                                <div class="image-container">
                                                    <img src="<?= $sub_column['image']['sizes']['large']; ?>" title="<?= $sub_column['image']['caption']; ?>" itemprop="contentUrl">
                                                </div>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>