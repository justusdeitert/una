<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    @php wp_head() @endphp

    {{--Implementing Google Icons And Fonts--}}
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    @if(get_field('page_description', 'option'))
        <meta name="description" content="{{ get_field('page_description', 'option') }}" />
    @endif

    @if(get_field('favicon', 'option'))
        <link href="{!! get_field('favicon', 'option')['url'] !!}}" rel="shortcut icon" />
    @endif

    @if(get_field('touch_icon', 'option'))
        {{--https://mathiasbynens.be/notes/touch-icons--}}
        <link href="{!! get_field('touch_icon', 'option')['url'] !!}}" rel="apple-touch-icon-precomposed apple-touch-icon" />
    @endif
</head>
