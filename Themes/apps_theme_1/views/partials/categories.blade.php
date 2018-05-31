@foreach($categories as $localContentType)
    <div class="app-category">
        <div class="app-category-title">
            <a class="app-category-title__link"
               href="{{ Request::segment(3) == 'categories' ? route('view.category', [$localContentType->local_content_type_id, $localContentType]) : route('view.categories', [$localContentType]) }}">
                {{ $localContentType->label }}
            </a>
        </div>

        <div class="app-category-items">
            @include('partials.items', ['items' => $localContentType->contentItems->random(5)])
        </div>

        <div class="app-category-footer">
            <a class="app-category-footer__link"
               href="{{ Request::segment(3) == 'categories' ? route('view.category', [$localContentType->local_content_type_id, $localContentType]) : route('view.categories', [$localContentType]) }}">
                @lang('portal.more') {{ $localContentType->label }}
            </a>
        </div>
    </div>
@endforeach
