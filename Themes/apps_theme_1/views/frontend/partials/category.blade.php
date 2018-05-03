<div class="app-category">
    <div class="app-category-title">
            <span class="app-category-title--name">
                {{ $localContentType->label }}
            </span>

        <a class="app-category-title--all"
           href="{{ Request::segment(3) == 'categories' ? route('view.category', [$localContentType->local_content_type_id, $localContentType]) : route('view.categories', [$localContentType]) }}">
            @lang('portal.more') <span class="glyphicon glyphicon-menu-right"></span>
        </a>
    </div>

    <div class="app-category-items">
        @if (Request::segment(3) == 'categories')
            @foreach($localContentType->contentItems()->orderBy('rating', 'desc')->take(4)->get() as $item)
                @include('frontend.partials.item', $item)
            @endforeach
        @else
            @foreach($localContentType->localCategories()->first()->contentItems()->orderBy('rating', 'desc')->take(4)->get() as $item)
                @include('frontend.partials.item', $item)
            @endforeach
        @endif
    </div>
</div>
