@foreach(\Config::get('currentPortal')->disclaimers as $disclaimer)
    @if (App::getLocale() == $disclaimer->lang_code)

        <div class="row">
            <div class="col-sm-12 disclaimer">
                {!! $disclaimer->body !!}
            </div>
        </div>

    @endif
@endforeach