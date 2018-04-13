<div class="detail_game_wrapper">

    <div class="category_wrapper detail_bg_color">
        {{ $item->localCategory()->first()->label }}
    </div>
    <!-- category_wrapper -->

    <div class="content_wrapper">
        <h1>
            {{ $item->title }}
        </h1>

        <a href="{{ route('download.contentitem', $item) }}" class="main_img">

            @if ($item->type == 'flash')
                <img src="/img/musica2.png')" class="img-responsive">
            @elseif ($item->type == 'mp3')
                <img src="/img/musica.png')" class="img-responsive">
            @else
                <img src="{{ $item->preview }}" class="img-responsive">
            @endif

        </a>
        <!-- main_img -->

        <div class="content">

            @if ($item->compatibility[0]['os'] ?? $item->compatibility[0]['os'] != null ?? $item->compatibility['os'] != '')
                <span>
	    		@lang('portal.compatibility'):
                    {{ $item->compatibility[0]['os'] ?? $item->compatibility['os'] }}
                    {{ $item->compatibility[0]['minVersion'] ?? $item->compatibility['minVersion'] }}
                    @lang('portal.or_higher')</span>
            @endif

            <div style="clear:both;"></div>
            <br>

            @if(!empty($item->description))
                <p>{!! $item->description !!}</p>
                @endisset
        </div>
        <!-- content -->

        <a class="download_bttn" href="{{ route('download.contentitem', $item) }}">
            @lang('portal.play')
        </a>
        <!-- download_bttn -->

    </div>
    <!-- content_wrapper -->

</div>
<!-- detail_game_wrapper -->

@section('scripts')

    <script type="text/javascript">
        setDownloadBttnHeight();

        $(window).resize(function (e) {
            setDownloadBttnHeight();
        });

        function setDownloadBttnHeight() {
            if ($(window).width() < 768) {
                var footer_height = $('.footer').outerHeight();
                console.log(footer_height);
                $(".download_bttn").css('bottom', footer_height + 'px');
                $(".download_bttn").show();
            }
        }

    </script>

@endsection

