import { SidebarElement } from 'sidebarjs/lib/umd/sidebarjs';
import { fullPageInstance } from '@/js/modules/fullpage';

let sidebarJS = null;

export const closeSidebar = function () {
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

	const openSidebar = function () {
		if (!sidebarJS.isVisible()) {
			sidebarJS.open();

			document.body.classList.add('sidenav-active');

			const sidebarjsBackdrop = document.querySelector('[sidebarjs-backdrop]');
			if (sidebarjsBackdrop) {
				sidebarjsBackdrop.insertAdjacentHTML('beforebegin', '<div class="custom-sidebar-backdrop"></div>');
			}

			const backdrop = document.querySelector('.custom-sidebar-backdrop');

			if (backdrop) {
				setTimeout(() => backdrop.classList.add('active'), 100);

				backdrop.addEventListener('click', () => closeSidebar());

				backdrop.addEventListener('touchstart', function (e) {
					this._touchStartX = e.touches[0].clientX;
				});

				backdrop.addEventListener('touchend', function (e) {
					const deltaX = e.changedTouches[0].clientX - this._touchStartX;
					if (deltaX > 50) {
						closeSidebar();
					}
				});
			}
		}
	};

	document.querySelectorAll('.mobile-nav-clicker').forEach(el => {
		el.addEventListener('click', function () {
			if (sidebarJS.isVisible()) {
				closeSidebar();
			} else {
				openSidebar();
			}
		});
	});

    let resizeTimer = null;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(closeSidebar, 75);
    });

    window.addEventListener('scroll', function() {
        closeSidebar();
    });

    document.addEventListener('wheel', function(e) {
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

    let touchStartY = null;
    document.addEventListener('touchstart', function(e) {
        if (sidebarJS && sidebarJS.isVisible()) {
            touchStartY = e.touches[0].clientY;
        }
    }, { passive: true });

    document.addEventListener('touchmove', function(e) {
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
    if (nav && clicker) {
        clicker.style.height = nav.offsetHeight + 'px';
    }
};

let navResizeTimer = null;
window.addEventListener('load', syncNavHeight);

window.addEventListener('resize', function() {
    clearTimeout(navResizeTimer);
    navResizeTimer = setTimeout(syncNavHeight, 75);
});
