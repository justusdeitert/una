// Importing now the ES2015 Version of sidebarjs to work on ie11
// Bedrock Sage makes trouble with buble converting to es2015
import {SidebarElement} from 'sidebarjs/lib/umd/sidebarjs';

window.sidebarinstance = {};


if ($('[sidebarjs]').length > 0) {
    // Init SidebarJS

    window.sidebarinstance.sidebarjs = new SidebarElement({
        onOpen: function () {
            // console.log('sidebarjs is open');
            // $('html').addClass('sidenav-active');
            // $('.burger-menu-icon').addClass('icon-close');
        },
        onClose: function () {
            // console.log('sidebarjs is close');
            // $('html').removeClass('sidenav-active');
            // $('.burger-menu-icon').removeClass('icon-close');
            // $('[sidebarjs-backdrop]').prepend( "<p>Test</p>" )
        },
        onChangeVisibility: function (changes) {
            // console.log('sidebarjs is visible?', changes.isVisible);
        },
        backdropOpacity: 0.5,
        nativeSwipe: false,
        position: 'right',
    });

    const sidebarJS = window.sidebarinstance.sidebarjs;


    window.sidebarinstance.closeSidebar = function() {
        if (sidebarJS.isVisible()) {
            sidebarJS.close();
            $('body').removeClass('sidenav-active');


            let sidebarBackdrop = $('.sidebar-backdrop');

            $(sidebarBackdrop).removeClass('active');

            setTimeout(() => {
                $(sidebarBackdrop).remove();
            }, 200);
        }
    };

    const closeSidebar = window.sidebarinstance.closeSidebar;

    const openSidebar = function() {
        if (!sidebarJS.isVisible()) {
            sidebarJS.open();

            $('body').addClass('sidenav-active');

            $('[sidebarjs-backdrop]').before('<div class="sidebar-backdrop"></div>');

            let sidebarBackdrop = $('.sidebar-backdrop');

            setTimeout(() => {
                $(sidebarBackdrop).addClass('active');
            }, 100);

            $(sidebarBackdrop).click(function() {
                closeSidebar();
            });

            $(sidebarBackdrop).swipe({
                // Generic swipe handler for all directions
                swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
                    // console.log("You swiped " + direction );

                    if (direction === 'right') {
                        closeSidebar();
                    }
                }
            });
        }
    };

    $('.wrap, .mobile-nav-clicker').swipe({
        // Generic swipe handler for all directions
        swipe:function(event, direction, distance, duration, fingerCount, fingerData) {
            // console.log("You swiped " + direction );

            if (direction === 'left') {
                openSidebar();
            }

            if (direction === 'right') {
                closeSidebar();
            }
        }
    });

    $('.mobile-nav-clicker').click(function() {
        if (sidebarJS.isVisible()) {
            closeSidebar();
        } else {
            openSidebar();
        }
    });

    // $('.sidenav-close-icon').click(function() {
    //     closeSidebar();
    // });

    // Close on Resize
    $( window ).resize(function() {
        closeSidebar();
    });

    // Close on Resize
    $( window ).scroll(function() {
        closeSidebar();
    });
}

// console.log($('.sidebar-wrapper .main-navigation').outerHeight());

$(window).load(() => {
    // console.log($('.sidebar-wrapper .main-navigation').height());
    $('.mobile-nav-clicker').height($('.sidebar-wrapper-mobile .main-navigation').height());
});

$(window).resize(() => {
    // console.log($('.sidebar-wrapper .main-navigation').height());
    $('.mobile-nav-clicker').height($('.sidebar-wrapper-mobile .main-navigation').height());
});
