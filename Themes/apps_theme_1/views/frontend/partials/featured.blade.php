<div class="app-featured">
    @foreach($portal->featuredItems as $item)
        @if ($item->pivot->visible == 1)
            @if($item->pivot->banner)
                <a href="{{ route('view.contentitem', [$item]) }}" class="app-featured-item">
                    <img src="{{ asset("storage/{$item->pivot->banner}") }}" class="img-responsive">
                </a>
            @else
                @include('frontend.partials.item', $item)
            @endif
        @endif
    @endforeach
</div>

