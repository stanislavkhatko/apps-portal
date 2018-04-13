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
                <div style="clear:both;"></div>
            </div>
            <!-- header -->

            <div style="clear:both;"></div>

            <div class="app_wrapper carousel">

                @if (Request::segment(3) == 'categories')

                    @foreach($localContentType->contentItems()->take(10)->get() as $item)
                        @if (\View::exists('frontend.contentitems/'.str_singular(str_slug($localContentType->label))))
                            @includeIf('frontend.contentitems/'.str_singular(str_slug($localContentType->label)))
                        @else
                            @include('frontend.contentitems/contentitem', compact('item'))
                        @endif
                    @endforeach

                @else

                    @foreach($localContentType->localCategories()->first()->contentItems()->take(10)->get() as $item)
                        @if (\View::exists('frontend.contentitems/'.str_singular(str_slug($localContentType->label))))
                            @includeIf('frontend.contentitems/'.str_singular(str_slug($localContentType->label)))
                        @else
                            @include('frontend.contentitems/contentitem', compact('item'))
                        @endif
                    @endforeach

                @endif

            </div>
            <!-- app_wrapper  -->
        </div>
        <!-- app_section -->
    </div>
    <!-- col-sm-12 -->
</div>
<!-- row -->
