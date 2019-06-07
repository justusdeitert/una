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
                            <div class="image-container">
                                <div class="hover-overlay">{!! get_sub_field('link')['title'] !!}</div>
                                <img src="{!! get_sub_field('image')['sizes']['large'] !!}" >
                            </div>
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

        @php $section_id = 0; @endphp
        @php $all_content_sections = get_field('content_section'); @endphp

        @if(get_field('one_image_randomly_on_mobile'))
            @php
                shuffle($all_content_sections);
            @endphp
        @endif

        @foreach($all_content_sections as $content_section)
            @if($content_section['acf_fc_layout'] === 'image')
                @if(!get_field('split_up_on_mobile'))<div class="image-section-mobile-wrapper">@endif
                    @if($content_section['link'])
                        @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                            <div class="section-mobile-inner">
                                <a class="admin-prevent-click image-wrapper section-mobile-image-{!! $content_section['image']['ID'] !!}" href="{!! $content_section['link']['url'] !!}">
                                    <div class="hover-overlay">{!! $content_section['link']['title'] !!}</div>
                                    <img src="{!! $content_section['image']['sizes']['large'] !!}" >
                                </a>
                            </div>
                        @if(get_field('split_up_on_mobile'))</div>@endif
                    @else
                        @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                            <div class="section-mobile-inner">
                                <a data-caption="{!! $content_section['image']['caption'] !!}" class="admin-prevent-click image-wrapper smart-photo section-mobile-image-{!! $content_section['image']['ID'] !!}" href="{!! $content_section['image']['url'] !!}"  data-group="mobile-group-{!! $content_section['image']['ID'] !!}">
                                    <div class="image-container">
                                        <img src="{!! $content_section['image']['sizes']['large'] !!}" >
                                        <div class="caption"><div class="span">{!! $content_section['image']['caption'] !!}</div></div>
                                    </div>
                                </a>
                            </div>
                        @if(get_field('split_up_on_mobile'))</div>@endif
                    @endif
                @if(!get_field('split_up_on_mobile'))</div>@endif
            @endif
            @if($content_section['acf_fc_layout'] === 'text')
                @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                    <div class="content-container">
                        <div class="text-container">
                            <div class="row">
                                <div class="col-12 col-md-11">
                                    @if($content_section['text'])
                                        <p>{!! $content_section['text'] !!}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @if(get_field('split_up_on_mobile'))</div>@endif
            @endif
            @if($content_section['acf_fc_layout'] === 'columns')
                {{--@php var_dump($content_section['column']); @endphp--}}
                @if(get_field('split_up_on_mobile'))<div class="section-mobile fp-scrollable">@endif
                    <div class="content-container">
                        <div class="column-container">
                            <div class="row">
                                <div class="col-12 col-md-11">

                                        @php $iterator = 0; @endphp
                                        <div id="accordion-{!! $section_id !!}" class="accordion">
                                            <div class="row">
                                                @foreach($content_section['column'] as $column)
                                                    @php
                                                        $iterator++;
                                                        $header_id = 'accordion-header-' . $section_id . '-' . $iterator;
                                                        $body_id = 'accordion-body-' . $section_id . '-' . $iterator;
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
                                                                                        <div class="col-8">
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
                                                                                        <div class="col-8">
                                                                                            {!! $sub_column['text'] !!}
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endif
                                                                            @if($sub_column['acf_fc_layout'] === 'text_and_image')
                                                                                <div class="col-12">
                                                                                    <div class="row text-and-image-container">
                                                                                        <div class="col-8 col-sm-8">
                                                                                            {!! $sub_column['text'] !!}
                                                                                        </div>
                                                                                        <div class="col-4 col-sm-4 offset-sm-1">
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
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(get_field('split_up_on_mobile'))</div>@endif
            @endif

            @php $section_id++; @endphp

            @if($section_id >= 1)
                @break
            @endif

        @endforeach

    @if(!get_field('split_up_on_mobile'))</div>@endif

@else
    <section class="empty-block">
        <p>{!! $block['title'] !!}</p>
    </section>
@endif

{{--<script type="text/javascript">--}}
    {{--window.initSlider();--}}
{{--</script>--}}
