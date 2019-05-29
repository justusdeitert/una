// https://github.com/alvarotrigo/fullPage.js/wiki/Use-module-loaders-for-fullPage.js

// Optional. When using fullPage extensions
// import scrollHorizontally from './fullpage.scrollHorizontally.min';

// Optional. When using scrollOverflow:true
// import IScroll from 'fullpage.js/vendors/scrolloverflow';

// Importing fullpage.js
// import 'fullpage.js/vendors/easings';
import 'fullpage.js/vendors/scrolloverflow';

import fullpage from 'fullpage.js';

const getSelectorOnResize = () => {
    if ($(window).width() < 859.98) {
        return '.section-mobile';
    } else {
        return '.section-desktop';
    }
};

window.instance = {};

// Initializing it
window.instance.fullPageInstance = new fullpage('#fullpage', {
    navigation: true,
    navigationPosition: 'left',
    responsiveHeight: 0,
    scrollOverflow: true,
    scrollHorizontally: true,
    // autoScrolling: true,
    //Custom selectors
    sectionSelector: getSelectorOnResize(),
    licenseKey: 'REMOVED',
    afterLoad: function (origin, destination, direction) {

        window.setTimeout(() => {
            $('#fp-nav').addClass('is-visible');
        }, 300);

        let all = $('#fp-nav li');

        $(all).removeClass('prev');
        $(all).removeClass('next');
        $(all).removeClass('visible');

        let li = $('#fp-nav a.active').parent('li');

        $(li).addClass('visible');

        $(li).prev().addClass('prev');
        $(li).next().addClass('next');

        $(li).prev().prev().addClass('prev');
        $(li).next().next().addClass('next');

    },
    afterRender: function () {

        window.setTimeout(() => {
            $('#fp-nav').addClass('is-visible');
        }, 300);

        let all = $('#fp-nav li');

        $(all).removeClass('prev');
        $(all).removeClass('next');
        $(all).removeClass('visible');

        let li = $('#fp-nav a.active').parent('li');

        $(li).addClass('visible');

        $(li).prev().addClass('prev');
        $(li).next().addClass('next');

        $(li).prev().prev().addClass('prev');
        $(li).next().next().addClass('next');

    }
});


// });
// let resizeTimer;

$(window).on('resize', function(e) {
    window.instance.fullPageInstance.destroy('all');

    window.instance.fullPageInstance = new fullpage('#fullpage', {
        navigation: true,
        navigationPosition: 'left',
        responsiveHeight: 0,
        scrollOverflow: true,
        scrollHorizontally: true,
        //Custom selectors
        sectionSelector: getSelectorOnResize(),
        licenseKey: 'REMOVED',
        afterLoad: function (origin, destination, direction) {

            window.setTimeout(() => {
                $('#fp-nav').addClass('is-visible');
            }, 300);

            let all = $('#fp-nav li');

            $(all).removeClass('prev');
            $(all).removeClass('next');
            $(all).removeClass('visible');

            let li = $('#fp-nav a.active').parent('li');

            $(li).addClass('visible');

            $(li).prev().addClass('prev');
            $(li).next().addClass('next');

            $(li).prev().prev().addClass('prev');
            $(li).next().next().addClass('next');

        },
        afterRender: function () {

            window.setTimeout(() => {
                $('#fp-nav').addClass('is-visible');
            }, 300);

            let all = $('#fp-nav li');

            $(all).removeClass('prev');
            $(all).removeClass('next');
            $(all).removeClass('visible');

            let li = $('#fp-nav a.active').parent('li');

            $(li).addClass('visible');

            $(li).prev().addClass('prev');
            $(li).next().addClass('next');

            $(li).prev().prev().addClass('prev');
            $(li).next().next().addClass('next');

        }
    });

});
