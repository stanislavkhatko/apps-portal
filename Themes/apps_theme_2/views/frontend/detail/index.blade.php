@extends('frontend.layouts.app')

@section('content')

    <div id="app" class="container portal_container">

        <div class="detail_wrapper">
            <div class="detail_title_wrapper">

                <div class="detail_header">
                    <a class="link_back" href="{{ url()->previous() }}">
                        < @lang('portal.back')
                    </a>
                    <!-- detail_title_back -->

                    <div class="detail_title">

                        {{ $item->category->contenttype->label }} - {{ $item->category->label }}
                        @if ($item->compatibility[0]['os'] ?? !empty($item->compatibility['os']))
                            ({{ $item->compatibility[0]['os'] ?? $item->compatibility['os'] }})
                        @endif
                    </div>
                    <!-- detail_title -->

                    <div style="clear:both"></div>
                    @if (session()->has('downloaderror'))
                        <br>
                        <div class="alert alert-danger" role="alert">
                            {{ session('downloaderror') }}
                        </div>
                    @endif
                </div>
                <!-- detail_header -->

                <div class="detail_game">

                    <div class="app_thumb_wrapper">
                        @if ($item->type == 'flash')
                            <div class="app_thumb" style="background-image: url('/img/musica2.png')">
                                @elseif ($item->type == 'mp3')
                                    <div class="app_thumb" style="background-image: url('/img/musica.png')">
                                        @else
                                            <div class="app_thumb"
                                                 style="background-image: url('{{ $item->preview }}')">
                                                @endif
                                                <a href="{{ route('view.contentitem', [$item]) }}"></a>
                                            </div>
                                            <!-- app_thumb -->
                                    </div>
                                    <!-- app_thumb_wrapper -->


                                    <div class="detail_game_name">
                                        {{ $item->title }}
                                    </div>
                                    <!-- detail_game_name -->

                                    <div style="clear:both"></div>
                            </div>
                            <!-- detail_game -->

                            <div style="clear:both"></div>

                    </div>
                    <!-- detail_title_wrapper -->

                    <div class="download_wrapper">

                        <span>@lang('portal.category'): {{ $item->category->label }}</span>
                        @if ($item->compatibility[0]['os'] ?? $item->compatibility[0]['os'] != null ?? $item->compatibility['os'] != '')
                            <span>
	    		@lang('portal.compatibility'):
                                {{ $item->compatibility[0]['os'] ?? $item->compatibility['os'] }}
                                {{ $item->compatibility[0]['minVersion'] ?? $item->compatibility['minVersion'] }}
                                @lang('portal.or_higher')</span>
                        @endif
                        <br/>

                        @if(!empty($item->description))
                            <span>@lang('portal.description'):</span>
                            <p>
                                {!! $item->description !!}
                            </p>
                        @endif

                        <a href="{{ route('download.contentitem', $item) }}">
                            <div class="download_bttn">
                                @lang('portal.download_label')
                            </div>
                        </a>

                    </div>
                    <!-- download_wrapper -->

                    <div class="available_wrapper">
                        <div class="title">
                            @lang('portal.also_available'):
                        </div>
                        <!-- title -->

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="app_section">
                                    <div
                                            class="app_wrapper carousel"
                                            data-flickity='{
	    	            		"contain": true, 
	    	            		"wrapAround": false, 
	    	            		"pageDots": false, 
	    	            		"cellAlign": "left", 
	    	            		"imagesLoaded": true}'
                                    >
                                        @foreach($item->category->contentItems->take(20) as $item)
                                            @include('frontend.contentitems/contentitem', compact('item'))
                                        @endforeach
                                    </div>
                                    <!-- app_wrapper  -->
                                </div>
                                <!-- app_section -->
                            </div>
                            <!-- col-sm-12 -->
                        </div>
                        <!-- row -->

                    </div>
                    <!-- available_wrapper -->

                </div>
                <!-- detail_wrapper -->

                @include('frontend.disclaimer')

            </div>
            <!-- container -->
        </div>
    </div>

@endsection
