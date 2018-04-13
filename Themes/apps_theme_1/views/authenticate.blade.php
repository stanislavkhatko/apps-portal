@extends('frontend.layouts.app')

@section('content')

        <div class="col-sm-8 col-sm-offset-2">
            <h1>@lang('portal.login')</h1>
            <form action="{{ route('authenticate') }}" method="post">
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

@endsection
