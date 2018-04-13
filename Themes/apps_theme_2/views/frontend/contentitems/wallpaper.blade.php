<div class="app_wrap carousel-cell">

    <div class="app_thumb_wrapper">

        @if ($item->type == 'flash')
            <div class="app_thumb" style="background-image: url('/img/music.jpg')">
                @elseif ($item->type == 'mp3')
                    <div class="app_thumb" style="background-image: url('/img/mp3.png')">
                        @else
                            <div class="app_thumb" style="background-image: url('{{ $item->preview }}')">
                                @endif

                                <a href="{{ route('view.contentitem', [$item]) }}"></a>
                            </div>
                            <!-- app_thumb -->
                    </div>
                    <!-- app_thumb_wrapper -->

                    <div class="app_name">
                        {{ $item->title }}
                    </div>
                    <!-- app_name -->

            </div>
            <!-- app_wrap -->
