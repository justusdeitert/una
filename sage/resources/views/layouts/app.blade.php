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

        let colors = [];

        @foreach($link_colors as $color)
            colors.push('{!! $color !!}');
        @endforeach

        const randColors = () => colors[Math.floor(Math.random() * colors.length)];

        jQuery(document).ready(function() {
            var currentRandomColor = randColors();
            var currentMenuItem = jQuery('.current-menu-item');
            jQuery(currentMenuItem).children('a').css( 'color', currentRandomColor );
            jQuery(currentMenuItem).children('a').css( 'border-color', currentRandomColor );
        });

        jQuery('.page-wrapper a:not(.current-menu-item a), .colored-hover').on('touchstart mouseover', function() {
            // console.log('touchsttouchstart mouseoverart');
            var currentRandomColor = randColors();
            jQuery(this).css( 'color', currentRandomColor );
            jQuery(this).children('h3, i').css( 'color', currentRandomColor );
            jQuery(this).css( 'border-color', currentRandomColor );
        });

        jQuery('.page-wrapper a:not(.current-menu-item a), .colored-hover').on('touchend mouseout', function() {
            // console.log('touchend mouseout');
            jQuery(this).css( 'color', 'initial' );
            jQuery(this).children('h3, i').css( 'color', 'initial' );
            jQuery(this).css( 'border-color', 'initial' );
            jQuery(this).children('h3, i').css( 'border-color', 'initial' );
        });


        jQuery('.image-wrapper').on('touchstart mouseover', function() {
            // console.log('touchstart mouseover');
            var currentRandomColor = randColors();
            jQuery(this).addClass('active');
            jQuery(this).find('.hover-overlay').css( 'background-color', currentRandomColor );
        });

        jQuery('.image-wrapper').on('touchend mouseout', function() {
            // console.log('touchend mouseout');
            jQuery(this).removeClass('active');
            jQuery(this).find('.hover-overlay').css( 'background-color', 'initial' );
        });

    </script>

    </body>
</html>
