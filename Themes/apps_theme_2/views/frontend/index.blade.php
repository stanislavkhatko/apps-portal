@extends('frontend.layouts.app')

@section('content')

    <!-- If featured items is set -->
    @includeWhen($portal->featuredItems, 'frontend.partials.featured', ['items' => $portal->featuredItems])


    @foreach($portal->localContentTypes as $localContentType)
        <!-- Local content type -->
        @include('frontend.partials.contentType', compact('localContentType'))
    @endforeach

    <!-- Include disclaimer -->
    @include('frontend.disclaimer')

@endsection
