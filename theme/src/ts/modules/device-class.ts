/*
 * Toggles `is-mobile` / `is-desktop` classes on the document body based
 * on viewport size and orientation. Runs everywhere (including pages
 * without fullpage.js) and stays in sync with resize events.
 */

const BREAKPOINT_MD = 859.98;

const updateDeviceClass = (): void => {
	const isMobile = window.innerWidth < window.innerHeight || window.innerWidth < BREAKPOINT_MD;

	document.body.classList.toggle('is-mobile', isMobile);
	document.body.classList.toggle('is-desktop', !isMobile);
};

updateDeviceClass();

document.addEventListener('DOMContentLoaded', updateDeviceClass);
window.addEventListener('resize', updateDeviceClass);
