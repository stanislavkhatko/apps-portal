@extends('frontend.layouts.app')

@section('content')
    <div class="app-unsubscribe">

        <div class="app-unsubscribe__title">
            Unsubscribe
        </div>

        <form method="POST" class="app-unsubscribe-form">
            {{ csrf_field() }}

            <div class="app-unsubscribe-form__title">
                @lang('portal.cancel_subscription')
            </div>

            <div class="app-unsubscribe-form__label">
                @lang('portal.cancel_subscription_description')
            </div>

            <a href="{{ route('home') }}" class="app-unsubscribe-form__submit">
                @lang('portal.back')
            </a>

            <button type="submit" class="app-unsubscribe-form__back">
                @lang('portal.cancel_subscription')
            </button>
        </form>
    </div>
@endsection
