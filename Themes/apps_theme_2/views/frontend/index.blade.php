@extends('frontend.layouts.app')

@section('content')

    <div id="app" class="container portal_container">

        @includeWhen($portal->featuredItems, 'frontend.partials.featured', ['items' => $portal->featuredItems])

        @foreach($portal->localContentTypes as $localContentType)
            {{-- @continue(str_contains(strtolower($contentType->label), ['android']) && ! Agent::isAndroidOS()) --}}
            @include('frontend.partials.contentType', compact('localContentType'))
        @endforeach

        @include('frontend.disclaimer')

    </div>
    <!-- container -->

@endsection
