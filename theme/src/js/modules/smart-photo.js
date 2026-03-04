import $ from 'jquery';

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
	$('.smartphoto-header-close').remove();
	$('.smartphoto-header').append(closeButtonsHtml);
	$('.smartphoto-header-close').click(() => smartPhoto.hidePhoto());
};

document.addEventListener('DOMContentLoaded', function () {
	smartPhoto = new SmartPhoto('.smart-photo', {
		resizeStyle: 'fit',
		arrows: false,
		nav: false,
		useOrientationApi: true,
	});

	smartPhoto.on('open', function () {
		$('.smartphoto-img-wrap').dblclick(() => smartPhoto.hidePhoto());
		clearUrlHash();
		$('body').addClass('smartphoto-is-open');
	});

	smartPhoto.on('zoomin', function () {
		rebuildCloseButtons();
		$('body').addClass('smartphoto-zoomed-in');
	});

	smartPhoto.on('zoomout', function () {
		$('.smartphoto-header-close').remove();
		$('body').removeClass('smartphoto-zoomed-in');
	});

	smartPhoto.on('close', function () {
		clearUrlHash();
		$('body').removeClass('smartphoto-is-open');
	});

	smartPhoto.on('change', clearUrlHash);

	smartPhoto.on('swipeend', function () {
		clearUrlHash();
		setTimeout(clearUrlHash, 50);
	});

	$('.smart-photo').click(function () {
		clearUrlHash();
		setTimeout(clearUrlHash, 50);
	});

	$(window).resize(function () {
		if ($('body').hasClass('smartphoto-zoomed-in')) {
			setTimeout(rebuildCloseButtons, 200);
		}
	});
});
