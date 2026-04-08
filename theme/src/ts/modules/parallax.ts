/**
 * Subtle parallax for images during fullpage.js section transitions.
 *
 * Outgoing images drift further in the scroll direction; incoming images
 * start offset from the opposite side and ease back to rest.
 */

const TRANSITION_MS = 800;
const EASING = 'cubic-bezier(0.65, 0, 0.35, 1)';

const DEPTH_VH_MIN = 18;
const DEPTH_VH_MAX = 32;

const SCALE_FROM = 1.06;

const IMG_SELECTOR = '.fp-section img';
const SECTION_SELECTOR = '.fp-section';

type Direction = 'up' | 'down';

const prefersReducedMotion = (): boolean =>
	window.matchMedia?.('(prefers-reduced-motion: reduce)').matches ?? false;

const depthFor = (index: number): number => {
	const range = DEPTH_VH_MAX - DEPTH_VH_MIN;
	const vh = DEPTH_VH_MIN + ((index * 7) % (range + 1));
	return Math.round((vh / 100) * window.innerHeight);
};

const applyBaseStyles = (img: HTMLImageElement): void => {
	img.style.willChange = 'transform';
	img.style.transition = `transform ${TRANSITION_MS}ms ${EASING}`;
	img.style.backfaceVisibility = 'hidden';
	img.style.transformOrigin = 'center center';
};

const transform = (offsetY: number, scale: number): string =>
	`translate3d(0, ${offsetY}px, 0) scale(${scale})`;

const setWithoutTransition = (img: HTMLImageElement, value: string): void => {
	img.style.transition = 'none';
	img.style.transform = value;
	// Force reflow so the restored transition applies to the next change.
	void img.offsetHeight;
	img.style.transition = `transform ${TRANSITION_MS}ms ${EASING}`;
};

export const initParallax = (): void => {
	if (prefersReducedMotion()) return;
	document.querySelectorAll<HTMLImageElement>(IMG_SELECTOR).forEach(applyBaseStyles);
};

export const onSectionLeave = (
	originIndex: number,
	destinationIndex: number,
	direction: Direction,
): void => {
	if (prefersReducedMotion()) return;

	const sections = document.querySelectorAll<HTMLElement>(SECTION_SELECTOR);
	const origin = sections[originIndex];
	const destination = sections[destinationIndex];
	if (!origin || !destination) return;

	const sign = direction === 'down' ? -1 : 1;

	origin.querySelectorAll<HTMLImageElement>('img').forEach((img, i) => {
		applyBaseStyles(img);
		img.style.transform = transform(sign * depthFor(i), SCALE_FROM);
	});

	destination.querySelectorAll<HTMLImageElement>('img').forEach((img, i) => {
		applyBaseStyles(img);
		const depth = depthFor(i);
		setWithoutTransition(img, transform(-sign * depth, SCALE_FROM));
		requestAnimationFrame(() => {
			img.style.transform = transform(0, 1);
		});
	});
};
