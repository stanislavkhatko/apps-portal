<div class="row">
    <div class="col-sm-12">
        <div class="app_section">
            <div class="header">
                <h3>
                    <a class="link_more"
                       href="{{ Request::segment(3) == 'categories' ? route('view.category', [$localContentType->local_content_type_id, $localContentType]) : route('view.categories', [$localContentType]) }}">
                        {{ $localContentType->label }}
                    </a>
                </h3>
            </div>

            <div style="clear:both;"></div>

            <div class="app_wrapper carousel">

                @if (Request::segment(3) == 'categories')
                    @foreach($localContentType->contentItems()->take(10)->get() as $item)
                        @include('frontend.contentitems/contentitem', compact('item'))
                    @endforeach
                @else
                    @foreach($localContentType->localCategories()->first()->contentItems()->take(10)->get() as $item)
                        @include('frontend.contentitems/contentitem', compact('item'))
                    @endforeach
                @endif

            </div>
        </div>
    </div>
</div>
