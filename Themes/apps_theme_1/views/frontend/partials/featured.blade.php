<div class="app-featured">
    <div class="app-featured-title">
        Featured title
    </div>
    <div class="app-featured-items">
        @foreach($portal->featuredItems as $item)
            @if ($item->pivot->visible == 1)
                @if($item->pivot->banner)
                    <a href="{{ route('view.contentitem', [$item]) }}" class="app-featured-item">
                        <img src="{{ $item->pivot->banner }}" class="app-featured-item__banner">
                    </a>
                @else
                    @include('frontend.partials.item', $item)
                @endif
            @endif
        @endforeach
    </div>
</div>

