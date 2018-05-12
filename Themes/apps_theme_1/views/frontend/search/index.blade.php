@extends('frontend.layouts.app')

@section('content')

    <div class="app-items-header">
        @include('frontend.partials.back')
        <div class="app-items-header__title">
            @lang('portal.search'): <b>{{ $search }}</b>
        </div>
    </div>

    <div class="app-items">

        @foreach ($items as $item)
            @include('frontend.partials.item', ['item'=> $item])
        @endforeach

    </div>

@endsection
