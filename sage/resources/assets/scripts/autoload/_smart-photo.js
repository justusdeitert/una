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
        // window.location.hash = '';
        console.log(window.storage.newSmartPhoto);
        $('.smartphoto-img-wrap').dblclick(function() {
            window.storage.newSmartPhoto.hidePhoto();
        });
    });

    // $(window).on('resize', function(e) {
    //     delete storage.newSmartPhoto;
    // });

    //
    // newSmartPhoto.on('change',function(){
    //     console.log('change');
    //     // window.location = window.location.href.split('#')[0];
    // });

    // $(window).scroll(() => {
    //     window.storage.newSmartPhoto.hidePhoto();
    // });

    //
    // $('body').click(() => {
    //     console.log('bodyClick');
    //     storage.newSmartPhoto = null;
    //     delete storage.newSmartPhoto;
    // });
    // $('.smartphoto-img-wrap').dblclick(function() {
    //     console.log('doubleclick');
    // });

});
