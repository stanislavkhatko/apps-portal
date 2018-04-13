@extends('frontend.layouts.app')

@section('content')

    <div class="container margin_top_50">


        @if ($item->type == 'video')

            @include('frontend.detail.partials.video')

        @else

            @include('frontend.detail.partials.game')

        @endif

        @include('frontend.detail.partials.interesting')

        @include('frontend.disclaimer')

    </div>
    <!-- container -->

@endsection


