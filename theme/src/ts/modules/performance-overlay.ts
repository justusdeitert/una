/**
 * Performance page overlay.
 *
 * Intercepts clicks on links pointing to `/performance/<slug>` and
 * loads the page as an overlay on top of the existing fullpage.js
 * layout instead of doing a full navigation. The URL is updated via
 * `history.pushState` so the overlay has a real, shareable address.
 *
 * Direct visits to `/performance/<slug>` render through
 * `single-performance.php` as a standalone page. Its close link
 * carries a `#from_performance=<slug>` hash so we can scroll the
 * fullpage layout back to the section that contains the originating
 * link when the user lands on that page.
 */

import { fullPageInstance } from '@/ts/modules/fullpage';

const PERFORMANCE_PATH_RE = /^\/performance\/[^/]+\/?$/;
const OVERLAY_ID = 'performance-overlay';
const HISTORY_FLAG = '__performanceOverlay';

// Hide the page as early as possible (before fullpage builds) when the
// URL carries the from-performance hash, so we never paint the wrong
// section on the way to the right one.
function hasFromPerformanceHash(): boolean {
	const hash = window.location.hash.replace(/^#/, '');
	if (!hash) return false;
	return new URLSearchParams(hash).has('from_performance');
}

if (typeof document !== 'undefined' && hasFromPerformanceHash()) {
	document.documentElement.classList.add('performance-restoring');
}

let activeOverlay: HTMLElement | null = null;
let previousScrollY = 0;
let escListener: ((event: KeyboardEvent) => void) | null = null;

function isOverlayPath(url: URL): boolean {
	return url.origin === window.location.origin && PERFORMANCE_PATH_RE.test(url.pathname);
}

function shouldHandleClick(event: MouseEvent, anchor: HTMLAnchorElement): boolean {
	if (event.defaultPrevented) return false;
	if (event.button !== 0) return false;
	if (event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) return false;
	if (anchor.target && anchor.target !== '' && anchor.target !== '_self') return false;
	if (anchor.hasAttribute('download')) return false;
	if (anchor.dataset.performanceClose !== undefined) return false;

	try {
		const url = new URL(anchor.href, window.location.href);
		return isOverlayPath(url);
	} catch {
		return false;
	}
}

async function fetchPerformance(url: string): Promise<HTMLElement | null> {
	const response = await fetch(url, {
		credentials: 'same-origin',
		headers: { Accept: 'text/html' },
	});

	if (!response.ok) return null;

	const html = await response.text();
	const parser = new DOMParser();
	const doc = parser.parseFromString(html, 'text/html');
	const page = doc.querySelector<HTMLElement>('[data-performance-page]');

	return page;
}

function lockBodyScroll() {
	previousScrollY = window.scrollY;
	document.body.classList.add('performance-overlay-open');
}

function unlockBodyScroll() {
	document.body.classList.remove('performance-overlay-open');
	window.scrollTo(0, previousScrollY);
}

function attachOverlayListeners(overlay: HTMLElement) {
	const close = overlay.querySelector<HTMLAnchorElement>('[data-performance-close]');
	if (close) {
		close.addEventListener('click', (event) => {
			event.preventDefault();
			closeOverlay();
		});
	}

	escListener = (event: KeyboardEvent) => {
		if (event.key === 'Escape') {
			event.preventDefault();
			closeOverlay();
		}
	};
	document.addEventListener('keydown', escListener);
}

function detachOverlayListeners() {
	if (escListener) {
		document.removeEventListener('keydown', escListener);
		escListener = null;
	}
}

function mountOverlay(content: HTMLElement) {
	const overlay = document.createElement('div');
	overlay.id = OVERLAY_ID;
	overlay.className = 'performance-overlay';
	overlay.appendChild(content);
	document.body.appendChild(overlay);
	activeOverlay = overlay;
	lockBodyScroll();
	attachOverlayListeners(overlay);
}

function closeOverlay() {
	if (!activeOverlay) return;

	if (window.history.state && window.history.state[HISTORY_FLAG]) {
		// Triggers popstate which removes the overlay below.
		window.history.back();
		return;
	}

	removeOverlay();
}

function removeOverlay() {
	if (!activeOverlay) return;
	detachOverlayListeners();
	activeOverlay.remove();
	activeOverlay = null;
	unlockBodyScroll();
}

async function openOverlay(url: string, pushHistory: boolean) {
	const content = await fetchPerformance(url);
	if (!content) {
		window.location.href = url;
		return;
	}

	mountOverlay(content);

	if (pushHistory) {
		const previousUrl = window.location.href;
		window.history.pushState(
			{ [HISTORY_FLAG]: true, previousUrl },
			'',
			url,
		);
	}
}

function onClick(event: MouseEvent) {
	const target = event.target as HTMLElement | null;
	if (!target) return;

	const anchor = target.closest<HTMLAnchorElement>('a[href]');
	if (!anchor) return;
	if (!shouldHandleClick(event, anchor)) return;

	event.preventDefault();
	openOverlay(anchor.href, true);
}

function onPopState(event: PopStateEvent) {
	const state = event.state as { [HISTORY_FLAG]?: boolean } | null;

	if (state && state[HISTORY_FLAG]) {
		// Navigated forward to an overlay URL; ensure overlay matches.
		if (!activeOverlay) {
			openOverlay(window.location.href, false);
		}
		return;
	}

	// Navigated away from an overlay state.
	if (activeOverlay) {
		removeOverlay();
	}
}

function init() {
	// Standalone single-performance pages render their own close link
	// that points at home; nothing to wire up there.
	if (document.body.classList.contains('performance-standalone')) return;

	document.addEventListener('click', onClick);
	window.addEventListener('popstate', onPopState);

	maybeRestoreSection();
}

function maybeRestoreSection() {
	const params = new URLSearchParams(window.location.search);
	let slug = params.get('from_performance');

	// Also check the hash, which is what direct-visit close links use
	// (a hash avoids server-side query-string handling differences).
	const hash = window.location.hash.replace(/^#/, '');
	if (!slug && hash) {
		const hashParams = new URLSearchParams(hash);
		slug = hashParams.get('from_performance');
	}
	if (!slug) return;

	// Strip the marker from the URL so reloads do not re-trigger.
	params.delete('from_performance');
	const cleanSearch = params.toString();
	const cleanUrl = window.location.pathname + (cleanSearch ? `?${cleanSearch}` : '');
	window.history.replaceState(window.history.state, '', cleanUrl);

	const targetHref = `/performance/${slug}`;

	const findSectionIndex = (): number => {
		const sections = Array.from(document.querySelectorAll<HTMLElement>('.fp-section'));
		if (sections.length === 0) return -1;
		const anchors = document.querySelectorAll<HTMLAnchorElement>('a[href]');
		for (const anchor of anchors) {
			let path: string;
			try {
				path = new URL(anchor.href, window.location.origin).pathname.replace(/\/$/, '');
			} catch {
				continue;
			}
			if (path !== targetHref) continue;
			const section = anchor.closest<HTMLElement>('.fp-section');
			if (!section) continue;
			const index = sections.indexOf(section);
			if (index >= 0) return index;
		}
		return -1;
	};

	const reveal = () => {
		document.documentElement.classList.remove('performance-restoring');
	};

	const onAfterRender = () => {
		document.removeEventListener('fullpage:afterRender', onAfterRender);

		// fullPageInstance is assigned after the constructor returns,
		// but afterRender fires from inside it.
		requestAnimationFrame(() => {
			const targetIndex = findSectionIndex();
			const api = fullPageInstance as unknown as {
				silentMoveTo?: (n: number) => void;
				moveTo?: (n: number) => void;
			} | null;

			if (targetIndex >= 0 && api) {
				(api.silentMoveTo ?? api.moveTo)?.(targetIndex + 1);
			}

			requestAnimationFrame(reveal);
		});
	};

	document.addEventListener('fullpage:afterRender', onAfterRender);
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init();
}
