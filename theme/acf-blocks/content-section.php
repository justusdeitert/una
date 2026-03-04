<?php
/*
  Title: Content Section
  Description: Dies ist der Image Section Block
  Category: common
  Icon: format-gallery
  Keywords: images section block
*/
?>

<?php if (get_field('content_section')) { ?>
    <div class="section-desktop fp-scrollable" itemscope itemtype="http://schema.org/ImageGallery">
        <?php
            while (has_sub_field('content_section')) {
                if (get_row_layout() == 'image') get_template_part('acf-blocks/desktop/image');
                if (get_row_layout() == 'text') get_template_part('acf-blocks/desktop/text');
                if (get_row_layout() == 'columns') get_template_part('acf-blocks/desktop/columns');
            }
        ?>
    </div>

    <?php if (!get_field('split_up_on_mobile')) { ?>
        <div class="section-mobile fp-scrollable">
    <?php } ?>

    <?php
        $section_id = 0;
        $all_content_sections = get_field('content_section');

        if (get_field('one_image_randomly_on_mobile')) {
            shuffle($all_content_sections);
        }

        $top_on_mobile_sections = [];

        foreach ($all_content_sections as $index => $content_section) {
            if (isset($content_section['top_on_mobile']) && $content_section['top_on_mobile']) {
                array_push($top_on_mobile_sections, $content_section);
                unset($all_content_sections[$index]);
            }
        }

        foreach ($top_on_mobile_sections as $top_on_mobile_section) {
            array_unshift($all_content_sections, $top_on_mobile_section);
        }

        foreach ($all_content_sections as $content_section) {
            $content_section['section_id'] = $section_id;

            if ($content_section['acf_fc_layout'] === 'image') {
                get_template_part('acf-blocks/mobile/image', '', $content_section);
            }

            if ($content_section['acf_fc_layout'] === 'text') {
                get_template_part('acf-blocks/mobile/text', '', $content_section);
            }

            if ($content_section['acf_fc_layout'] === 'columns') {
                get_template_part('acf-blocks/mobile/columns', '', $content_section);
            }

            $section_id++;

            if (get_field('one_image_randomly_on_mobile')) {
                if ($section_id >= 1) {
                    break;
                }
            }
        }
    ?>

    <?php if (!get_field('split_up_on_mobile')) { ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <section class="empty-block">
        <p><?= $block['title']; ?></p>
    </section>
<?php } ?>
