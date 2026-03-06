// Internal dependencies
import '@/js/modules/collapse';
import '@/js/modules/cookies';
import '@/js/modules/draggable';
import '@/js/modules/fullpage';
import '@/js/modules/sidebar';
import '@/js/modules/smart-photo';

// Styles
import '@/scss/main.scss';

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll('#fullpage p:empty, #fullpage span:empty, #fullpage h3:empty').forEach((el) => {
		el.remove();
	});

	document.querySelectorAll('a').forEach((anchor) => {
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
