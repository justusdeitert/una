{{--
  Title: Content Section
  Description: Dies ist der Image Section Block
  Category: common
  Icon: format-gallery
  Keywords: images section block
--}}

@if(get_field('content_section'))
    <div class="section-desktop fp-scrollable">
        @while(has_sub_field('content_section'))
            @if(get_row_layout() == 'image')
                <div class="image-section ">
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
                <div class="content-container">
                    <div class="text-container">
                        <div class="row">
                            <div class="col-12 col-md-10">
                                @if(get_sub_field('text'))
                                    <p>{!! get_sub_field('text') !!}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @if(get_row_layout() == 'columns')
                <div class="content-container">
                    <div class="column-container">
                        <div class="row">
                            <div class="col-12 col-md-11">
                                <div class="row">
                                    @foreach(get_sub_field('column') as $column )
                                        <div class="col-3">
                                            <div class="column-text-container">
                                                <h3>{!! $column['headline'] !!}</h3>
                                                @if($column['column'])
                                                    @foreach($column['column'] as $sub_column)
                                                        @if($sub_column['acf_fc_layout'] === 'image')
                                                            <a data-caption="{!! $sub_column['image']['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! $sub_column['image']['ID'] !!}" href="{!! $sub_column['image']['url'] !!}"  data-group="mobile-group-{!! $sub_column['image']['ID'] !!}">
                                                                <div class="image-container">
                                                                    <img src="{!! $sub_column['image']['sizes']['large'] !!}" >
                                                                </div>
                                                            </a>
                                                        @endif
                                                        @if($sub_column['acf_fc_layout'] === 'text')
                                                            {!! $sub_column['text'] !!}
                                                        @endif
                                                        @if($sub_column['acf_fc_layout'] === 'text_and_image')
                                                            {!! $sub_column['text'] !!}
                                                            <a data-caption="{!! $sub_column['image']['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! $sub_column['image']['ID'] !!}" href="{!! $sub_column['image']['url'] !!}"  data-group="mobile-group-{!! $sub_column['image']['ID'] !!}">
                                                                <div class="image-container">
                                                                    <img src="{!! $sub_column['image']['sizes']['large'] !!}" >
                                                                </div>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endwhile
    </div>

    @if(!get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
        @while(has_sub_field('content_section'))
            @if(get_row_layout() === 'image')
                @if(!get_field('split_up_on_mobile'))<div class="image-section-mobile-wrapper">@endif
                    @if(get_sub_field('link'))
                        @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                            <div class="section-mobile-inner">
                                <a class="admin-prevent-click image-wrapper section-mobile-image-{!! get_sub_field('image')['ID'] !!}" href="{!! get_sub_field('link')['url'] !!}">
                                    <div class="hover-overlay">{!! get_sub_field('link')['title'] !!}</div>
                                    <img src="{!! get_sub_field('image')['sizes']['large'] !!}" >
                                </a>
                            </div>
                            @if(get_field('split_up_on_mobile'))</div>@endif
                    @else
                        @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                            <div class="section-mobile-inner">
                                <a data-caption="{!! get_sub_field('image')['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! get_sub_field('image')['ID'] !!}" href="{!! get_sub_field('image')['url'] !!}"  data-group="mobile-group-{!! get_sub_field('image')['ID'] !!}">
                                    <div class="image-container">
                                        <img src="{!! get_sub_field('image')['sizes']['large'] !!}" >
                                        <div class="caption"><div class="span">{!! get_sub_field('image')['caption'] !!}</div></div>
                                    </div>
                                </a>
                            </div>
                            @if(get_field('split_up_on_mobile'))</div>@endif
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
                    @if(!get_field('split_up_on_mobile'))</div>@endif
            @endif
            @if(get_row_layout() == 'text')
                @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                    <div class="content-container">
                        <div class="text-container">
                            <div class="row">
                                <div class="col-12 col-md-11">
                                    @if(get_sub_field('text'))
                                        <p>{!! get_sub_field('text') !!}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @if(get_field('split_up_on_mobile'))</div>@endif
            @endif
                @if(get_row_layout() == 'columns')
                    @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                        <div class="content-container">
                        <div class="column-container">
                            <div class="row">
                                <div class="col-12 col-md-11">
                                    {{--<div class="row">--}}
                                        @php
                                            $column_id = get_sub_field_object('column')['ID'];
                                            $iterator = 0;

                                        @endphp
                                        <div id="accordion-{!! $column_id !!}" class="accordion row">
                                            @foreach(get_sub_field('column') as $column )
                                                @php
                                                    $iterator++;
                                                    $header_id = 'accordion-header-' . $column_id . '-' . $iterator;
                                                    $body_id = 'accordion-body-' . $column_id . '-' . $iterator;

                                                @endphp
                                                <div class="col-12">
                                                    <div class="column-text-container">
                                                        <div class="accordion-header colored-hover" data-toggle="collapse" data-target="#{!! $body_id !!}" id="{!! $header_id !!}">
                                                            <h3>{!! $column['headline'] !!}</h3>
                                                            <i class="material-icons"></i>
                                                        </div>
                                                        <div class="accordion-body collapse" aria-labelledby="{!! $header_id !!}" id="{!! $body_id !!}" data-parent=".accordion">
                                                            <div class="row">
                                                                @if($column['column'])
                                                                    @foreach($column['column'] as $sub_column)
                                                                        @if($sub_column['acf_fc_layout'] === 'image')
                                                                            <div class="col-12">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        <a data-caption="{!! $sub_column['image']['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! $sub_column['image']['ID'] !!}" href="{!! $sub_column['image']['url'] !!}"  data-group="mobile-group-{!! $sub_column['image']['ID'] !!}">
                                                                                            <div class="image-container">
                                                                                                <img src="{!! $sub_column['image']['sizes']['large'] !!}" >
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        @endif
                                                                        @if($sub_column['acf_fc_layout'] === 'text')
                                                                            <div class="col-12">
                                                                                <div class="row">
                                                                                    <div class="col-6">
                                                                                        {!! $sub_column['text'] !!}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                        @if($sub_column['acf_fc_layout'] === 'text_and_image')
                                                                            <div class="col-12">
                                                                                <div class="row text-and-image-container">
                                                                                    <div class="col-6 col-sm-6">
                                                                                        {!! $sub_column['text'] !!}
                                                                                    </div>
                                                                                    <div class="col-5 offset-1 col-sm-4 offset-sm-2">
                                                                                        <a data-caption="{!! $sub_column['image']['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! $sub_column['image']['ID'] !!}" href="{!! $sub_column['image']['url'] !!}"  data-group="mobile-group-{!! $sub_column['image']['ID'] !!}">
                                                                                            <div class="image-container">
                                                                                                <img src="{!! $sub_column['image']['sizes']['large'] !!}" >
                                                                                            </div>
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    {{--</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(get_field('split_up_on_mobile'))</div>@endif
                @endif
        @endwhile
    @if(!get_field('split_up_on_mobile'))</div>@endif

@else
    <section class="empty-block">
        <p>{!! $block['title'] !!}</p>
    </section>
@endif

{{--<script type="text/javascript">--}}
    {{--window.initSlider();--}}
{{--</script>--}}
