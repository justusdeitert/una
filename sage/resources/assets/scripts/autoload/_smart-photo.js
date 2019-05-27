// Importing Compiled smartphoto from lib
import SmartPhoto from 'smartphoto/js/smartphoto.js'

let storage = {};

document.addEventListener('DOMContentLoaded',function() {
    storage.newSmartPhoto = new SmartPhoto('.smart-photo', {
        resizeStyle: 'fit', // resize images to fill/fit on the screen
        arrows: false,
        nav: false,
        useOrientationApi: true
    });

    // storage.newSmartPhoto.on('open',function(){
    //     window.location.hash = '';
    // });

    // $(window).on('resize', function(e) {
    //     delete storage.newSmartPhoto;
    // });

    //
    // newSmartPhoto.on('change',function(){
    //     console.log('change');
    //     // window.location = window.location.href.split('#')[0];
    // });

    // $(window).scroll(() => {
    //     console.log('scrol');
    //     storage.newSmartPhoto = null;
    //     delete storage.newSmartPhoto;
    // });
    //
    // $('body').click(() => {
    //     console.log('bodyClick');
    //     storage.newSmartPhoto = null;
    //     delete storage.newSmartPhoto;
    // });
});
