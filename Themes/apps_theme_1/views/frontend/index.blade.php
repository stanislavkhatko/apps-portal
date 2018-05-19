@extends('frontend.layouts.app')

@section('content')

    <!-- TODO make styling -->
{{--    @include('frontend.partials.flashbanner')--}}

    <!-- TODO make styling -->
    @include('frontend.partials.featured')

    @foreach($portal->localContentTypes as $localContentType)

        @include('frontend.partials.category', $localContentType)

    @endforeach

    @include('frontend.disclaimer')

@endsection
