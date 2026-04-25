/**
 * Performance subpage section restore.
 *
 * Performance pages render via `single-performance.php` as standalone
 * pages. Their close link carries a `#from_performance=<slug>` hash so
 * we can scroll the fullpage.js layout back to the section that
 * contains the originating link when the user lands on that page.
 */

import { fullPageInstance } from '@/ts/modules/fullpage';

const PARAM = 'from_performance';
const HIDE_CLASS = 'performance-restoring';

type FullpageApi = {
	silentMoveTo?: (n: number) => void;
	moveTo?: (n: number) => void;
} | null;

type Source = 'query' | 'hash';

// Returns the slug from either the query string or the hash, plus the
// source so we can clean it up afterwards.
function readSlug(): { slug: string; source: Source } | null {
	const query = new URLSearchParams(window.location.search).get(PARAM);
	if (query) return { slug: query, source: 'query' };

	const hash = new URLSearchParams(window.location.hash.replace(/^#/, '')).get(PARAM);
	if (hash) return { slug: hash, source: 'hash' };

	return null;
}

// Hide the page as early as possible (before fullpage builds) so we
// never paint the wrong section on the way to the right one.
if (typeof document !== 'undefined' && readSlug()) {
	document.documentElement.classList.add(HIDE_CLASS);
}

function stripParam(source: Source) {
	const { pathname, search, hash } = window.location;
	let nextSearch = search;
	let nextHash = hash;

	if (source === 'query') {
		const params = new URLSearchParams(search);
		params.delete(PARAM);
		const str = params.toString();
		nextSearch = str ? `?${str}` : '';
	} else {
		nextHash = '';
	}

	window.history.replaceState(window.history.state, '', pathname + nextSearch + nextHash);
}

function findSectionIndex(slug: string): number {
	const target = `/performance/${slug}`;
	const sections = Array.from(document.querySelectorAll<HTMLElement>('.fp-section'));

	for (const anchor of document.querySelectorAll<HTMLAnchorElement>('a[href]')) {
		let path: string;
		try {
			path = new URL(anchor.href, window.location.origin).pathname.replace(/\/$/, '');
		} catch {
			continue;
		}
		if (path !== target) continue;

		const section = anchor.closest<HTMLElement>('.fp-section');
		const index = section ? sections.indexOf(section) : -1;
		if (index >= 0) return index;
	}

	return -1;
}

function reveal() {
	document.documentElement.classList.remove(HIDE_CLASS);
}

function restore(slug: string) {
	const onAfterRender = () => {
		document.removeEventListener('fullpage:afterRender', onAfterRender);

		// fullPageInstance is assigned after the constructor returns,
		// but afterRender fires from inside it, so defer one frame.
		requestAnimationFrame(() => {
			const index = findSectionIndex(slug);
			const api = fullPageInstance as FullpageApi;
			if (index >= 0 && api) {
				(api.silentMoveTo ?? api.moveTo)?.(index + 1);
			}
			requestAnimationFrame(reveal);
		});
	};

	document.addEventListener('fullpage:afterRender', onAfterRender);
}

function init() {
	// Standalone single-performance pages do not host fullpage.js.
	if (document.body.classList.contains('performance-standalone')) return;

	const found = readSlug();
	if (!found) return;

	stripParam(found.source);
	restore(found.slug);
}

if (document.readyState === 'loading') {
	document.addEventListener('DOMContentLoaded', init);
} else {
	init();
}
