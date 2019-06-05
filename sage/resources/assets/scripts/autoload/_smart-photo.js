// Importing Compiled smartphoto from lib
import SmartPhoto from 'smartphoto/js/smartphoto.js';

window.storage = {};

document.addEventListener('DOMContentLoaded', function() {
    window.storage.newSmartPhoto = new SmartPhoto('.smart-photo', {
        resizeStyle: 'fit', // resize images to fill/fit on the screen
        arrows: false,
        nav: false,
        useOrientationApi: true
    });

    window.storage.newSmartPhoto.on('open',function(){
        $('.smartphoto-img-wrap').dblclick(function() {
            window.storage.newSmartPhoto.hidePhoto();
        });

        history.pushState(null, null, window.location.href.split('#')[0]);
        $('body').addClass('smartphoto-is-open')
    });

    window.storage.newSmartPhoto.on('close',function(){
        history.pushState(null, null, window.location.href.split('#')[0]);
        $('body').removeClass('smartphoto-is-open')
    });

    window.storage.newSmartPhoto.on('change',function(){
        history.pushState(null, null, window.location.href.split('#')[0]);
    });

    window.storage.newSmartPhoto.on('swipeend',function(){
        history.pushState(null, null, window.location.href.split('#')[0]);
        setTimeout(() => {
            history.pushState(null, null, window.location.href.split('#')[0]);
        }, 50)
    });
});
