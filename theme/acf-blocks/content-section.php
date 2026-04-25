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

                if ($layout === 'image_group') {
                    get_template_part('acf-blocks/desktop/image-group');
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

    /*
     * Normalise the mobile list: expand every `image_group` row into
     * its individual images so each one renders as its own mobile
     * entry. Text and column layouts pass through untouched.
     */
    $mobile_items = [];

    foreach ($all_content_sections as $content_section) {
        $layout = $content_section['acf_fc_layout'];

        if ($layout === 'image_group') {
            $images = $content_section['images'] ?? [];
            $group_caption_text = $content_section['caption_text'] ?? '';
            $group_caption_link = $content_section['caption_link'] ?? null;
            $last_index = count($images) - 1;

            foreach ($images as $index => $image_row) {
                $is_last = $index === $last_index;
                $mobile_items[] = array_merge($image_row, [
                    'acf_fc_layout' => 'image',
                    'from_image_group' => true,
                    'caption_text' => $is_last ? $group_caption_text : '',
                    'caption_link' => $is_last ? $group_caption_link : null,
                ]);
            }
            continue;
        }

        $mobile_items[] = $content_section;
    }

    if ($one_random) {
        $image_sections = array_values(array_filter($mobile_items, function ($section) {
            return $section['acf_fc_layout'] === 'image';
        }));

        if ($image_sections) {
            $mobile_items = [$image_sections[array_rand($image_sections)]];
        }
    } else {
        // Move items marked "top_on_mobile" to the front
        $top = [];
        $rest = [];

        foreach ($mobile_items as $content_section) {
            if (!empty($content_section['top_on_mobile'])) {
                $top[] = $content_section;
            } else {
                $rest[] = $content_section;
            }
        }

        $mobile_items = array_merge($top, $rest);
    }

    foreach ($mobile_items as $content_section) {
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
