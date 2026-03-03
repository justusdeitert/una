import $ from 'jquery';
import { SidebarElement } from 'sidebarjs/lib/umd/sidebarjs';

window.sidebarinstance = {};

if ($('[sidebarjs]').length > 0) {
	window.sidebarinstance.sidebarjs = new SidebarElement({
		onOpen: function () {
			// console.log('sidebarjs onOpen');
		},
		onClose: function () {
			// console.log('sidebarjs onClose');
		},
		onChangeVisibility: function (changes) {
			// console.log('sidebarjs onChangeVisibility');
		},
		backdropOpacity: 0.5,
		nativeSwipe: false,
		position: 'right',
	});

	const sidebarJS = window.sidebarinstance.sidebarjs;

	window.sidebarinstance.closeSidebar = function () {
		if (sidebarJS.isVisible()) {
			sidebarJS.close();
			$('body').removeClass('sidenav-active');

			let sidebarBackdrop = $('.custom-sidebar-backdrop');

			$(sidebarBackdrop).removeClass('active');

			setTimeout(() => {
				$(sidebarBackdrop).remove();
			}, 200);
		}
	};

	const closeSidebar = window.sidebarinstance.closeSidebar;

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

    $(window).on('resize', function() {
        closeSidebar();
    });

    $(window).on('scroll', function() {
        closeSidebar();
    });
}

$(window).on('load', function() {
    $('.mobile-nav-clicker').height($('.sidebar-wrapper-mobile .main-navigation').height());
});

$(window).on('resize', function() {
    $('.mobile-nav-clicker').height($('.sidebar-wrapper-mobile .main-navigation').height());
});