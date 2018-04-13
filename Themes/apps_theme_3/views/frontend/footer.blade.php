{{-- <div class="footer">
    @foreach(\Config::get('currentPortal')->pages as $page)
    <a href="{{ route('view.page', $page) }}">{{ $page->title }}</a>
    @endforeach
    @if (! empty(\Cookie::get('subscription')) && subscription('status') == 'confirmed')
        <a href="{{ route('subscription.cancel') }}">@lang('portal.cancel')</a>
    @endif
</div>
 --}}

<div class="footer">

    @if ($footer['content']['text'])
        {{ $footer['content']['text'] }}&nbsp; -
    @endif

    @foreach(\Config::get('currentPortal')->dynamicPages as $page)
        @if (App::getLocale() == $page->lang_code)
            &nbsp;<a href="{{ route('view.page', $page) }}">{{ $page->title }}</a>
        @endif
    @endforeach

    @if (session()->has('subscription') && Config::get('currentPortal')->options['show_cancel_page']['value'])
        <a href="{{ route('subscription.cancel') }}">
            &nbsp; - &nbsp;@lang('portal.cancel')
        </a>
    @endif

</div>
<!-- footer -->

