@foreach(\Config::get('currentPortal')->disclaimers as $disclaimer)
    @if (App::getLocale() == $disclaimer->lang_code)
        <div class="app-disclaimer">
            {!! $disclaimer->body !!}
        </div>
    @endif
@endforeach