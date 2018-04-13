@extends('frontend.layouts.app')

@section('content')
    <div id="app" class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                
                <div style="padding: 15px;">
                   
                    <h1>@lang('portal.login')</h1>
                    <form action="authenticate" method="post">
                        {{ csrf_field() }}
                        <div class="form-group @if (session('loginError')) has-error @endif">
                            <label for="msisdn">@lang('portal.msisdn')</label>
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
        </div>
    </div>
@endsection


