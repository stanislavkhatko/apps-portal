@extends('master')

@section('title', $item->titleTranslated)

@section('body')

    <iframe src="{{ $item->download['link'] }}"
            style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
        @lang('portal.not_supported_iframes')
    </iframe>

@endsection

@section('script')

    <script>
        (function () {
            if (!'{!! session('subscription') && session('subscription')['subscription_id'] !!}') {
                window.setTimeout(function () {
                    window.location.pathname = '/authenticate';
                }, 60000);
            }
        }())
    </script>

@endsection