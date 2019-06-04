{{--
  Title: Image Section
  Description: Dies ist der Image Section Block
  Category: common
  Icon: format-gallery
  Keywords: images section block
--}}

@if(get_field('slider_gallery'))
    <section class="slider-block {!! $block['id'] !!}">
        <div class="slider-inner">
            @foreach(get_field('slider_gallery') as $slide)
                <div data-type="parallax" data-speed="-2" class="slider-item {{--@if($i === 1){!! 'active' !!}@endif--}}" style="background-image:url({!! $slide['url'] !!})"></div>
            @endforeach
        </div>
    </section>
@else
    <section class="empty-block">
        <p>{!! $block['title'] !!}</p>
    </section>
@endif

{{--<script type="text/javascript">--}}
    {{--window.initSlider();--}}
{{--</script>--}}
