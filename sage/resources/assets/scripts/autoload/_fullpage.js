// https://github.com/alvarotrigo/fullPage.js/wiki/Use-module-loaders-for-fullPage.js

// Optional. When using fullPage extensions
// import scrollHorizontally from './fullpage.scrollHorizontally.min';

// Optional. When using scrollOverflow:true
// import IScroll from 'fullpage.js/vendors/scrolloverflow';

// Importing fullpage.js
// import 'fullpage.js/vendors/easings';
import 'fullpage.js/vendors/scrolloverflow';

import fullpage from 'fullpage.js';

const getSelectorOnWindowSize = () => {
    if($(window).width() < $(window).height()) {
        $('body').addClass('is-mobile');
        $('body').removeClass('is-desktop');
        return '.section-mobile';
    } else {
        if ($(window).width() < 859.98) {
            $('body').addClass('is-mobile');
            $('body').removeClass('is-desktop');
            return '.section-mobile';
        } else {
            $('body').removeClass('is-mobile');
            $('body').addClass('is-desktop');
            // console.log(window.instance.fullPageInstance.sectionSelector);
            return '.section-desktop';

        }
    }
    // if ($(window).width() < 859.98) {
    //     return '.section-mobile';
    // } else {
    //     return '.section-desktop';
    // }
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
        scrollOverflowOptions: {
            preventDefault: false,
            // disablePointer: true,
        },
        // scrollHorizontally: true,
        // Custom selectors
        sectionSelector: getSelectorOnWindowSize(),
        licenseKey: 'REMOVED',
        lazyLoading: true,
        afterLoad: afterLoad,
        afterRender: afterRender,
        onLeave: function(origin, destination, direction) {
            if ($('body').hasClass('smartphoto-is-open')) {
                window.storage.newSmartPhoto.hidePhoto();
            }

            window.sidebarinstance.closeSidebar();

            if(destination.index === $(getSelectorOnWindowSize()).length - 1) {
                $('body').addClass('last-section')
            } else {
                $('body').removeClass('last-section')
            }
        }
    });
};


// initFullPageInstance();

$(window).on('load', function() {
    // Init Another Time on Window load, because of a not found mobile bug
    // window.instance.fullPageInstance.destroy('all');
    initFullPageInstance();
});

$('.accordion').on('shown.bs.collapse', function() {
    window.instance.fullPageInstance.reBuild();
});

$('.accordion').on('hidden.bs.collapse', function() {
    window.instance.fullPageInstance.reBuild();
});


// Only when resize width
// ----------------->
window.windowInstance = {};
window.windowInstance.width = 0;

$( window ).load( function(){
    window.windowInstance.width = $( window ).width();
});

$('.back-to-top').click(() => {
    window.instance.fullPageInstance.moveTo(1);
});

$(window).on('resize', () => {

    let sectionSelector = window.instance.fullPageInstance.getFullpageData().sectionSelector;

    if($(window).width() < $(window).height()) {

        if (sectionSelector === '.section-desktop') {
            window.instance.fullPageInstance.destroy('all');
            initFullPageInstance();
        }

    } else {
        if ($(window).width() < 859.98) {
            if (sectionSelector === '.section-desktop') {
                window.instance.fullPageInstance.destroy('all');
                initFullPageInstance();
            }

        } else {
            if (sectionSelector === '.section-mobile') {
                window.instance.fullPageInstance.destroy('all');
                initFullPageInstance();
            }
        }
    }

    // Only on width change
    // ------------>
    // if(window.windowInstance.width != $( window ).width()) {
    //
    //     // console.log(getSelectorOnWindowSize());
    //
    //
    //
    //
    //     //Do something
    //     // window.instance.fullPageInstance.destroy('all');
    //     // initFullPageInstance();
    //
    //     // window.instance.fullPageInstance.reBuild();
    //
    //     window.windowInstance.width = $( window ).width();
    //     delete window.windowInstance.width;
    // }
});

