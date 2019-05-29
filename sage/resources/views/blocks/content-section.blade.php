{{--
  Title: Content Section
  Description: Dies ist der Image Section Block
  Category: common
  Icon: format-gallery
  Keywords: images section block
--}}

@if(get_field('image_section'))
    <div class="section-desktop">
        <div class="slide-content">
            @while(has_sub_field('image_section'))
                @if(get_row_layout() == 'image')
                    <div class="image-section">
                        @if(get_sub_field('link'))
                            <a class="admin-prevent-click image-wrapper section-image-{!! get_sub_field('image')['ID'] !!}" href="{!! get_sub_field('link')['url'] !!}">
                                <div class="hover-overlay">{!! get_sub_field('link')['title'] !!}</div>
                                <img src="{!! get_sub_field('image')['sizes']['large'] !!}" >
                            </a>
                        @else
                            {{--@php var_dump(get_sub_field('image')['caption']); @endphp--}}
                            <a data-caption="{!! get_sub_field('image')['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-image-{!! get_sub_field('image')['ID'] !!}" href="{!! get_sub_field('image')['url'] !!}"  data-group="desktop-group-{!! get_sub_field('image')['ID'] !!}">
                                <div class="image-container">
                                    <img src="{!! get_sub_field('image')['sizes']['large'] !!}" >
                                    <div class="caption"><div class="span">{!! get_sub_field('image')['caption'] !!}</div></div>
                                </div>
                            </a>
                        @endif

                        <style>
                            .section-image-{!! get_sub_field('image')['ID'] !!} {
                                position: absolute;
                                @if(get_sub_field('image_width')) width: {!! get_sub_field('image_width') !!}%; @endif
                            @if(get_sub_field('position_top')) top: {!! get_sub_field('position_top') !!}%; @endif
                            @if(get_sub_field('position_right')) right: {!! get_sub_field('position_right') !!}%; @endif
                            @if(get_sub_field('position_bottom')) bottom: {!! get_sub_field('position_bottom') !!}%; @endif
                            @if(get_sub_field('position_left')) left: {!! get_sub_field('position_left') !!}%; @endif
                        }
                        </style>
                    </div>
                @endif
                @if(get_row_layout() == 'text')
                    <div class="text-container">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                @if(get_sub_field('text'))
                                    <p>{!! get_sub_field('text') !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @if(get_row_layout() == 'column')
                    <div class="column-container">
                        @while(has_sub_field('column'))
                            @if(get_row_layout() == 'text')
                                {!! get_sub_field('text') !!}
                            @endif
                        @endwhile
                    </div>
                @endif
            @endwhile
        </div>
    </div>

    {{--<div class="section-mobile image-section fp-auto-height">--}}
    @while(has_sub_field('image_section'))
        @if(get_row_layout() == 'image')
            @if(get_sub_field('link'))
                <div class="section-mobile {{--fp-auto-height--}}">
                    <div class="section-mobile-inner">
                        <a class="admin-prevent-click image-wrapper section-mobile-image-{!! get_sub_field('image')['ID'] !!}" href="{!! get_sub_field('link')['url'] !!}">
                            <div class="hover-overlay">{!! get_sub_field('link')['title'] !!}</div>
                            <img src="{!! get_sub_field('image')['sizes']['large'] !!}" >
                        </a>
                    </div>
                </div>

            @else
                {{--@php var_dump(get_sub_field('image')['caption']); @endphp--}}
                <div class="section-mobile {{--fp-auto-height--}}">
                    <div class="section-mobile-inner">
                        <a data-caption="{!! get_sub_field('image')['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! get_sub_field('image')['ID'] !!}" href="{!! get_sub_field('image')['url'] !!}"  data-group="mobile-group-{!! get_sub_field('image')['ID'] !!}">
                            <div class="image-container">
                                <img src="{!! get_sub_field('image')['sizes']['large'] !!}" >
                                <div class="caption"><div class="span">{!! get_sub_field('image')['caption'] !!}</div></div>
                            </div>
                        </a>
                    </div>
                </div>
            @endif

            <style>
                .section-image-{!! get_sub_field('image')['ID'] !!} {
                    position: absolute;
                    @if(get_sub_field('image_width')) width: {!! get_sub_field('image_width') !!}%; @endif
                            @if(get_sub_field('position_top')) top: {!! get_sub_field('position_top') !!}%; @endif
                            @if(get_sub_field('position_right')) right: {!! get_sub_field('position_right') !!}%; @endif
                            @if(get_sub_field('position_bottom')) bottom: {!! get_sub_field('position_bottom') !!}%; @endif
                            @if(get_sub_field('position_left')) left: {!! get_sub_field('position_left') !!}%; @endif
                        }
            </style>
        @endif
        @if(get_row_layout() == 'text')
            @if(get_sub_field('text'))
                <div class="section-mobile {{--fp-auto-height--}}">
                    <div class="text-container">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                <p>{!! get_sub_field('text') !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    @endwhile
    {{--</div>--}}

@else
    <section class="empty-block">
        <p>{!! $block['title'] !!}</p>
    </section>
@endif

{{--<script type="text/javascript">--}}
    {{--window.initSlider();--}}
{{--</script>--}}
