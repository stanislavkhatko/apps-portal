@extends('frontend.layouts.app')

@section('content')

    <div class="app-category-header">
        @include('frontend.partials.back')
        <div class="app-category-header__title">
            @lang('portal.category'): {{ $localContentType->label }}
        </div>
    </div>

    @include('frontend.partials.categories', $localContentType, ['categories' => $localContentType->localCategories])

@endsection
