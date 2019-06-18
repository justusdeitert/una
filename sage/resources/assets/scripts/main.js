// import external dependencies
import 'jquery';

// Import everything from autoload
import './autoload/**/*';

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';

/** Populate Router instance with DOM routes */
const routes = new Router({
    // All pages
    common,
    // Home page
    home,
    // About Us page, note the change from about-us to aboutUs.
    aboutUs,
});

// Load Events
jQuery(document).ready(() => {
    routes.loadEvents();

    // Add Blank to All External Links
    $('a').each(function() {
        let a = new RegExp('/' + window.location.host + '/');
        if (!a.test(this.href)) {
            $(this).attr("target","_blank");
        }
    });

    $('p:empty').remove();
    $('span:empty').remove();
    $('h3:empty').remove();

    $('a').each(function() {
        if (this.href === window.location.href) {
            $(this).click(function(e) {
                e.preventDefault();
                location.reload(true);
            });
        }
    });
});

