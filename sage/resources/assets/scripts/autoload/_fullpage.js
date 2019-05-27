// https://github.com/alvarotrigo/fullPage.js/wiki/Use-module-loaders-for-fullPage.js

// Optional. When using fullPage extensions
// import scrollHorizontally from './fullpage.scrollHorizontally.min';

// Optional. When using scrollOverflow:true
// import IScroll from 'fullpage.js/vendors/scrolloverflow';

// Importing fullpage.js
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
    //Custom selectors
    sectionSelector: getSelectorOnResize(),
    licenseKey: 'REMOVED',
    onLeave: function (origin, destination, direction) {
        console.log('onSlideLeave');

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
        //Custom selectors
        sectionSelector: getSelectorOnResize(),
        licenseKey: 'REMOVED',
        onLeave: function (origin, destination, direction) {
            console.log('onSlideLeave');

        }
    });

});
