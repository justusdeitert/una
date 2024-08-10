// External dependencies
import $ from 'jquery';
import 'slick-carousel';
import 'jquery-touchswipe';
import 'bootstrap/js/dist/collapse';

// Internal dependencies
import '@/js/modules/cookies';
import '@/js/modules/draggable';
import '@/js/modules/fullpage';
import '@/js/modules/sidebar';
import '@/js/modules/smart-photo';

// Styles
import '@/scss/main.scss';

document.addEventListener('DOMContentLoaded', () => {
    $('p:empty, span:empty, h3:empty').remove();

    $('a').each(function () {
        const anchor = $(this);
        const currentHref = this.href;
        const hostPattern = new RegExp(`/${window.location.host}/`);

        if (!hostPattern.test(currentHref)) {
            anchor.attr('target', '_blank');
        }

        if (currentHref === window.location.href) {
            anchor.on('click', (event) => {
                event.preventDefault();
                window.location.reload();
            });
        }

        if (currentHref === window.location.origin) {
            anchor.on('click', (event) => {
                event.preventDefault();
                window.location.assign(window.location.origin);
            });
        }
    });
});
