@foreach(Config::get('currentPortal')->priceBanners as $priceBanner)
    @if (App::getLocale() == $priceBanner->lang_code)
        {!! $priceBanner->body !!}
    @endif
@endforeach
