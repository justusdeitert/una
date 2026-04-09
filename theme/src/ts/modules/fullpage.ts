import 'fullpage.js/vendors/scrolloverflow';
import fullpage from 'fullpage.js/dist/fullpage';
import { closeSidebar } from '@/ts/modules/sidebar';
import { closeLightboxInstant, isLightboxOpen } from '@/ts/modules/photoswipe';
import { initParallax, onSectionLeave } from '@/ts/modules/parallax';

const BREAKPOINT_MD = 859.98;
const BACK_TO_TOP_MIN_DURATION = 1400;
const BACK_TO_TOP_MAX_DURATION = 2200;
const BACK_TO_TOP_PX_PER_MS = 1.2;
const BACK_TO_TOP_EASING = 'cubic-bezier(0.22, 1, 0.36, 1)';
const DEFAULT_SCROLLING_SPEED = 700;
const INNER_SCROLL_THRESHOLD = 150;

const getSelectorOnWindowSize = (): string => {
	const isMobile = window.innerWidth < window.innerHeight || window.innerWidth < BREAKPOINT_MD;

	document.body.classList.toggle('is-mobile', isMobile);
	document.body.classList.toggle('is-desktop', !isMobile);

	return isMobile ? '.section-mobile' : '.section-desktop';
};

export let fullPageInstance: fullpage | null = null;

const updateNavClasses = (): void => {
	setTimeout(() => {
		const fpNav = document.getElementById('fp-nav');
		if (fpNav) fpNav.classList.add('is-visible');
	}, 300);

	document.querySelectorAll('#fp-nav li').forEach((li) => {
		li.classList.remove('prev', 'next', 'visible');
	});

	const activeLink = document.querySelector('#fp-nav a.active');
	if (activeLink) {
		const li = activeLink.closest('li');
		if (li) {
			li.classList.add('visible');
			const prev = li.previousElementSibling;
			const next = li.nextElementSibling;
			if (prev) {
				prev.classList.add('prev');
				if (prev.previousElementSibling) prev.previousElementSibling.classList.add('prev');
			}
			if (next) {
				next.classList.add('next');
				if (next.nextElementSibling) next.nextElementSibling.classList.add('next');
			}
		}
	}
};

const rebuildAfterImages = (): void => {
	const section = document.querySelector('.fp-section.active');
	if (!section) return;

	const images = section.querySelectorAll<HTMLImageElement>('img');
	if (images.length === 0) return;

	const pending = Array.from(images).filter((img) => !img.complete);
	if (pending.length === 0) return;

	let remaining = pending.length;
	const onDone = (): void => {
		remaining--;
		if (remaining <= 0) {
			fullPageInstance?.reBuild();
		}
	};

	for (const img of pending) {
		img.addEventListener('load', onDone, { once: true });
		img.addEventListener('error', onDone, { once: true });
	}
};

const afterLoad = (): void => {
	updateNavClasses();

	document.querySelectorAll('.fp-tableCell').forEach((cell) => {
		cell.classList.toggle('vertical-top', cell.querySelector('.content-container') !== null);
	});

	rebuildAfterImages();
	observeActiveScroller();
};

const initFullPageInstance = (): fullpage => {
	fullPageInstance = new fullpage('#fullpage', {
		navigation: true,
		navigationPosition: 'left',
		responsiveHeight: 0,
		scrollOverflow: true,
		scrollOverflowOptions: {
			preventDefault: false,
		},
		sectionSelector: getSelectorOnWindowSize(),
		licenseKey: window.themeConfig?.fullpageLicenseKey || '',
		lazyLoading: true,
		afterLoad: afterLoad,
		afterRender: () => {
			updateNavClasses();
			rebuildAfterImages();
			initParallax();
			observeActiveScroller();
		},
		onLeave: (origin, destination, direction) => {
			if (isLightboxOpen()) {
				closeLightboxInstant();
			}

			closeSidebar();

			document.body.classList.toggle('last-section', destination.index >= 1);

			onSectionLeave(
				(origin as { index: number }).index,
				(destination as { index: number }).index,
				direction as 'up' | 'down',
			);
		},
	});
	return fullPageInstance;
};

const reinitFullPage = (): void => {
	setTimeout(() => {
		fullPageInstance?.destroy('all');
		initFullPageInstance();
	}, 200);
};

window.addEventListener('load', () => {
	initFullPageInstance();
});

let scrollerPosition = 0;
let activeScrollerObserver: MutationObserver | null = null;

const getActiveScroller = (): HTMLElement | null => document.querySelector('.fp-section.active .fp-scroller');

