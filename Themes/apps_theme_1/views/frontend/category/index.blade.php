@extends('frontend.layouts.app')

@section('content')

    <div class="app-items-header">
        @include('frontend.partials.back')
        <div class="app-items-header__title">
            @lang('portal.category'): {{ $localCategory->label }}
        </div>
    </div>

    <div class="app-items">

        @foreach ($localCategory->contentItems()->inRandomOrder()->take(50)->get() as $item)
            @include('frontend.partials.item', $item)
        @endforeach

    </div>

@endsection
