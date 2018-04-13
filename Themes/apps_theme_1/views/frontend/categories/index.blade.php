@extends('frontend.layouts.app')

@section('content')

    <div class="app-category-header">
        @include('frontend.partials.back')
        <h4>
            @lang('portal.categories_for') {{ $localContentType->label }}
        </h4>
    </div>

    @foreach($localContentType->localCategories as $localContentType)
        @include('frontend.partials.category', $localContentType)
    @endforeach

@endsection
