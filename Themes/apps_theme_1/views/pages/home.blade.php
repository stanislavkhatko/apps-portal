@extends('pages.index')

@section('content')

    <!-- TODO make styling -->
{{--    <div class="app-newsflash">
        @foreach(Config::get('currentPortal')->newsSliders as $newsSlider)
            @if (App::getLocale() == $newsSlider->lang_code)
                @if ($newsSlider->visible == 1)
                    <marquee behavior="scroll" direction="left">
                        {!! $newsSlider->body !!}
                    </marquee>
                @endif
            @endif
        @endforeach
    </div>--}}

    @if(count($portal->activeFeaturedItems))
        <div class="app-featured">
            <div class="app-featured-title">
                @lang('portal.top_free_games')
            </div>
            <div class="app-featured-items">
                @foreach($portal->activeFeaturedItems as $item)
                    <a href="{{ route('play-trial.contentitem', $item) }}" class="app-featured-item">
                        <img src="{{ '/cache/fit489x275' . $item->pivot->banner }}"
                             class="app-featured-item__banner">
                    </a>
                @endforeach
            </div>
        </div>
    @endif


    @include('partials.categories', ['categories' => $portal->localContentTypes])

@endsection
