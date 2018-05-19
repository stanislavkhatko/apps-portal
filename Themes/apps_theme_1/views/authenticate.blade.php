@extends('frontend.layouts.app')

@section('content')

    <div class="app-auth">
        @include('frontend.partials.back')
        <div class="app-auth__title">
            @lang('portal.login')
        </div>

        <form action="/authenticate" method="post" class="app-auth-form">
            {{ csrf_field() }}
            <label for="msisdn" class="app-auth-form__label">@lang('portal.msisdn')</label>
            <input class="app-auth-form__msisdn" autofocus placeholder="@lang('portal.msisdn')" name="msisdn"
                   value="{{ old('msisdn') }}" required min="6"/>

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
                    <button type="submit" class="app-auth-form-subscribe__login">@lang('portal.login')</button></br>

                    @lang('portal.send_sms')

                    <div class="app-auth-form-subscribe__keyword">
                        {{ session('subscribe')['keyword'] }}
                    </div>

                    @lang('portal.to')

                    <div class="app-auth-form-subscribe__shortcode">
                        {{ session('subscribe')['shortcode'] }}
                    </div>
                </div>

                <div class="app-auth-form-price">
                    @lang('portal.subscription_price') {{ session('subscribe')['price'] }} @lang('portal.' . session('subscribe')['currency'])
                </div>

            @else
                <button type="submit" class="app-auth-form__submit">@lang('portal.login')</button>
            @endif
        </form>

    </div>


@endsection
