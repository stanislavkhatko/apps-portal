@extends('frontend.layouts.app')

@section('content')

    <div class="app-category">
        <div class="app-category-header">
            @include('frontend.partials.back')
            <h4>
                @lang('portal.category'): {{ $localCategory->label }}
            </h4>
        </div>

        <div class="app-category-items">
            @foreach ($localCategory->contentItems()->orderBy('rating', 'desc')->take(50)->get() as $item)
                @include('frontend.partials.item', $item)
            @endforeach
        </div>
    </div>



@endsection
