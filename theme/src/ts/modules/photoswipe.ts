import PhotoSwipe from 'photoswipe';
import 'photoswipe/style.css';

let activePswp: PhotoSwipe | null = null;

const clearUrlHash = (): void => {
	history.pushState(null, '', window.location.href.split('#')[0]);
};

const CLOSE_FADE_MS = 300;

export const closeLightboxInstant = (): void => {
	if (!activePswp) return;

	const pswp = activePswp;
	activePswp = null;

	// Strip all DOM event listeners so PhotoSwipe can't interfere
	pswp.events.removeAll();

	// Clean up body classes and URL hash immediately
	document.body.classList.remove('lightbox-is-open', 'lightbox-zoomed-in');
	clearUrlHash();

	const el = pswp.element;
	if (el) {
		// Fade out the element visually
		el.style.pointerEvents = 'none';
		el.style.transition = `opacity ${CLOSE_FADE_MS}ms ease`;
		el.style.opacity = '0';

		// Remove from DOM after fade, never call pswp.close() during fullpage transition
		setTimeout(() => el.remove(), CLOSE_FADE_MS);
	}
};

export const isLightboxOpen = (): boolean => activePswp !== null;

const closeZonesHtml =
	'<div class="pswp__close-zone pswp__close-zone--top"></div>' +
	'<div class="pswp__close-zone pswp__close-zone--right"></div>' +
	'<div class="pswp__close-zone pswp__close-zone--bottom"></div>' +
	'<div class="pswp__close-zone pswp__close-zone--left"></div>';

const openLightbox = (triggerEl: HTMLElement, src: string, caption: string): void => {
	const img = new Image();
	img.onload = () => {
		const thumbEl = triggerEl.querySelector('img') || triggerEl;
		const thumbSrc = (thumbEl as HTMLImageElement).src || thumbEl.getAttribute('data-src') || src;

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
			pswp.ui?.registerElement({
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
				pswp.ui?.registerElement({
					name: 'customCaption',
					appendTo: 'wrapper',
					onInit: (el) => {
						el.classList.add('pswp__caption');
						el.textContent = caption;
					},
				});
			}
		});

		// @ts-expect-error PhotoSwipe types missing 'opening' event
		pswp.on('opening', () => {
			document.body.classList.add('lightbox-is-open');
			pswp.element?.classList.add('pswp--bg-instant');
		});

		pswp.on('openingAnimationEnd', () => {
			pswp.element?.classList.remove('pswp--bg-instant');
			clearUrlHash();

			pswp.element?.addEventListener('wheel', () => closeLightboxInstant(), { once: true });
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

document.addEventListener('DOMContentLoaded', () => {
	document.querySelectorAll<HTMLAnchorElement>('.smart-photo').forEach((trigger) => {
		trigger.addEventListener('click', (e) => {
			e.preventDefault();
			openLightbox(trigger, trigger.getAttribute('href') || '', trigger.dataset.caption || '');
		});
	});
});
