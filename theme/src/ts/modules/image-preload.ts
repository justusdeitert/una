// Replaces fullpage.js' built-in lazyLoading. fullpage only preloads
// immediate neighbour sections, so on slow connections the image of
// the just-revealed section finishes decoding after the section is
// already visible.
//
// Strategy:
// - Images render with real `src` / `srcset` and `loading="lazy"`.
// - `IntersectionObserver` with a 200% root margin picks up images
//   two viewports ahead in either direction and calls `decode()` to
//   pre-decode them before the section becomes active.
// - The first section's images get `fetchpriority="high"` and lose
//   `loading="lazy"` so they start downloading immediately on page
//   load (LCP).

const PRELOAD_MARGIN = '200% 0%';

const preloaded = new WeakSet<HTMLImageElement>();

const preload = (img: HTMLImageElement): void => {
	if (preloaded.has(img)) return;
	preloaded.add(img);

	// Drop loading="lazy" so the browser fetches even if the image is
	// still outside its native lazy-load threshold. decode() triggers
	// the actual fetch + decode.
	if (img.loading === 'lazy') img.loading = 'eager';

	img.decode().catch(() => {
		// Ignore decode failures (broken images, aborted loads).
	});
};

const observer =
	'IntersectionObserver' in window
		? new IntersectionObserver(
				(entries) => {
					for (const entry of entries) {
						if (entry.isIntersecting) {
							preload(entry.target as HTMLImageElement);
							observer?.unobserve(entry.target);
						}
					}
				},
				{ rootMargin: PRELOAD_MARGIN },
			)
		: null;

const prioritiseFirstSection = (): void => {
	const firstSection = document.querySelector<HTMLElement>('.fp-section');
	if (!firstSection) return;
	firstSection.querySelectorAll<HTMLImageElement>('img').forEach((img) => {
		img.setAttribute('fetchpriority', 'high');
		img.loading = 'eager';
		preloaded.add(img);
	});
};

const observeAll = (): void => {
	if (!observer) return;
	document.querySelectorAll<HTMLImageElement>('.fp-section img').forEach((img) => {
		if (preloaded.has(img)) return;
		observer.observe(img);
	});
};

document.addEventListener('fullpage:afterRender', () => {
	prioritiseFirstSection();
	observeAll();
});
