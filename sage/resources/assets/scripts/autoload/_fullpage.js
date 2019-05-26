// https://github.com/alvarotrigo/fullPage.js/wiki/Use-module-loaders-for-fullPage.js

// Optional. When using fullPage extensions
// import scrollHorizontally from './fullpage.scrollHorizontally.min';

// Optional. When using scrollOverflow:true
// import IScroll from 'fullpage.js/vendors/scrolloverflow';

// Importing fullpage.js
import fullpage from 'fullpage.js';

// Initializing it
const fullPageInstance = new fullpage('.fullpage', {
    navigation: false,
    // sectionsColor:['#ff5f45', '#0798ec', '#fc6c7c', 'grey']
});
