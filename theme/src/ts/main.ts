// Internal dependencies
import '@/ts/modules/collapse';
import '@/ts/modules/colors';
import '@/ts/modules/cookies';
import '@/ts/modules/device-class';
import '@/ts/modules/fullpage';
import '@/ts/modules/performance-restore';
import '@/ts/modules/sidebar';
import '@/ts/modules/photoswipe';

// Styles
import '@/scss/main.scss';

// Lazy-load draggable only when the element exists
if (document.getElementById('draggable')) {
	import('@/ts/modules/draggable');
}

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('#fullpage p:empty, #fullpage span:empty, #fullpage h3:empty').forEach((el) => {
		el.remove();
	});

	document.querySelectorAll('a').forEach((anchor) => {
		if (!anchor.href || !anchor.href.startsWith('http')) return;

		const linkHostname = new URL(anchor.href).hostname;

		if (linkHostname !== window.location.hostname) {
			anchor.setAttribute('target', '_blank');
		}

		if (anchor.href === window.location.href) {
			anchor.addEventListener('click', (event) => {
				event.preventDefault();
				window.location.reload();
			});
		}

		if (anchor.href === window.location.origin) {
			anchor.addEventListener('click', (event) => {
				event.preventDefault();
				window.location.assign(window.location.origin);
			});
		}
	});
});
