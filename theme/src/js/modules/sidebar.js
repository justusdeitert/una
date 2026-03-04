import $ from 'jquery';
import { SidebarElement } from 'sidebarjs/lib/umd/sidebarjs';

let sidebarJS = null;

export const closeSidebar = function () {
	if (sidebarJS && sidebarJS.isVisible()) {
		sidebarJS.close();
		$('body').removeClass('sidenav-active');

		let sidebarBackdrop = $('.custom-sidebar-backdrop');
		$(sidebarBackdrop).removeClass('active');

		setTimeout(() => {
			$(sidebarBackdrop).remove();
		}, 200);
	}
};

if ($('[sidebarjs]').length > 0) {
	sidebarJS = new SidebarElement({
		backdropOpacity: 0.5,
		nativeSwipe: false,
		position: 'right',
	});

	const openSidebar = function () {
		if (!sidebarJS.isVisible()) {
			sidebarJS.open();

			$('body').addClass('sidenav-active');

			$('[sidebarjs-backdrop]').before('<div class="custom-sidebar-backdrop"></div>');

			let sidebarBackdrop = $('.custom-sidebar-backdrop');

			setTimeout(() => {
				$(sidebarBackdrop).addClass('active');
			}, 100);

			$(sidebarBackdrop).click(function () {
				closeSidebar();
			});

			sidebarBackdrop[0].addEventListener('touchstart', function (e) {
				this._touchStartX = e.touches[0].clientX;
			});

			sidebarBackdrop[0].addEventListener('touchend', function (e) {
				const deltaX = e.changedTouches[0].clientX - this._touchStartX;
				if (deltaX > 50) {
					closeSidebar();
				}
			});
		}
	};

	$('.mobile-nav-clicker').click(function () {
		if (sidebarJS.isVisible()) {
			closeSidebar();
		} else {
			openSidebar();
		}
	});

    let resizeTimer = null;
    $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(closeSidebar, 150);
    });

    $(window).on('scroll', function() {
        closeSidebar();
    });
}

let navResizeTimer = null;
$(window).on('load', function() {
    $('.mobile-nav-clicker').height($('.sidebar-wrapper-mobile .main-navigation').height());
});

$(window).on('resize', function() {
    clearTimeout(navResizeTimer);
    navResizeTimer = setTimeout(() => {
        $('.mobile-nav-clicker').height($('.sidebar-wrapper-mobile .main-navigation').height());
    }, 150);
});