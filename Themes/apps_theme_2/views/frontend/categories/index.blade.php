@extends('frontend.layouts.app')

@section('content')

    <div class="portal_container">
        <div class="categories_wrapper">
            <div class="detail_header">
                <a class="link_back" href="{{ url()->previous() }}">
                    < @lang('portal.back')
                </a>

                <h3>
                    @lang('portal.categories_for') {{ $localContentType->label }}
                </h3>

                <div style="clear:both"></div>
            </div>

            @each('frontend.partials.contentType', $localContentType->localCategories, 'localContentType')
        </div>
    </div>

@endsection
