<!-- TODO remove, unused -->
@extends('frontend.layouts.app')

@section('content')

    <div class="contenttype_wrapper">

        <div class="detail_header">

            <div class="text-right">
                <a class="detail_title_forward" href="{{ route('view.categories', [$localContentType]) }}">
                    <div class="bttn_light_blue bttn_forward">
                        @lang('portal.all_categories')
                    </div>
                </a>
            </div>

            <a class="detail_title_back" href="/">
                <div class="bttn_light_blue bttn_back">
                    @lang('portal.back')
                </div>
            </a>

            <div class="detail_title">
                {{ $localContentType->label }}
            </div>

        </div>

        @foreach($contentItems as $item)
            <div class="detail_game" onclick="location.href='{{ route('view.contentitem', [$item]) }}';">

                <div class="app_thumb_wrapper">
                    <div class="app_thumb" style="background-image: url('{{ $item->preview }}')">
                        <a href="{{ route('view.contentitem', [$item]) }}"></a>
                    </div>
                </div>


                <div class="detail_game_name">
                    {{ $item->title }}
                </div>

                @include('frontend.rating')

                <p>
                    {!! str_limit($item->description, 150) !!}
                </p>

                <div class="download_bttn">
                    @lang('portal.download_label')
                </div>
            </div>
        @endforeach

    </div>

    <div class="pagination_wrapper">
        {{ $contentItems->links() }}
    </div>

@endsection
