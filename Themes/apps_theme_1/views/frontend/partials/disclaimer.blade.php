@foreach(Config::get('currentPortal')->disclaimers as $disclaimer)
    @if (App::getLocale() == $disclaimer->lang_code)
        {!! $disclaimer->body !!}
    @endif
@endforeach