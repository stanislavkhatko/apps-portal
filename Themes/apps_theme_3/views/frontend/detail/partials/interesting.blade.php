<div class="available_wrapper">

    <div class="available_title">
        @lang('portal.more_games')</span>
    </div>
    <!-- title -->

    <div class="items_wrapper">

        @foreach($localCategory->contentItems as $item)

            <div class="item_block">
                @include('frontend.partials.item', ['localContentType' => $localCategory->localContentType, 'localCategory' => $localCategory,  'contentItem'=> $item])
            </div>
            <!-- item_block -->

        @endforeach

    </div>
    <!-- items-wrapper -->

</div>
<!-- available_wrapper -->