@extends('frontend.layouts.app')

@section('content')

    @include('frontend.partials.flashbanner')

    @include('frontend.partials.featured')

    @foreach($portal->localContentTypes as $localContentType)

        <div class="app-category-header">
            @lang('portal.categories_for') {{ $localContentType->label }}
        </div>

        @include('frontend.partials.category', $localContentType)
    @endforeach

    @include('frontend.disclaimer')

@endsection
