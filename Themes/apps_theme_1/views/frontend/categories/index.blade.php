@extends('frontend.layouts.app')

@section('content')

    <div class="app-category-header">
        @include('frontend.partials.back')
        <div class="app-category-header__title">
            @lang('portal.category'): {{ $localContentType->label }}
        </div>
    </div>

    @foreach($localContentType->localCategories as $localContentType)
        @include('frontend.partials.category', $localContentType)
    @endforeach

    @include('frontend.disclaimer')

@endsection
