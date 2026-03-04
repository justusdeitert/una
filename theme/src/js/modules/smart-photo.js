// Importing Compiled smartphoto from lib
import SmartPhoto from 'smartphoto/js/smartphoto.js';

export let smartPhoto = null;

const closeButtonsHtml =
	'<div class="smartphoto-header-close top"></div>' +
	'<div class="smartphoto-header-close right"></div>' +
	'<div class="smartphoto-header-close bottom"></div>' +
	'<div class="smartphoto-header-close left"></div>';

const clearUrlHash = () => {
	history.pushState(null, null, window.location.href.split('#')[0]);
};

const rebuildCloseButtons = () => {
	document.querySelectorAll('.smartphoto-header-close').forEach(el => el.remove());
	const header = document.querySelector('.smartphoto-header');
	if (header) header.insertAdjacentHTML('beforeend', closeButtonsHtml);
	document.querySelectorAll('.smartphoto-header-close').forEach(el => {
		el.addEventListener('click', () => smartPhoto.hidePhoto());
	});
};

document.addEventListener('DOMContentLoaded', function () {
	smartPhoto = new SmartPhoto('.smart-photo', {
		resizeStyle: 'fit',
		arrows: false,
		nav: false,
		useOrientationApi: true,
	});

	smartPhoto.on('open', function () {
		document.querySelectorAll('.smartphoto-img-wrap').forEach(el => {
			el.addEventListener('dblclick', () => smartPhoto.hidePhoto());
		});
		clearUrlHash();
		document.body.classList.add('smartphoto-is-open');
	});

	smartPhoto.on('zoomin', function () {
		rebuildCloseButtons();
		document.body.classList.add('smartphoto-zoomed-in');
	});

	smartPhoto.on('zoomout', function () {
		document.querySelectorAll('.smartphoto-header-close').forEach(el => el.remove());
		document.body.classList.remove('smartphoto-zoomed-in');
	});

	smartPhoto.on('close', function () {
		clearUrlHash();
		document.body.classList.remove('smartphoto-is-open');
	});

	smartPhoto.on('change', clearUrlHash);

	smartPhoto.on('swipeend', function () {
		clearUrlHash();
		setTimeout(clearUrlHash, 50);
	});

	document.querySelectorAll('.smart-photo').forEach(el => {
		el.addEventListener('click', function () {
			clearUrlHash();
			setTimeout(clearUrlHash, 50);
		});
	});

	window.addEventListener('resize', function () {
		if (document.body.classList.contains('smartphoto-zoomed-in')) {
			setTimeout(rebuildCloseButtons, 200);
		}
	});
});
