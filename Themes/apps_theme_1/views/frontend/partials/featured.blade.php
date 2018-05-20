@if(count($portal->activeFeaturedItems))
    <div class="app-featured">
        <div class="app-featured-title">
            @lang('portal.top_free_games')
        </div>
        <div class="app-featured-items">
            @foreach($portal->activeFeaturedItems as $item)
                @if($item->pivot->banner)
                    <a href="{{ route('view.contentitem', [$item]) }}" class="app-featured-item">
                        <img src="{{ $item->pivot->banner }}" class="app-featured-item__banner">
                    </a>
                @else
                    @include('frontend.partials.item', $item)
                @endif
            @endforeach
        </div>
    </div>
@endif

