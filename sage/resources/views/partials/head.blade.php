<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    {{--// Why is it Tricky as Fuck to change the WP Title--}}
    @php function new_title() { echo str_replace(' ', '', wp_title('', false)); } @endphp
    @php function new_description() { echo str_replace(' ', '', bloginfo('description')); } @endphp

    <title>@php bloginfo('name'); @endphp: @php is_front_page() ? new_description() : new_title(); @endphp</title>

    {{--Google Site Verification - Confir   m ownership--}}
    <meta name="google-site-verification" content="ciWuq4bh-v2OypfzSbKRdhCO10qDmoRUncd1O1rX6fs" />

    @if(get_field('page_description', 'option'))
        <meta name="description" content="{{ get_field('page_description', 'option') }}" />
        <meta property="og:description" content="{{ get_field('page_description', 'option') }}" />
    @endif

    @if(get_field('favicon', 'option'))
        <link href="{!! get_field('favicon', 'option')['url'] !!}}" rel="shortcut icon" />
    @endif

    @if(get_field('touch_icon', 'option'))
        {{--https://mathiasbynens.be/notes/touch-icons--}}
        <link href="{!! get_field('touch_icon', 'option')['url'] !!}}" rel="apple-touch-icon-precomposed" />
        <meta name="msapplication-TileImage" content="{{ get_field('touch_icon', 'option')['url'] }}">
    @endif

    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ get_bloginfo('name') }}: @php new_description(); @endphp" />
    <meta property="og:url" content="{{ get_home_url() }}" />

    @if(get_field('open_graph_images', 'option'))
        @foreach(get_field('open_graph_images', 'option') as $images)
            <meta property="og:image" content="{{ $images['url'] }}" />
        @endforeach
    @endif

    @php wp_head() @endphp

    {{--Implementing Google Icons And Fonts--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
