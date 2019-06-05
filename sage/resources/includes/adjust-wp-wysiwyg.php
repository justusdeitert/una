<?php

// Do Not Copy HTML contents to wysywig on paste
// TODO: Find a better Solution for Not Copying Acf Styles
// This is Kind of nasty
// ------------------------------------>
add_filter('tiny_mce_before_init', function($in) {
    $in['paste_preprocess'] = "function(plugin, args){
    // Strip all HTML tags except those we have whitelisted
    var whitelist = 'p,span,b,strong,i,em,h3,h4,h5,h6,ul,li,ol';
    var stripped = jQuery('<div>' + args.content + '</div>');
    var els = stripped.find('*').not(whitelist);
    for (var i = els.length - 1; i >= 0; i--) {
      var e = els[i];
      jQuery(e).replaceWith(e.innerHTML);
    }
    // Strip all class and id attributes
    stripped.find('*').removeAttr('id').removeAttr('class');
    // Return the clean HTML
    args.content = stripped.html();
  }";
    return $in;
});

/**
 * Change the block formats available in TinyMCE.
 *
 * @link http://codex.wordpress.org/TinyMCE_Custom_Styles
 *
 * @param array $init Default settings to be overridden.
 *
 * @return array The modified $init array.
 */
// https://stevegrunwell.com/blog/wordpress-tinymce-block-formats/
function change_mce_block_formats($init) {
    $block_formats = array(
        'Paragraph=p',
        // 'Heading 1=h1',
        // 'Heading 2=h2',
        'Heading 3=h3',
        // 'Heading 4=h4',
        // 'Heading 5=h5',
        // 'Heading 6=h6',
        // 'Preformatted=pre',
        // 'Code=code',
    );

    $init['block_formats'] = implode( ';', $block_formats );

    return $init;
}
add_filter( 'tiny_mce_before_init', 'change_mce_block_formats' );


// Callback function to filter the MCE settings
// https://www.wpbeginner.com/wp-tutorials/how-to-add-custom-styles-to-wordpress-visual-editor/
function my_mce_before_init_insert_formats( $init_array ) {

    // Define the style_formats array

    $style_formats = array(
        /*
        * Each array child is a format with it's own settings
        * Notice that each array has title, block, classes, and wrapper arguments
        * Title is the label which will be visible in Formats menu
        * Block defines whether it is a span, div, selector, or inline style
        * Classes allows you to define CSS classes
        * Wrapper whether or not to add a new block-level element around any selected elements
        */
        // array(
        //     'title' => 'Content Block',
        //     'block' => 'span',
        //     'classes' => 'content-block',
        //     'wrapper' => true,
        //
        // ),
        array(
            'title' => 'Dark Text',
            'block' => 'p',
            'classes' => 'dark',
            'wrapper' => false,
        ),
        array(
            'title' => 'Big Text',
            'block' => 'p',
            'classes' => 'big',
            'wrapper' => false,
        ),
    );
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );

    return $init_array;

}
// Attach callback to 'tiny_mce_before_init'
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );
