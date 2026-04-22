<?php
/*
 * Desktop Image Group layout.
 *
 * One image group equals one viewport sized positioning context.
 * Absolute positions inside resolve against the group, not the
 * enclosing fullpage section, which makes it safe to combine an
 * image group with text or column layouts in the same section.
 */
?>
<div class="image-group">
    <?php
    if (have_rows('images')) {
        while (have_rows('images')) {
            the_row();
            get_template_part('acf-blocks/desktop/image-item', '', [
                'image' => get_sub_field('image'),
                'link' => get_sub_field('link'),
                'image_width' => get_sub_field('image_width'),
                'position_top' => get_sub_field('position_top'),
                'position_right' => get_sub_field('position_right'),
                'position_bottom' => get_sub_field('position_bottom'),
                'position_left' => get_sub_field('position_left'),
                'hide_on_desktop' => get_sub_field('hide_on_desktop'),
            ]);
        }
    }
    ?>
</div>
