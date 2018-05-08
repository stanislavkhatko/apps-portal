@extends('frontend.layouts.app')

@section('content')

    <div class="app-item">

        <div class="app-item-header">

            @include('frontend.partials.back')

            <div class="app-item-header__title">
                {{ $item->category->contenttype->label }} - {{ $item->category->label }}
            </div>

            @if (session()->has('downloaderror'))
                <div class="app-item-header__error">
                    {{ session('downloaderror') }}
                </div>
            @endif
        </div>

        @include('frontend.partials.item', $item)

        <div class="app-item-detail">

            @if($item->description)
                <div class="app-item-detail__title">@lang('portal.description'):</div>
                <div class="app-item-detail__description">
                    {!! $item->description !!}
                </div>
            @endif

            @if($item->type === 'upload')
                <a href="{{ route('download.contentitem', $item) }}" class="btn btn-primary app-item-detail__download">
                    @lang('portal.download_label') <span class="glyphicon glyphicon-download-alt"></span>
                </a>
            @else
                @if(strpos($item->download['link'], 'online/') !== false)
                    <a href="{{ route('play.contentitem', $item) }}" target="_blank"
                       class="btn btn-primary app-item-detail__download">
                        @lang('portal.play') <span class="glyphicon glyphicon-new-window"></span>
                    </a>
                @elseif(strpos($item->download['link'], 'www.') !== false || strpos($item->download['link'], 'http') !== false || strpos($item->download['link'], 'https') !== false)
                    <a href="{{ $item->download['link'] }}" target="_blank"
                       class="btn btn-primary app-item-detail__download">
                        @lang('portal.play') <span class="glyphicon glyphicon-new-window"></span>
                    </a>
                @else
                    <iframe width="560" height="315"
                            src="https://www.youtube-nocookie.com/embed/{!! $item->download['link'] !!}?rel=0&amp;showinfo=0"
                            frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                @endif
            @endif

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
    </div>

    @include('frontend.disclaimer')

@endsection
