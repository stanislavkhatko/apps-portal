<div class="app-footer">
    @foreach(Config::get('currentPortal')->dynamicPages as $page)
        @if (App::getLocale() == $page->lang_code)
            <a href="{{ route('view.page', $page) }}" class="app-footer__page">
                {{ $page->title }}
            </a>
        @endif
    @endforeach

    @if (session()->has('subscription') && Config::get('currentPortal')->options['show_cancel_page']['value'])
        <a href="{{ route('subscription.cancel') }}" class="app-footer__cancel">
            @lang('portal.cancel')
        </a>
    @endif

    @if ($footer['content']['text'])
        <div class="app-footer__copyright">
            {{ $footer['content']['text'] }}
        </div>
    @endif
</div>
