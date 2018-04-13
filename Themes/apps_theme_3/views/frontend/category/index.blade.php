@extends('frontend.layouts.app')

@section('content')

    <div class="container">

        <div class="items_wrapper">

            <h1 class="text-center">
                {{ $localCategory->label }}
            </h1>

            @foreach($localCategory->contentItems as $item)

                <div class="item_block">
                    @include('frontend.partials.item', ['localContentType' => $localCategory->localContentType, 'localCategory' => $localCategory,  'contentItem'=> $item])
                </div>
                <!-- item_block -->

            @endforeach

        </div>
        <!-- items-wrapper -->

    </div>
    <!-- container -->

@endsection
