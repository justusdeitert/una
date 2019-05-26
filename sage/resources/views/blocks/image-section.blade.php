{{--
  Title: Image Section
  Description: Dies ist der Image Section Block
  Category: common
  Icon: format-gallery
  Keywords: images section block
--}}

@if(get_field('image_section'))
    <div class="section">
        @while(has_sub_field('image_section'))
            @if(get_row_layout() == 'image')
                {{--@php--}}
                    {{--var_dump(get_sub_field('image'));--}}
                {{--@endphp--}}
                <h1>lol</h1>
            @endif
        @endwhile
    </div>
@else
    <section class="empty-block">
        <p>{!! $block['title'] !!}</p>
    </section>
@endif

{{--<script type="text/javascript">--}}
    {{--window.initSlider();--}}
{{--</script>--}}
