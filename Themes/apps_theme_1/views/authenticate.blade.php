@extends('frontend.layouts.app')

@section('content')

    <div class="app-auth">
        <div class="app-auth__title">
            @lang('portal.login')
        </div>

        <div class="app-auth-form">

            <form action="/authenticate" method="post">
                {{ csrf_field() }}
                <div class="form-group @if (session('loginError')) has-error @endif">
                    <label for="msisdn">@lang('portal.msisdn')</label>
                    <!--  TODO change to required -->
                    <input class="form-control" name="msisdn" value="{{ old('msisdn') }}" />
                    <span class="help-block">
                            {{ session('loginError') }}
                    </span>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-default">@lang('portal.login')</button>
                </div>
            </form>

        </div>
    </div>


@endsection
