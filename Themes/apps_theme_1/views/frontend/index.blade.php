@extends('frontend.layouts.app')

@section('content')

    <!-- TODO make styling -->
    {{--    @include('frontend.partials.flashbanner')--}}

    @include('frontend.partials.featured')

    @include('frontend.partials.category', $localContentType, ['categories' => $portal->localContentTypes])

@endsection
