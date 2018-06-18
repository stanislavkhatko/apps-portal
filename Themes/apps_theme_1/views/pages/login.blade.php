@extends('pages.index')

@section('title', trans('portal.login'))

@section('content')

    <div class="app-auth">
        @include('partials.back')
        <div class="app-auth__title">
            @lang('portal.login')
        </div>

        <form action="/authenticate" method="post" class="app-auth-form">
            {{ csrf_field() }}
            <label for="msisdn" class="app-auth-form__label">@lang('portal.msisdn')</label>

            <div class="app-auth-form-input">
                @if(Config::get('currentPortal')->phonecode)
                <input type="hidden" name="phonecode" value="{{ Config::get('currentPortal')->phonecode }}">
                <span class="app-auth-form__phonecode" >{{ Config::get('currentPortal')->phonecode }}</span>
                @endif
                <input class="app-auth-form__msisdn" autofocus placeholder="@lang('portal.msisdn_format')" name="msisdn"
                       value="{{ old('msisdn') }}" required min="6"/>
            </div>


            @if (session('error'))
                <div class="app-auth-form__error">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('subscribe'))

                @if(session('subscribe')['sms'])
                    <a href="{{ session('subscribe')['sms'] }}" class="app-auth-form__submit">
                        @lang('portal.subscribe')
                    </a>
                @endif

                <div class="app-auth-form-subscribe">
                    <button type="submit" class="app-auth-form-subscribe__login">@lang('portal.login')</button>
                    </br>

                    @lang('portal.send_sms')

                    <div class="app-auth-form-subscribe__keyword">
                        {{ session('subscribe')['keyword'] }}
                    </div>

                    @lang('portal.to')

                    <div class="app-auth-form-subscribe__shortcode">
                        {{ session('subscribe')['shortcode'] }}
                    </div>
                </div>

            @else
                <button type="submit" class="app-auth-form__submit">@lang('portal.login')</button>

            @endif


            <div class="app-auth-form-price">

                @foreach(Config::get('currentPortal')->priceBanners as $priceBanner)
                    @if (App::getLocale() == $priceBanner->lang_code)
                        {!! $priceBanner->body !!}
                    @endif
                @endforeach

            </div>

            <div class="app-auth-form-disclaimer">
                @foreach(Config::get('currentPortal')->disclaimers as $disclaimer)
                    @if (App::getLocale() == $disclaimer->lang_code)
                        {!! $disclaimer->body !!}
                    @endif
                @endforeach
            </div>

        </form>

    </div>


@endsection
