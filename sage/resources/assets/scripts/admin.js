// Wordpress Admin Scripts
console.log('is admin');

// Change WP Menu Labels with Javascript
// Todo: Sure there is a way to to it in the Backend! But not figured it out for submenu items! yet
// have a look at -> theme/resources/includes/adjust-wp-admin.php
// ---------------------->
const changeMenuNames = {
    'Taxonomy Order': 'Reihenfolge'
};

for (const key in changeMenuNames) {
    jQuery(`a:contains(${key})`).each(function() {
        $(this).html(changeMenuNames[key]);
    })
}

// $('a').each(function() {
//    // console.log(this)
// });
//
// $('.editor-styles-wrapper a').click(function(event) {
//     console.log('test');
//     event.preventDefault();
//     $(this).addClass('prevent-click');
// });
