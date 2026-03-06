import 'fullpage.js/vendors/scrolloverflow';
import fullpage from 'fullpage.js/dist/fullpage';
import { closeSidebar } from '@/js/modules/sidebar';
import { closeLightboxFade, isLightboxOpen } from '@/js/modules/smart-photo';

const BREAKPOINT_MD = 859.98;

let resizeTimer: ReturnType<typeof setTimeout> | null = null;

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

const afterLoad = (): void => {
	updateNavClasses();

	document.querySelectorAll('.fp-tableCell').forEach((cell) => {
		cell.classList.toggle('vertical-top', cell.querySelector('.content-container') !== null);
	});
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
		afterRender: updateNavClasses,
		onLeave: (_origin, destination, _direction) => {
			if (isLightboxOpen()) {
				closeLightboxFade();
			}

			closeSidebar();

			document.body.classList.toggle('last-section', destination.index >= 1);
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

const getActiveScroller = (): HTMLElement | null => document.querySelector('.fp-section.active .fp-scroller');

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

document.querySelectorAll('.back-to-top').forEach((el) => {
	el.addEventListener('click', () => {
		fullPageInstance?.moveTo(1);
	});
});

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
