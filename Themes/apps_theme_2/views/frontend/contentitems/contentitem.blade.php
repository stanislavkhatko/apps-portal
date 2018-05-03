<div class="app_wrap carousel-cell">

    <div class="app_thumb_wrapper">
        <div class="app_thumb" style="background-image: url('{{ $item->preview }}')">
            <a href="{{ route('view.contentitem', [$item]) }}"></a>
        </div>
    </div>

    {{--@include('frontend.partials.rating')--}}

    <div class="app_name">
        {{ $item->title }}
    </div>

</div>
