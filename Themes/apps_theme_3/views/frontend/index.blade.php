@extends('frontend.layouts.app')

@section('content')

    @include('frontend.partials.flashbanner')

    <div class="container container_index">


        @includeWhen($portal->featuredItems()->where('visible', 1)->count(), 'frontend.partials.featured', ['items' => $portal->featuredItems->shuffle()])

        <?php
        $random = floor(30 / Config::get('currentPortal')->localContentTypes->count());
        ?>

        <div class="items_wrapper">

            @foreach (Config::get('currentPortal')->localContentTypes as $localContentType)

                @foreach($localContentType->contentItems->random($random) as $item)

                    <div class="item_block">
                        @include('frontend.partials.item', ['localContentType' => $localContentType, 'localCategory' => $localContentType->localCategories->first(),  'contentItem'=> $item])
                    </div>
                    <!-- item_block -->

                @endforeach

            @endforeach

        </div>
        <!-- items-wrapper -->


        @include('frontend.disclaimer')

    </div>
    <!-- container -->

@endsection