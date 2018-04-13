@extends('frontend.layouts.app')

@section('content')

    <div id="app" class="container portal_container">

        <div class="contenttype_wrapper">

            <div class="detail_header">

                <div class="text-right">
                    <a class="detail_title_forward" href="{{ route('view.categories', [$localContentType]) }}">
                        <div class="bttn_light_blue bttn_forward">
                            @lang('portal.all_categories')
                        </div>
                    </a>
                </div>

                <div style="clear:both"></div>

                <a class="detail_title_back" href="/">
                    <div class="bttn_light_blue bttn_back">
                        @lang('portal.back')
                    </div>
                </a>
                <!-- detail_title_back -->

                <div class="detail_title">
                    {{ $localContentType->label }}
                </div>
                <!-- detail_title -->

                <div style="clear:both"></div>
            </div>
            <!-- detail_header -->

            {{--<content-types content-type-id="{{ $item->id }}"></content-types>--}}

            @foreach($contentItems as $item)
                <div class="detail_game" onclick="location.href='{{ route('view.contentitem', [$item]) }}';">

                    <div class="app_thumb_wrapper">
                        <div class="app_thumb" style="background-image: url('{{ $item->preview }}')">
                            <a href="{{ route('view.contentitem', [$item]) }}"></a>
                        </div>
                        <!-- app_thumb -->
                    </div>
                    <!-- app_thumb_wrapper -->


                    <div class="detail_game_name">
                        {{ $item->title }}
                    </div>
                    <!-- detail_game_name -->

                    @include('frontend.rating')

                    <p>
                        {!! str_limit($item->description, 150) !!}
                    </p>

                    <div style="clear:both"></div>

                    <div class="download_bttn">
                        @lang('portal.download_label')
                    </div>
                </div>
                <!-- detail_game -->
            @endforeach

        </div>
        <!-- contenttype_wrapper -->

        <div class="pagination_wrapper">
            {{ $contentItems->links() }}
        </div>

    </div>
    <!-- container -->

@endsection
