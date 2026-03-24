import { fullPageInstance } from '@/ts/modules/fullpage';

const sidebarEl = document.querySelector<HTMLElement>('.sidebar-nav');
let isOpen = false;

export const closeSidebar = (): void => {
	if (!isOpen) return;
	isOpen = false;
	sidebarEl?.classList.remove('sidebar-open');
	document.body.classList.remove('sidenav-active');

	const backdrop = document.querySelector('.custom-sidebar-backdrop');
	if (backdrop) {
		backdrop.classList.remove('active');
		setTimeout(() => backdrop.remove(), 200);
	}
};

if (sidebarEl) {
	const openSidebar = (): void => {
		if (isOpen) return;
		isOpen = true;
		sidebarEl.classList.add('sidebar-open');
		document.body.classList.add('sidenav-active');

		sidebarEl.insertAdjacentHTML('beforebegin', '<div class="custom-sidebar-backdrop"></div>');

		const backdrop = document.querySelector('.custom-sidebar-backdrop');

		if (backdrop) {
			setTimeout(() => backdrop.classList.add('active'), 100);

			backdrop.addEventListener('click', () => closeSidebar());

			let backdropTouchStartX = 0;

			(backdrop as HTMLElement).addEventListener('touchstart', (e: TouchEvent) => {
				backdropTouchStartX = e.touches[0].clientX;
			});

			(backdrop as HTMLElement).addEventListener('touchend', (e: TouchEvent) => {
				const deltaX = e.changedTouches[0].clientX - backdropTouchStartX;
				if (deltaX > 50) {
					closeSidebar();
				}
			});
		}
	};

	document.querySelectorAll('.mobile-nav-clicker').forEach((el) => {
		el.addEventListener('click', () => {
			if (isOpen) {
				closeSidebar();
			} else {
				openSidebar();
			}
		});
	});

	let resizeTimer: ReturnType<typeof setTimeout> | null = null;
	window.addEventListener('resize', () => {
		if (resizeTimer) clearTimeout(resizeTimer);
		resizeTimer = setTimeout(closeSidebar, 75);
	});

	window.addEventListener('scroll', () => {
		closeSidebar();
	});

	document.addEventListener('keydown', (e: KeyboardEvent) => {
		if (e.key === 'Escape') closeSidebar();
	});

	document.addEventListener(
		'wheel',
		(e: WheelEvent) => {
			if (isOpen) {
				closeSidebar();
				if (fullPageInstance) {
					if (e.deltaY > 0) {
						fullPageInstance.moveSectionDown();
					} else if (e.deltaY < 0) {
						fullPageInstance.moveSectionUp();
					}
				}
			}
		},
		{ passive: true },
	);

	let touchStartY: number | null = null;
	document.addEventListener(
		'touchstart',
		(e: TouchEvent) => {
			if (isOpen) {
				touchStartY = e.touches[0].clientY;
			}
		},
		{ passive: true },
	);

	document.addEventListener(
		'touchmove',
		(e: TouchEvent) => {
			if (touchStartY && isOpen) {
				const deltaY = e.touches[0].clientY - touchStartY;
				if (Math.abs(deltaY) > 10) {
					touchStartY = null;
					closeSidebar();
					if (fullPageInstance) {
						if (deltaY < 0) {
							fullPageInstance.moveSectionDown();
						} else {
							fullPageInstance.moveSectionUp();
						}
					}
				}
			}
		},
		{ passive: true },
	);
}
