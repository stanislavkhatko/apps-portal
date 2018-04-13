<div class="app-newsflash">
    @foreach(Config::get('currentPortal')->newsSliders as $newsSlider)
        @if (App::getLocale() == $newsSlider->lang_code)
            @if ($newsSlider->visible == 1)
                <marquee behavior="scroll" direction="left">
                    {!! $newsSlider->body !!}
                </marquee>
            @endif
        @endif
    @endforeach
</div>
