// https://github.com/alvarotrigo/fullPage.js/wiki/Use-module-loaders-for-fullPage.js

// Optional. When using fullPage extensions
// import scrollHorizontally from './fullpage.scrollHorizontally.min';

// Optional. When using scrollOverflow:true
// import IScroll from 'fullpage.js/vendors/scrolloverflow';

// Importing fullpage.js
// import 'fullpage.js/vendors/easings';
import 'fullpage.js/vendors/scrolloverflow';

import fullpage from 'fullpage.js';

window.instance = {};

const newfullpageInstance = (sectionSelector) => {
    return new fullpage('#fullpage', {
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
        sectionSelector: sectionSelector,
        licenseKey: 'REMOVED',
        lazyLoading: true,
        afterLoad: afterLoad,
        afterRender: afterRender,
        onLeave: function(origin, destination, direction) {
            if ($('body').hasClass('smartphoto-is-open')) {
                window.storage.newSmartPhoto.hidePhoto();
            }

            window.sidebarinstance.closeSidebar();

            if(destination.index === $(getSelectorOnResize()).length - 1) {
                $('body').addClass('last-section')
            } else {
                $('body').removeClass('last-section')
            }
        }
    });
};

const getSelectorOnResize = () => {


    if($(window).width() < $(window).height()) {
        $('body').addClass('is-mobile');
        $('body').removeClass('is-desktop');
        // return '.section-mobile';
        // initFullPageInstanceMobile();
    } else {
        if ($(window).width() < 859.98) {
            $('body').addClass('is-mobile');
            $('body').removeClass('is-desktop');
            // return '.section-mobile';
            // initFullPageInstanceMobile();
        } else {
            $('body').removeClass('is-mobile');
            $('body').addClass('is-desktop');
            // return '.section-desktop';

        }
    }


    // if ($(window).width() < 859.98) {
    //     return '.section-mobile';
    // } else {
    //     return '.section-desktop';
    // }
};

const initFullPageInstanceDesktop = () => {
    if (!$(window).width() < 859.98) {
        $('body').removeClass('is-mobile');
        $('body').addClass('is-desktop');

        if(window.instance.fullPageInstanceMobile) {
            window.instance.fullPageInstanceMobile.destroy('all');
            window.instance.fullPageInstanceMobile = undefined;
        }

        // if(window.instance.fullPageInstanceMobile) {
        //     console.log('destroy mobile instance');
        //     window.instance.fullPageInstanceMobile.destroy('all');
        //     console.log(window.instance.fullPageInstanceMobile);
        // }
        return window.instance.fullPageInstanceDesktop = newfullpageInstance('.section-desktop');
    } else {
        return false
    }
};

const initFullPageInstanceMobile = () => {
    if ($(window).width() < 859.98) {
        $('body').addClass('is-mobile');
        $('body').removeClass('is-desktop');

        if(window.instance.fullPageInstanceDesktop) {
            window.instance.fullPageInstanceDesktop.destroy('all');
            window.instance.fullPageInstanceDesktop = undefined;
        }

        // if(window.instance.fullPageInstanceDesktop) {
        //     window.instance.fullPageInstanceDesktop.destroy('all');
        //     console.log(window.instance.fullPageInstanceDesktop);
        //
        // }

        return window.instance.fullPageInstanceMobile = newfullpageInstance('.section-mobile');
    } else {
        return false
    }
};

// const initFullPageInstanceMobile = () => {
//     return window.instance.fullPageInstanceMobile = newfullpageInstance('.section-mobile');
// };

// fullPage.js Methods
// -------------------------->
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

// initFullPageInstance();


$(window).on('load', () => {
    // Init Another Time on Window load, because of a not found mobile bug
    // window.instance.fullPageInstanceDesktop.destroy('all');
    // initFullPageInstance();

    // getSelectorOnResize();

    initFullPageInstanceDesktop();
    initFullPageInstanceMobile();
    // initFullPageInstanceDesktop();
});

$( window ).resize(() => {
    // initFullPageInstanceDesktop();
    // initFullPageInstanceMobile();

    // window.instance.fullPageInstanceDesktop.reBuild();
    // window.instance.fullPageInstanceMobile.reBuild();
});

$('.accordion').on('shown.bs.collapse', function() {
    window.instance.fullPageInstanceDesktop.reBuild();
    window.instance.fullPageInstanceMobile.reBuild();
});

$('.accordion').on('hidden.bs.collapse', function() {
    window.instance.fullPageInstanceDesktop.reBuild();
    window.instance.fullPageInstanceMobile.reBuild();
});


// Only when resize width
// ----------------->
// window.windowInstance = {};
// window.windowInstance.width = 0;

// $( window ).load( function(){
//     window.windowInstance.width = $( window ).width();
// });
//
// $('.back-to-top').click(() => {
//     window.instance.fullPageInstanceDesktop.moveTo(1);
// });
//
// $( window ).resize( function(){
//
//     if( window.windowInstance.width != $( window ).width() ){
//         //Do something
//         // window.instance.fullPageInstanceDesktop.destroy('all');
//         // initFullPageInstance();
//
//         window.instance.fullPageInstanceDesktop.reBuild();
//
//         console.log(window.instance.fullPageInstanceDesktop);
//
//         // window.instance.fullPageInstance.reBuild();
//
//         window.windowInstance.width = $( window ).width();
//         delete window.windowInstance.width;
//     }
// });
//
