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
            while (have_rows('content_section')) {
                the_row();
                $layout = get_row_layout();

                if ($layout === 'image') {
                    get_template_part('acf-blocks/desktop/image');
                }

                if ($layout === 'text') {
                    get_template_part('acf-blocks/desktop/text');
                }

                if ($layout === 'columns') {
                    get_template_part('acf-blocks/desktop/columns');
                }
            }
    ?>
    </div>

    <?php $split_up = get_field('split_up_on_mobile'); ?>

    <?php if (!$split_up) { ?>
        <div class="section-mobile fp-scrollable">
    <?php } ?>

    <?php
    $section_id = 0;
    $all_content_sections = get_field('content_section');
    $one_random = get_field('one_image_randomly_on_mobile');

    if ($one_random) {
        $all_content_sections = [$all_content_sections[array_rand($all_content_sections)]];
    } else {
        // Move items marked "top_on_mobile" to the front
        $top = [];
        $rest = [];

        foreach ($all_content_sections as $content_section) {
            if (!empty($content_section['top_on_mobile'])) {
                $top[] = $content_section;
            } else {
                $rest[] = $content_section;
            }
        }

        $all_content_sections = array_merge($top, $rest);
    }

    foreach ($all_content_sections as $content_section) {
        $content_section['section_id'] = $section_id;
        $layout = $content_section['acf_fc_layout'];

        if ($layout === 'image') {
            get_template_part('acf-blocks/mobile/image', '', $content_section);
        }

        if ($layout === 'text') {
            get_template_part('acf-blocks/mobile/text', '', $content_section);
        }

        if ($layout === 'columns') {
            get_template_part('acf-blocks/mobile/columns', '', $content_section);
        }

        $section_id++;
    }
    ?>

    <?php if (!$split_up) { ?>
        </div>
    <?php } ?>
<?php } else { ?>
    <section class="empty-block">
        <p><?= esc_html($block['title']); ?></p>
    </section>
<?php } ?>
