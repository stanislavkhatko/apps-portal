@extends('pages.index')

@section('content')

    <div class="app-category-header">
        @include('partials.back')
        <div class="app-category-header__title">
            @lang('portal.category'): {{ $localContentType->label }}
        </div>
    </div>

    @include('partials.categories', ['categories' => $localContentType->localCategories])

@endsection
