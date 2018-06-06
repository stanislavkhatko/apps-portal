@extends('pages.index')

@section('title', $localCategory->label)

@section('content')

    <div class="app-items-header">
        @include('partials.back')
        <div class="app-items-header__title">
            @lang('portal.category'): {{ $localCategory->label }}
        </div>
    </div>

    <div class="app-items">
        @include('partials.items', ['items' => $localCategory->contentItems])
    </div>

@endsection
