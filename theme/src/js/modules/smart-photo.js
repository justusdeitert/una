import PhotoSwipe from 'photoswipe';
import 'photoswipe/style.css';

let activePswp = null;

const clearUrlHash = () => {
	history.pushState(null, null, window.location.href.split('#')[0]);
};

export const closeLightboxFade = () => {
	if (activePswp) {
		activePswp.options.showHideAnimationType = 'fade';
		activePswp.close();
	}
};

export const isLightboxOpen = () => activePswp !== null;

const closeZonesHtml =
	'<div class="pswp__close-zone pswp__close-zone--top"></div>' +
	'<div class="pswp__close-zone pswp__close-zone--right"></div>' +
	'<div class="pswp__close-zone pswp__close-zone--bottom"></div>' +
	'<div class="pswp__close-zone pswp__close-zone--left"></div>';

const openLightbox = (triggerEl, src, caption) => {
	const img = new Image();
	img.onload = () => {
		const thumbEl = triggerEl.querySelector('img') || triggerEl;
		const thumbSrc = thumbEl.src || thumbEl.getAttribute('data-src') || src;

		const pswp = new PhotoSwipe({
			dataSource: [
				{
					src: src,
					msrc: thumbSrc,
					width: img.naturalWidth,
					height: img.naturalHeight,
					alt: caption,
					element: triggerEl,
				},
			],
			index: 0,
			bgOpacity: 1,
			showHideAnimationType: 'zoom',
			initialZoomLevel: 'fit',
			secondaryZoomLevel: 1,
			maxZoomLevel: 2,
			imageClickAction: 'zoom',
			tapAction: 'close',
			doubleTapAction: 'close',
			closeOnVerticalDrag: true,
			pinchToClose: true,
			padding: { top: 60, bottom: 80, left: 60, right: 60 },
			counter: false,
			zoom: false,
			arrowKeys: false,
		});

		activePswp = pswp;

		pswp.on('slideActivate', ({ slide }) => {
			const origToggle = slide.toggleZoom.bind(slide);
			slide.toggleZoom = () => {
				const center = {
					x: pswp.viewportSize.x / 2,
					y: pswp.viewportSize.y / 2,
				};
				origToggle(center);
			};
		});

		pswp.on('uiRegister', () => {
			// Hide default UI buttons
			pswp.ui.registerElement({
				name: 'customCloseZones',
				appendTo: 'wrapper',
				onInit: (el) => {
					el.innerHTML = closeZonesHtml;
					el.querySelectorAll('.pswp__close-zone').forEach((zone) => {
						zone.addEventListener('click', () => pswp.close());
					});
				},
			});

			// Caption element
			if (caption) {
				pswp.ui.registerElement({
					name: 'customCaption',
					appendTo: 'wrapper',
					onInit: (el) => {
						el.classList.add('pswp__caption');
						el.textContent = caption;
					},
				});
			}
		});

		pswp.on('opening', () => {
			document.body.classList.add('lightbox-is-open');
			pswp.element.classList.add('pswp--bg-instant');
		});

		pswp.on('openingAnimationEnd', () => {
			pswp.element.classList.remove('pswp--bg-instant');
			clearUrlHash();
		});

		pswp.on('zoomPanUpdate', ({ slide }) => {
			const isZoomed = slide.currZoomLevel > slide.zoomLevels.fit + 0.01;
			document.body.classList.toggle('lightbox-zoomed-in', isZoomed);
		});

		pswp.on('destroy', () => {
			clearUrlHash();
			document.body.classList.remove('lightbox-is-open', 'lightbox-zoomed-in');
			activePswp = null;
		});

		pswp.init();
	};
	img.src = src;
};

document.addEventListener('DOMContentLoaded', function () {
	document.querySelectorAll('.smart-photo').forEach((trigger) => {
		trigger.addEventListener('click', (e) => {
			e.preventDefault();
			openLightbox(
				trigger,
				trigger.getAttribute('href'),
				trigger.dataset.caption || ''
			);
		});
	});
});
