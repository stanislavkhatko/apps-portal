@extends('frontend.layouts.app')

@section('content')

    <div class="app-auth">
        <div class="app-auth__title">
            @lang('portal.login')
        </div>

        <form action="/authenticate" method="post" class="app-auth-form">
            {{ csrf_field() }}
            <label for="msisdn" class="app-auth-form__label">@lang('portal.msisdn')</label>
            <input class="app-auth-form__msisdn" autofocus placeholder="@lang('portal.msisdn')" name="msisdn" value="{{ old('msisdn') }}" required/>

            @if (session('loginError'))
                <div class="app-auth-form__error">
                    {{ session('loginError') }}
                </div>
            @endif

            <button type="submit" class="app-auth-form__submit">@lang('portal.login')</button>
        </form>

    </div>


@endsection
