/**
 * Lightweight collapse component replacing Bootstrap's collapse.
 * Fires native CustomEvents so existing listeners (fullpage.js) keep working.
 */

const TRANSITION_DURATION = 350;

function dispatch(element: HTMLElement, eventName: string): void {
	element.dispatchEvent(new CustomEvent(eventName, { bubbles: true }));
}

function getLineHeight(el: HTMLElement): number {
	const styles = getComputedStyle(el);
	const parsed = Number.parseFloat(styles.lineHeight);
	return Number.isNaN(parsed) ? Number.parseFloat(styles.fontSize) * 1.4 : parsed;
}

function getCollapseHeight(target: HTMLElement): string {
	const lines = target.dataset.collapseLines;
	if (!lines) return '0';
	const targetLines = Number.parseInt(lines);

	const paragraphs = target.querySelectorAll<HTMLElement>('p');
	if (paragraphs.length === 0) {
		return `${targetLines * getLineHeight(target)}px`;
	}

	let linesRemaining = targetLines;
	let height = 0;

	for (const p of paragraphs) {
		const lineHeight = getLineHeight(p);
		const marginTop = Number.parseFloat(getComputedStyle(p).marginTop) || 0;
		const marginBottom = Number.parseFloat(getComputedStyle(p).marginBottom) || 0;
		const pLines = Math.ceil(p.scrollHeight / lineHeight);

		if (pLines >= linesRemaining) {
			height += marginTop + linesRemaining * lineHeight;
			break;
		}

		height += marginTop + p.scrollHeight + marginBottom;
		linesRemaining -= pLines;
	}

	return `${height}px`;
}

function show(target: HTMLElement): void {
	if (target.classList.contains('show') || target.classList.contains('collapsing')) return;

	dispatch(target, 'show.bs.collapse');

	const collapseHeight = getCollapseHeight(target);

	// Start at collapsed height with transition enabled
	target.classList.remove('collapse');
	target.classList.add('collapsing');
	target.style.height = collapseHeight;

	// Force reflow so the browser registers the starting height
	target.offsetHeight;

	// Transition to full height
	target.style.height = `${target.scrollHeight}px`;

	setTimeout(() => {
		target.classList.remove('collapsing');
		target.classList.add('collapse', 'show');
		target.style.height = '';
		dispatch(target, 'shown.bs.collapse');
	}, TRANSITION_DURATION);
}

function hide(target: HTMLElement): void {
	if (!target.classList.contains('show') || target.classList.contains('collapsing')) return;

	dispatch(target, 'hide.bs.collapse');

	const collapseHeight = getCollapseHeight(target);

	// Set explicit height so transition has a starting value
	target.style.height = `${target.scrollHeight}px`;

	// Force reflow
	target.offsetHeight;

	// Transition to collapsed height (0 for normal, preset height for text accordions)
	target.classList.remove('collapse', 'show');
	target.classList.add('collapsing');
	target.style.height = collapseHeight;

	setTimeout(() => {
		target.classList.remove('collapsing');
		target.classList.add('collapse');
		target.style.height = target.dataset.collapseLines ? collapseHeight : '';
		dispatch(target, 'hidden.bs.collapse');
	}, TRANSITION_DURATION);
}

function toggle(target: HTMLElement): void {
	if (target.classList.contains('show')) {
		hide(target);
	} else {
		show(target);
	}
}

function handleCollapseTrigger(trigger: HTMLElement): void {
	const targetSelector = trigger.dataset.target || trigger.getAttribute('href');
	if (!targetSelector) return;
	const target = document.querySelector<HTMLElement>(targetSelector);

	if (!target) return;

	// Accordion: close siblings within the same parent
	const parentSelector = target.dataset.parent;
	if (parentSelector) {
		const parent = target.closest(parentSelector);
		if (parent) {
			parent.querySelectorAll<HTMLElement>('.collapse.show').forEach((sibling) => {
				if (sibling === target) return;
				hide(sibling);
				// Update the trigger's collapsed state
				const id = sibling.id;
				if (id) {
					document.querySelectorAll<HTMLElement>(`[data-target="#${id}"], [href="#${id}"]`).forEach((t) => {
						t.classList.add('collapsed');
						t.setAttribute('aria-expanded', 'false');
					});
				}
			});
		}
	}

	// Toggle collapsed class on trigger
	const isExpanding = !target.classList.contains('show');
	trigger.classList.toggle('collapsed', !isExpanding);
	trigger.setAttribute('aria-expanded', isExpanding ? 'true' : 'false');

	toggle(target);
}

// Track touch start position to distinguish taps from scrolls
let touchStartX = 0;
let touchStartY = 0;

document.addEventListener(
	'touchstart',
	(e: TouchEvent) => {
		touchStartX = e.touches[0].clientX;
		touchStartY = e.touches[0].clientY;
	},
	{ passive: true },
);

// iOS Safari does not reliably fire click events on non-interactive elements
// (divs) inside iScroll/scrollOverflow containers. Handle touchend as a tap.
document.addEventListener(
	'touchend',
	(e: TouchEvent) => {
		const touch = e.changedTouches[0];
		if (Math.abs(touch.clientX - touchStartX) > 10 || Math.abs(touch.clientY - touchStartY) > 10) return;

		const trigger = (e.target as HTMLElement).closest<HTMLElement>('[data-toggle="collapse"]');
		if (!trigger) return;

		// Prevent the subsequent synthetic click event from double-firing
		e.preventDefault();

		handleCollapseTrigger(trigger);
	},
	{ passive: false },
);

// Handle click on [data-toggle="collapse"] (non-touch devices)
document.addEventListener('click', (e: MouseEvent) => {
	const trigger = (e.target as HTMLElement).closest<HTMLElement>('[data-toggle="collapse"]');
	if (!trigger) return;

	e.preventDefault();

	handleCollapseTrigger(trigger);
});

// Set collapsed height for text accordions based on line count
function updateCollapseHeights(): void {
	document.querySelectorAll<HTMLElement>('[data-collapse-lines]').forEach((el) => {
		if (!el.classList.contains('show') && !el.classList.contains('collapsing')) {
			el.style.height = getCollapseHeight(el);
		}
	});
}

updateCollapseHeights();
window.addEventListener('resize', updateCollapseHeights);
