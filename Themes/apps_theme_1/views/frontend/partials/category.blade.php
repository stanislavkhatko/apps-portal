<div class="app-category">
    <div class="app-category-title">
        <a class="app-category-title__link"
           href="{{ Request::segment(3) == 'categories' ? route('view.category', [$localContentType->local_content_type_id, $localContentType]) : route('view.categories', [$localContentType]) }}">
            {{ $localContentType->label }}
        </a>
    </div>

    <div class="app-category-items">
        @if (Request::segment(3) == 'categories')
            @foreach($localContentType->contentItems()->orderBy('rating', 'desc')->take(5)->get() as $item)
                @include('frontend.partials.item', $item)
            @endforeach
        @else
            @foreach($localContentType->localCategories()->first()->contentItems()->orderBy('rating', 'desc')->take(5)->get() as $item)
                @include('frontend.partials.item', $item)
            @endforeach
        @endif
    </div>

    <div class="app-category-footer">

        <a class="app-category-footer__link"
           href="{{ Request::segment(3) == 'categories' ? route('view.category', [$localContentType->local_content_type_id, $localContentType]) : route('view.categories', [$localContentType]) }}">
            @lang('portal.more') {{ $localContentType->label }}
        </a>
    </div>
</div>
