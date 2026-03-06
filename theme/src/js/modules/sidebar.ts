import { SidebarElement } from 'sidebarjs/lib/umd/sidebarjs';
import { fullPageInstance } from '@/js/modules/fullpage';

let sidebarJS: InstanceType<typeof SidebarElement> | null = null;

export const closeSidebar = function (): void {
	if (sidebarJS && sidebarJS.isVisible()) {
		sidebarJS.close();
		document.body.classList.remove('sidenav-active');

		const backdrop = document.querySelector('.custom-sidebar-backdrop');
		if (backdrop) {
			backdrop.classList.remove('active');
			setTimeout(() => backdrop.remove(), 200);
		}
	}
};

if (document.querySelector('[sidebarjs]')) {
	sidebarJS = new SidebarElement({
		backdropOpacity: 0.5,
		nativeSwipe: false,
		position: 'right',
	});

	const openSidebar = function (): void {
		if (!sidebarJS?.isVisible()) {
			sidebarJS?.open();

			document.body.classList.add('sidenav-active');

			const sidebarjsBackdrop = document.querySelector('[sidebarjs-backdrop]');
			if (sidebarjsBackdrop) {
				sidebarjsBackdrop.insertAdjacentHTML('beforebegin', '<div class="custom-sidebar-backdrop"></div>');
			}

			const backdrop = document.querySelector('.custom-sidebar-backdrop');

			if (backdrop) {
				setTimeout(() => backdrop.classList.add('active'), 100);

				backdrop.addEventListener('click', () => closeSidebar());

				let backdropTouchStartX = 0;

				(backdrop as HTMLElement).addEventListener('touchstart', function (e: TouchEvent) {
					backdropTouchStartX = e.touches[0].clientX;
				});

				(backdrop as HTMLElement).addEventListener('touchend', function (e: TouchEvent) {
					const deltaX = e.changedTouches[0].clientX - backdropTouchStartX;
					if (deltaX > 50) {
						closeSidebar();
					}
				});
			}
		}
	};

	document.querySelectorAll('.mobile-nav-clicker').forEach(el => {
		el.addEventListener('click', function () {
			if (sidebarJS?.isVisible()) {
				closeSidebar();
			} else {
				openSidebar();
			}
		});
	});

    let resizeTimer: ReturnType<typeof setTimeout> | null = null;
    window.addEventListener('resize', function() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(closeSidebar, 75);
    });

    window.addEventListener('scroll', function() {
        closeSidebar();
    });

    document.addEventListener('wheel', function(e: WheelEvent) {
        if (sidebarJS && sidebarJS.isVisible()) {
            closeSidebar();
            if (fullPageInstance) {
                if (e.deltaY > 0) {
                    fullPageInstance.moveSectionDown();
                } else if (e.deltaY < 0) {
                    fullPageInstance.moveSectionUp();
                }
            }
        }
    }, { passive: true });

    let touchStartY: number | null = null;
    document.addEventListener('touchstart', function(e: TouchEvent) {
        if (sidebarJS && sidebarJS.isVisible()) {
            touchStartY = e.touches[0].clientY;
        }
    }, { passive: true });

    document.addEventListener('touchmove', function(e: TouchEvent) {
        if (touchStartY !== null && sidebarJS && sidebarJS.isVisible()) {
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
    }, { passive: true });
}

const syncNavHeight = () => {
    const nav = document.querySelector('.sidebar-wrapper-mobile .main-navigation');
    const clicker = document.querySelector('.mobile-nav-clicker');
    if (nav instanceof HTMLElement && clicker instanceof HTMLElement) {
        clicker.style.height = nav.offsetHeight + 'px';
    }
};

let navResizeTimer: ReturnType<typeof setTimeout> | null = null;
window.addEventListener('load', syncNavHeight);

window.addEventListener('resize', function() {
    if (navResizeTimer) clearTimeout(navResizeTimer);
    navResizeTimer = setTimeout(syncNavHeight, 75);
});
