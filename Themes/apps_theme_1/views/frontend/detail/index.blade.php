@extends('frontend.layouts.app')

@section('content')


    <div class="app-category-header">

        @include('frontend.partials.back')

        <div class="app-category-header__title">
            {{ $item->category->contenttype->label }} - {{ $item->category->label }}
        </div>

    </div>

    <div class="app-item">

        @if (session()->has('downloaderror'))
            <div class="app-item-error">
                {{ session('downloaderror') }}
            </div>
        @endif

        <div class="app-item-body">

            <div class="app-item-body--main">
                @if(strpos($item->download['link'], '.mp4') !== false && session()->has('subscription'))
                    <video width="480" style="margin: 0 auto;" controls>
                        <source src="{{ $itemUrl }}" type="video/mp4">
                        Your browser does not support HTML5 video.
                    </video>
                @else
                    <img src="{{ $item->preview}}" alt="{{ $item->title }}" class="app-item-body__thumb">
                @endif
            </div>

            <div class="app-item-body--details">

                <div class="app-item-body__title">
                    {{ $item->title }}
                </div>

                <div class="app-item-body__description">
                    {!! $item->description !!}
                </div>

                <div class="app-item-body__category">
                    {{ $item->category->label }}
                </div>

                <div class="app-item-body__rating">
                    @for($i = 0; $i < 5; $i++)
                        <span class="{{ $i < $item->rating ? 'active' : '' }}">☆</span>
                    @endfor
                </div>

                <div class="app-item-body__price">
                    @lang('portal.free')
                </div>

                <a href="{{ $item->type === 'upload' ? route('download.contentitem', $item) : route('play.contentitem', $item) }}"
                   class="app-item-body__download" target="{{ $item->type === 'upload' ? '_self' : '_blank' }}">
                    @if($item->type === 'upload') @lang('portal.download_label') @else @lang('portal.play') @endif
                </a>

            </div>

        </div>

    </div>


    <div class="app-category">

        <div class="app-category-header">
            <div class="app-category-header__title">
                @lang('portal.also_available'):
            </div>
        </div>

        <div class="app-category-items">
            @foreach($item->category->contentItems->take(5) as $item)
                @include('frontend.partials.item', $item)
            @endforeach
        </div>

    </div>

    @include('frontend.disclaimer')

@endsection
