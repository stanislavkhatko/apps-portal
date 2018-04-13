@extends('frontend.layouts.app')

@section('content')

    <div class="app-item">

        <div class="app-item-header">

            @include('frontend.partials.back')

            <div class="app-item-title">
                {{ $item->category->contenttype->label }} - {{ $item->category->label }}
            </div>

            @if (session()->has('downloaderror'))
                <br>
                <div class="alert alert-danger" role="alert">
                    {{ session('downloaderror') }}
                </div>
            @endif
        </div>

        @include('frontend.partials.item', $item)

        <div class="app-item-detail">


            {{--<span>@lang('portal.category'): {{ $item->category->label }}</span>--}}
            {{--@if ($item->compatibility[0]['os'] ?? $item->compatibility[0]['os'] != null ?? $item->compatibility['os'] != '')--}}
            {{--<span>--}}
            {{--@lang('portal.compatibility'):--}}
            {{--{{ $item->compatibility[0]['os'] ?? $item->compatibility['os'] }}--}}
            {{--{{ $item->compatibility[0]['minVersion'] ?? $item->compatibility['minVersion'] }}--}}
            {{--@lang('portal.or_higher')</span>--}}
            {{--@endif--}}
            {{--<br/>--}}

            @if($item->description)
                <div class="app-item-detail__title">@lang('portal.description'):</div>
                <div class="app-item-detail__description">
                    {!! $item->description !!}
                </div>
            @endif

            @if($item->type == 'upload' || $item->type == 'cloud')
                <a href="{{ route('download.contentitem', $item) }}" class="btn btn-primary app-item-detail__download">
                    @lang('portal.download_label') <span class="glyphicon glyphicon-download-alt"></span>
                </a>
            @else
                <a href="{{ route('download.contentitem', $item) }}" target="_blank"
                   class="btn btn-primary app-item-detail__download">
                    @lang('portal.download_label') <span class="glyphicon glyphicon-new-window"></span>
                </a>
            @endif

        </div>

        <div class="app-category">
            <div class="app-category-header">
                <h4>
                    @lang('portal.also_available'):
                </h4>
            </div>

            <div class="app-category-items">
                @foreach($item->category->contentItems->take(10) as $item)
                    @include('frontend.partials.item', $item)
                @endforeach
            </div>
        </div>


    </div>

    @include('frontend.disclaimer')

@endsection
