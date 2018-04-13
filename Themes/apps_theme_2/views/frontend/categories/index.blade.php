@extends('frontend.layouts.app')

@section('content')

    <div id="app" class="container portal_container">

        <div class="categories_wrapper">

            <div class="detail_header">
                <a class="link_back" href="{{ url()->previous() }}">
                    < @lang('portal.back')
                </a>
                <!-- link_back -->

                <h3>
                    @lang('portal.categories_for') {{ $localContentType->label }}
                </h3>
                <!-- detail_title -->

                <div style="clear:both"></div>
            </div>
            <!-- detail_header -->

            @each('frontend.partials.contentType', $localContentType->localCategories, 'localContentType')
        </div>
        <!-- categories_wrapper -->

    </div>
    <!-- container -->

@endsection
