@extends('frontend.layouts.app')

@section('content')

    @include('frontend.partials.flashbanner')

    @include('frontend.partials.featured')

    @foreach($portal->localContentTypes as $localContentType)
        @include('frontend.partials.category', $localContentType)
    @endforeach

    @include('frontend.disclaimer')

@endsection
