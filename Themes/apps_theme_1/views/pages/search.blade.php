@extends('pages.index')

@section('title', trans('portal.search'))

@section('content')

    <div class="app-items-header">
        @include('partials.back')
        <div class="app-items-header__title">
            @lang('portal.search'): <b>{{ $search }}</b>
        </div>
    </div>

    <div class="app-items">
        @include('partials.items', ['items'=> $items])
    </div>

@endsection
