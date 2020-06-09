<!doctype html>
<html {!! get_language_attributes() !!}>
    @include('partials.head')
    <body @php body_class() @endphp>

    <div class="page-wrapper">
        @php do_action('get_header') @endphp
        @include('partials.header')

        <div class="wrap container" role="document">
            <div class="content">
                <main class="main">
                    <div id="fullpage">
                        @yield('content')
                    </div>
                </main>
                {{--@if (App\display_sidebar())--}}
                {{--<aside class="sidebar">--}}
                {{--@include('partials.sidebar')--}}
                {{--</aside>--}}
                {{--@endif--}}
            </div>
        </div>

        <div class="sidebar-desktop">
            @if (has_nav_menu('primary_navigation'))
                {!! wp_nav_menu([
                    'theme_location' => 'primary_navigation',
                    // 'menu_class' => 'nav',
                    'container_class' => 'main-navigation'
                ]) !!}
            @endif
        </div>

        <div class="mobile-nav-clicker d-block d-md-none"></div>

        {{--<div class="mobile-nav-burger d-block d-md-none">--}}
            {{--<i class="material-icons"></i>--}}
        {{--</div>--}}
        <div class="back-to-top colored-hover"><p>go up</p></div>

        <div sidebarjs class="sidebar-wrapper-mobile d-block d-md-none">
            @if (has_nav_menu('primary_navigation'))
                {!! wp_nav_menu([
                    'theme_location' => 'primary_navigation',
                    // 'menu_class' => 'nav',
                    'container_class' => 'main-navigation'
                ]) !!}
            @endif
        </div>
    </div>

    @php
        $current_event = new WP_Query([
            'post_type' => 'events',
            'posts_per_page' => 1
        ]);
    @endphp

    @if($current_event->post)
        @php
            $image = get_field('event_image', $current_event->post->ID);
            $text = get_field('event_text', $current_event->post->ID);
            $width = get_field('drag_and_drop_panel_width', $current_event->post->ID);
        @endphp

        <div id="draggable">
            <i class="material-icons">close</i>
            <a data-caption="{!! $image['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! $image['ID'] !!}" href="{!! $image['url'] !!}"  data-group="mobile-group-{!! $image['ID'] !!}">
                <div class="image-container">
                    <img src="{!! $image['sizes']['large'] !!}" >
                    {{--<div class="caption"><div class="span">{!! $image['caption'] !!}</div></div>--}}
                </div>
            </a>
            <div class="text-container">
                {!! $text !!}
            </div>
        </div>
        @if($width)
            <style>
                #draggable {
                    width: {!! $width !!}px !important;
                }
            </style>
        @endif
    @endif


    @php do_action('get_footer') @endphp
    {{--@include('partials.footer')--}}
    @php wp_footer() @endphp

    @php
        $link_colors = [];
        $colors = get_field('link_colors', 'option');

        if ($colors) {
            foreach ($colors as $color) {
                array_push($link_colors, $color['color']);
            }
        }
    @endphp

    <script>

        var colors = [];

        @foreach($link_colors as $color)
            colors.push('{!! $color !!}');
        @endforeach

        if(window.cookieFunctions.checkCookie()) {
            if(!window.cookieFunctions.getCookie('colors')) {
                window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
            } else {
                if (JSON.parse(window.cookieFunctions.getCookie('colors')).length < 0) {
                    window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
                }
            }
        }

        // console.log(window.cookieFunctions.checkCookie());

        if(window.cookieFunctions.checkCookie()) {
            var randColors = function() {
                return JSON.parse(window.cookieFunctions.getCookie('colors'))[Math.floor(Math.random() * JSON.parse(window.cookieFunctions.getCookie('colors')).length)];
            }
        } else {
            var randColors = function() {
                return colors[Math.floor(Math.random() * colors.length)];
            }
        }

        jQuery(document).ready(function() {
            var currentRandomColor = randColors();
            var currentMenuItem = jQuery('.current-menu-item');
            jQuery(currentMenuItem).children('a').css( 'color', currentRandomColor );
            jQuery(currentMenuItem).children('a').css( 'border-color', currentRandomColor );
        });

        var hoverElements = jQuery('.page-wrapper a:not(.current-menu-item a), #cookie-notice a, .colored-hover');

        jQuery(hoverElements).on('touchstart mouseover', function() {
            // console.log('touchsttouchstart mouseoverart');
            var currentRandomColor = randColors();
            jQuery(this).css( 'color', currentRandomColor );
            jQuery(this).children('h3, i').css( 'color', currentRandomColor );
            jQuery(this).css( 'border-color', currentRandomColor );

            if(window.cookieFunctions.checkCookie()) {
                var cookieArray = JSON.parse(window.cookieFunctions.getCookie('colors'));

                if (cookieArray.length > 1) {
                    var index = cookieArray.indexOf(currentRandomColor);

                    if (index > -1) {
                        cookieArray.splice(index, 1);
                    }

                    window.cookieFunctions.setCookie('colors', JSON.stringify(cookieArray));
                } else {
                    window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
                }
            }
        });

        jQuery(hoverElements).on('touchend mouseout', function() {
            // console.log('touchend mouseout');
            jQuery(this).css( 'color', '' );
            jQuery(this).children('h3, i').css( 'color', '' );
            jQuery(this).css( 'border-color', '' );
            jQuery(this).children('h3, i').css( 'border-color', '' );
        });

        jQuery('.image-wrapper').on('touchstart mouseover', function() {
            // console.log('touchstart mouseover');
            var currentRandomColor = randColors();
            jQuery(this).addClass('active');
            jQuery(this).find('.hover-overlay').css( 'background-color', currentRandomColor );

            if(window.cookieFunctions.checkCookie()) {
                var cookieArray = JSON.parse(window.cookieFunctions.getCookie('colors'));

                if (cookieArray.length > 1) {
                    var index = cookieArray.indexOf(currentRandomColor);

                    if (index > -1) {
                        cookieArray.splice(index, 1);
                    }

                    window.cookieFunctions.setCookie('colors', JSON.stringify(cookieArray));
                } else {
                    window.cookieFunctions.setCookie('colors', JSON.stringify(colors));
                }
            }
        });

        jQuery('.image-wrapper').on('touchend mouseout', function() {
            // console.log('touchend mouseout');
            jQuery(this).removeClass('active');
            jQuery(this).find('.hover-overlay').css( 'background-color', '' );
        });

    </script>

    </body>
</html>
