{{--@extends('layouts.app')--}}

{{--@section('content')--}}
    {{--@while(have_posts()) --}}
        {{--@php the_post() @endphp--}}
        {{--@include('partials.content-single-'.get_post_type())--}}
    {{--@endwhile--}}
{{--@endsection--}}

@php
    header("HTTP/1.1 301 Moved Permanently");
    header("Location: ".get_bloginfo('url'));
    exit();
@endphp
