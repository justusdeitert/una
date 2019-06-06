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

const afterLoad = () => {
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

    $('.fp-tableCell').each(function() {
        if($(this).has('.content-container').length) {
            $(this).addClass('vertical-top')
        } else {
            $(this).removeClass('vertical-top')
        }
    });
};

const afterRender = () => {
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
};

const initFullPageInstance = () => {
    return window.instance.fullPageInstance = new fullpage('#fullpage', {
        navigation: true,
        navigationPosition: 'left',
        responsiveHeight: 0,
        scrollOverflow: true,
        // scrollHorizontally: true,
        // Custom selectors
        sectionSelector: getSelectorOnResize(),
        licenseKey: 'REMOVED',
        afterLoad: afterLoad,
        afterRender: afterRender,
        onLeave: function() {
            console.log(window.storage.newSmartPhoto);
            if(window.storage.newSmartPhoto) {
                window.storage.newSmartPhoto.hidePhoto();
            }
        }
        //    window.storage.newSmartPhoto.hidePhoto();
    });
};

// console.log($('.fp-tableCell:has(.content-container)'));

initFullPageInstance();

$(window).on('load', function() {
    // Init Another Time on Window load, because of a not found mobile bug
    window.instance.fullPageInstance.destroy('all');
    initFullPageInstance();
});

$('.accordion').on('shown.bs.collapse', function() {
    window.instance.fullPageInstance.destroy('all');
    initFullPageInstance();
    //console.log("shown");
});

$('.accordion').on('hidden.bs.collapse', function() {
    window.instance.fullPageInstance.destroy('all');
    initFullPageInstance();
    //console.log("shown");
});


$('.accordion-header').click(function() {
    window.instance.fullPageInstance.destroy('all');
    initFullPageInstance();
});

// });
// let resizeTimer;

$(window).on('resize', function() {
    window.instance.fullPageInstance.destroy('all');
    initFullPageInstance();
});
