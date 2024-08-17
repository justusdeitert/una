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
        const linkHostname = new URL(this.href).hostname;

        if (linkHostname !== window.location.hostname) {
            anchor.attr('target', '_blank');
        }

        if (this.href === window.location.href) {
            anchor.on('click', (event) => {
                event.preventDefault();
                window.location.reload();
            });
        }

        if (this.href === window.location.origin) {
            anchor.on('click', (event) => {
                event.preventDefault();
                window.location.assign(window.location.origin);
            });
        }
    });
});
