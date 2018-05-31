@extends('master')

@section('body')

    @php

        $portal = Config::get('currentPortal');
        $config = json_decode($portal->config, true);

        $header = $config['components']['header'];
        $navbar = $config['components']['navbar'];
        $body = $config['components']['body'];
        $center = $config['components']['center'];
        $footer = $config['components']['footer'];

    @endphp

    <div class="app">

        <header class="app-header">
            <div class="app-header--wrapper">

                <!-- Collapsed Hamburger -->
                <button class="app-header__menu-toggle" id="menu-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>

                <!-- Branding Image -->
                <div class="app-header-logo">
                    <a class="app-header-logo__link" href="{{ url('/') }}">

                        @if ($navbar['content']['image'])
                            <img src="{{ '/cache/original' . $navbar['content']['image'] }}">
                        @endif
                        {{ $navbar['content']['title'] }}
                    </a>
                </div>

                <div class="app-header__search" title="@lang('portal.search')">
                    <!-- Search field -->
                    <div class="search-bar">

                        <form action="/search" method="POST" class="form-group">
                            {{ csrf_field() }}

                            <input type="text" name="search" placeholder="@lang('portal.search')" required minlength="4"
                                   value="{{ $search ?? '' }}">
                            <div class="search-icon"></div>
                        </form>
                    </div>

                </div>

                <div class="app-header__auth">

                    <!-- Authentication Links -->
                    @if(!session()->has('subscription'))
                        <a href="/authenticate" class="app-header__auth-login" title="@lang('portal.login')">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                 id="Capa_1" x="0px" y="0px" width="708.631px" height="708.631px"
                                 viewBox="0 0 708.631 708.631"
                                 style="enable-background:new 0 0 708.631 708.631;" xml:space="preserve">
                        <g>
                            <g>
                                <polygon
                                        points="177.158,499.264 177.158,708.631 660.315,708.631 660.315,0 177.158,0 177.158,209.369 209.368,209.369     209.368,32.21 628.104,32.21 628.104,676.422 209.368,676.422 209.368,499.264   "/>
                                <polygon
                                        points="48.315,370.357 459,370.357 370.421,515.369 402.631,515.369 499.263,354.316 402.631,193.263 370.421,193.263     459,338.21 48.315,338.21   "/>
                            </g>
                        </g>
                    </svg>
                        </a>
                    @else
                        <a href="{{ route('logout') }}" title="@lang('portal.logout')"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                           class="app-header__auth-logout">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1"
                                 id="Capa_1" x="0px" y="0px" width="612px" height="612px" viewBox="0 0 612 612"
                                 style="enable-background:new 0 0 612 612;" xml:space="preserve">
                    <g>
                        <g>
                            <polygon
                                    points="222.545,319.909 577.228,319.909 500.728,445.091 528.546,445.091 612,306 528.546,166.909 500.728,166.909     577.228,292.146 222.545,292.146   "/>
                            <polygon
                                    points="0,612 417.272,612 417.272,431.182 389.454,431.182 389.454,584.182 27.818,584.182 27.818,27.818     389.454,27.818 389.454,180.818 417.272,180.818 417.272,0 0,0   "/>
                        </g>
                    </g>
                    </svg>
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    @endif
                </div>

                @if (count($portal->languages) > 1)

                    <div class="app-header__language">

                        <a class="dropdown-trigger"
                           href="#">{{ App::getLocale() }}</a>
                        <ul class="dropdown-menu">

                            @foreach ($portal->languages as $language)

                                @if (App::getLocale() !== $language)
                                    <li class="dropdown-menu-item">
                                        <a href="{{ route('view.change.language') }}"
                                           onclick="event.preventDefault(); document.getElementById('change-language-form-{{ $loop->index }}').submit();">
                                            {{ $language }}
                                        </a>
                                    </li>
                                @endif

                                <form id="change-language-form-{{ $loop->index }}"
                                      action="{{ route('view.change.language') }}" method="POST"
                                      style="display: none;">
                                    <input type="hidden" name="locale" value="{{ $language }}">
                                    {{ csrf_field() }}
                                </form>

                            @endforeach
                        </ul>

                    </div>

                @endif

            </div>

        </header>

        <nav class="app-navbar">
            <div class="app-navbar-menu">
                @foreach ($portal->localContentTypes as $contentType)
                    <a href="{{ route('view.categories', $contentType) }}" title="{{ $contentType->label }}"
                       class="app-navbar-menu-item {{ Request::segment(2) == $contentType->id ? 'active' : ''  }}">

                        @if ($contentType->icon)
                            <img src="{{ '/cache/original' . $contentType->icon }}" class="app-navbar-menu-item__icon"
                                 alt="{{ $contentType->label }}">
                        @endif

                        <div class="app-navbar-menu-item__label">
                            {{ $contentType->label }}
                        </div>
                    </a>
                @endforeach
            </div>
        </nav>


        <div class="app-content">
            @yield('content')
        </div>

        <div class="app-footer">
            <div class="app-footer--wrapper">
                <div class="app-footer-pages">
                    @foreach($portal->dynamicPages as $page)
                        @if (App::getLocale() == $page->lang_code)
                            <a href="{{ route('view.page', $page) }}" class="app-footer__page">
                                {{ $page->title }}
                            </a>
                        @endif
                    @endforeach
                </div>

                @if (session()->has('subscription') && $portal->options['show_cancel_page']['value'])
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
        </div>

    </div>

@endsection