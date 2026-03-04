import $ from 'jquery';
import 'fullpage.js/vendors/scrolloverflow';
import fullpage from 'fullpage.js/dist/fullpage';
import { smartPhoto } from '@/js/modules/smart-photo';
import { closeSidebar } from '@/js/modules/sidebar';

const BREAKPOINT_MD = 859.98;

const getSelectorOnWindowSize = () => {
	const isMobile = $(window).width() < $(window).height() || $(window).width() < BREAKPOINT_MD;

	$('body').toggleClass('is-mobile', isMobile);
	$('body').toggleClass('is-desktop', !isMobile);

	return isMobile ? '.section-mobile' : '.section-desktop';
};

export let fullPageInstance = null;

const updateNavClasses = () => {
	setTimeout(() => {
		$('#fp-nav').addClass('is-visible');
	}, 300);

	const all = $('#fp-nav li');
	all.removeClass('prev next visible');

	const li = $('#fp-nav a.active').parent('li');
	li.addClass('visible');
	li.prev().addClass('prev');
	li.next().addClass('next');
	li.prev().prev().addClass('prev');
	li.next().next().addClass('next');
};

const afterLoad = () => {
	updateNavClasses();

	$('.fp-tableCell').each(function () {
		$(this).toggleClass('vertical-top', $(this).has('.content-container').length > 0);
	});
};

const initFullPageInstance = () => {
	fullPageInstance = new fullpage('#fullpage', {
		navigation: true,
		navigationPosition: 'left',
		responsiveHeight: 0,
		scrollOverflow: true,
		scrollOverflowOptions: {
			preventDefault: false,
		},
		sectionSelector: getSelectorOnWindowSize(),
		licenseKey: 'REMOVED',
		lazyLoading: true,
		afterLoad: afterLoad,
		afterRender: updateNavClasses,
		onLeave: function (origin, destination, direction) {
			if ($('body').hasClass('smartphoto-is-open') && smartPhoto) {
				smartPhoto.hidePhoto();
			}

			closeSidebar();

			$('body').toggleClass('last-section', destination.index >= 1);
		},
	});
	return fullPageInstance;
};

const reinitFullPage = () => {
	setTimeout(() => {
		fullPageInstance.destroy('all');
		initFullPageInstance();
	}, 200);
};

$(window).on('load', function() {
	initFullPageInstance();
});

let scrollerPosition = 0;

$('.accordion').on('shown.bs.collapse', function () {
	$('.fp-section.active .fp-scroller').removeClass('slide-up');
	reinitFullPage();
});

$('.accordion').on('hide.bs.collapse', function () {
	$('.fp-section.active .fp-scroller').css({
		transform: 'translate(0px, 0px)',
	});
	$('.fp-section.active .fp-scroller').addClass('slide-up');
});

$('.accordion').on('hidden.bs.collapse', function () {
	$('.fp-section.active .fp-scroller').removeClass('slide-up');
	reinitFullPage();
});

$('.text-container-accordion .collapse').on('show.bs.collapse', function () {
	if ($('.fp-section.active .fp-scroller').position()) {
		scrollerPosition = $('.fp-section.active .fp-scroller').position().top;
	}
});

$('.text-container-accordion .collapse').on('shown.bs.collapse', function () {
	fullPageInstance.reBuild();
});

$('.text-container-accordion .collapse').on('hide.bs.collapse', function () {
	$('.fp-section.active .fp-scroller').css({
		transform: 'translate(0px, ' + scrollerPosition + 'px)',
	});
	$('.fp-section.active .fp-scroller').addClass('slide-up');
});

$('.text-container-accordion .collapse').on('hidden.bs.collapse', function () {
	$('.fp-section.active .fp-scroller').removeClass('slide-up');
	setTimeout(() => {
		fullPageInstance.reBuild();
	}, 200);
});

$('.back-to-top').click(() => {
	fullPageInstance.moveTo(1);
});

$(window).on('resize', () => {
	const sectionSelector = fullPageInstance.getFullpageData().sectionSelector;
	const shouldBeMobile = $(window).width() < $(window).height() || $(window).width() < BREAKPOINT_MD;
	const isMobile = sectionSelector === '.section-mobile';

	if (shouldBeMobile !== isMobile) {
		fullPageInstance.destroy('all');
		initFullPageInstance();
	}
});
