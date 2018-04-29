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
    @foreach(\Config::get('currentPortal')->dynamicPages as $page)
        @if (App::getLocale() == $page->lang_code)
            <a href="{{ route('view.page', $page) }}">{{ $page->title }}</a>
        @endif
    @endforeach

    @if (session()->has('subscription') && Config::get('currentPortal')->options['show_cancel_page']['value'])
        <a href="{{ route('subscription.cancel') }}">
            @lang('portal.cancel')
        </a>
    @endif

    @if ($footer['content']['text'])
        <div style="font-size: 14px;display: block; margin-top: 0px;padding-bottom: 10px;">
            {{ $footer['content']['text'] }}
        </div>
    @endif

</div>
<!-- footer -->
