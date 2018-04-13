@foreach(Config::get('currentPortal')->newsSliders as $newsSlider)
    @if (App::getLocale() == $newsSlider->lang_code)
        @if ($newsSlider->visible == 1)

            <div class="container">

                <div class="newsflash_banner">
                    <marquee behavior="scroll" direction="left">
                        {!! $newsSlider->body !!}
                    </marquee>
                </div>

                <!-- newsflash_banner -->
                <div style="clear:both;"></div>

            </div>
            <!-- container -->
        @endif
    @endif
@endforeach

