<div class="row banner_wrapper">
    <div class="featured_carousel">
        @foreach($items as $item)
            @if ($item->pivot->visible == 1)
                <a href="{{ route('view.contentitem', [$item]) }}" class="carousel-cell">
                    <img src="{{ asset("storage/{$item->pivot->banner}") }}" class="img-responsive">
                    <div style="clear:both"></div>
                    <div class="banner_title">
                        {{ $item->title }}
                    </div>
                </a>
            @endif
        @endforeach
    </div>
</div>