const getScrollerY = (scroller: HTMLElement): number => {
	const match = scroller.style.transform.match(/translate\(?\s*-?\d+(?:\.\d+)?(?:px)?\s*,\s*(-?\d+(?:\.\d+)?)(?:px)?/);
	return match ? parseFloat(match[1]) : 0;
};

const updateScrolledState = (): void => {
	const scroller = getActiveScroller();
	const scrolled = scroller ? getScrollerY(scroller) < -INNER_SCROLL_THRESHOLD : false;
	document.body.classList.toggle('scrolled-in-section', scrolled);
};

const observeActiveScroller = (): void => {
	activeScrollerObserver?.disconnect();
	activeScrollerObserver = null;
	const scroller = getActiveScroller();
	if (!scroller) {
		updateScrolledState();
		return;
	}
	activeScrollerObserver = new MutationObserver(updateScrolledState);
	activeScrollerObserver.observe(scroller, { attributes: true, attributeFilter: ['style'] });
	updateScrolledState();
};

document.querySelectorAll('.accordion').forEach((el) => {
	el.addEventListener('shown.bs.collapse', () => {
		const scroller = getActiveScroller();
		if (scroller) scroller.classList.remove('slide-up');
		reinitFullPage();
	});

	el.addEventListener('hide.bs.collapse', () => {
		const scroller = getActiveScroller();
		if (scroller) {
			scroller.style.transform = 'translate(0px, 0px)';
			scroller.classList.add('slide-up');
		}
	});

	el.addEventListener('hidden.bs.collapse', () => {
		const scroller = getActiveScroller();
		if (scroller) scroller.classList.remove('slide-up');
		reinitFullPage();
	});
});

document.querySelectorAll('.text-container-accordion .collapse').forEach((el) => {
	el.addEventListener('show.bs.collapse', () => {
		const scroller = getActiveScroller();
		if (scroller) {
			scrollerPosition = scroller.offsetTop;
		}
	});

	el.addEventListener('shown.bs.collapse', () => {
		fullPageInstance?.reBuild();
	});

	el.addEventListener('hide.bs.collapse', () => {
		const scroller = getActiveScroller();
		if (scroller) {
			scroller.style.transform = `translate(0px, ${scrollerPosition}px)`;
			scroller.classList.add('slide-up');
		}
	});

	el.addEventListener('hidden.bs.collapse', () => {
		const scroller = getActiveScroller();
		if (scroller) scroller.classList.remove('slide-up');
		setTimeout(() => {
			fullPageInstance?.reBuild();
		}, 200);
	});
});

const getActiveSectionIndex = (): number => {
	const active = document.querySelector('.fp-section.active');
	const sections = active?.parentElement?.querySelectorAll('.fp-section');
	return active && sections ? Array.from(sections).indexOf(active) : 0;
};

const clampDuration = (distance: number): number =>
	Math.min(BACK_TO_TOP_MAX_DURATION, Math.max(BACK_TO_TOP_MIN_DURATION, distance / BACK_TO_TOP_PX_PER_MS));

document.querySelectorAll('.back-to-top').forEach((el) => {
	el.addEventListener('click', () => {
		const scroller = getActiveScroller();
		const sectionIndex = getActiveSectionIndex();
		const innerDistance = scroller ? Math.abs(getScrollerY(scroller)) : 0;
		const totalDistance = innerDistance + sectionIndex * window.innerHeight;

		if (totalDistance === 0) return;

		const duration = clampDuration(totalDistance);

		if (scroller && innerDistance > 0) {
			activeScrollerObserver?.disconnect();
			scroller.style.transition = `transform ${duration}ms ${BACK_TO_TOP_EASING}`;
			scroller.style.transform = 'translate(0px, 0px)';
			document.body.classList.remove('scrolled-in-section');
			setTimeout(() => {
				scroller.style.transition = '';
				fullPageInstance?.reBuild();
				observeActiveScroller();
			}, duration + 50);
		}

		if (sectionIndex > 0) {
			fullPageInstance?.setScrollingSpeed(duration);
			fullPageInstance?.moveTo(1);
			setTimeout(() => fullPageInstance?.setScrollingSpeed(DEFAULT_SCROLLING_SPEED), duration + 100);
		}
	});
});

let resizeTimer: ReturnType<typeof setTimeout> | null = null;
window.addEventListener('resize', () => {
	if (resizeTimer) clearTimeout(resizeTimer);
	resizeTimer = setTimeout(() => {
		if (!fullPageInstance) return;
		const sectionSelector = fullPageInstance.getFullpageData().sectionSelector;
		const shouldBeMobile = window.innerWidth < window.innerHeight || window.innerWidth < BREAKPOINT_MD;
		const isMobile = sectionSelector === '.section-mobile';

		if (shouldBeMobile !== isMobile) {
			fullPageInstance.destroy('all');
			initFullPageInstance();
		}
	}, 75);
});
