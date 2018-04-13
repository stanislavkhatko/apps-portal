@foreach(Config::get('currentPortal')->priceBanners as $priceBanner)
    @if (App::getLocale() == $priceBanner->lang_code && $priceBanner->visible == 1)
        <a class="app-pricebanner"
           href="{{ Config::get('currentPortal')->offer_url ? Config::get('currentPortal')->offer_url: '#' }}">
            {!! $priceBanner->body !!}
        </a>
    @endif
@endforeach
