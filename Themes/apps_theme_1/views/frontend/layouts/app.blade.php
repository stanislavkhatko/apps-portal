<!DOCTYPE html>
<html lang="en">
<head>

    @php
        $config = json_decode(Config::get('currentPortal')->config, true);

        $header = $config['components']['header'];
        $navbar = $config['components']['navbar'];
        $body = $config['components']['body'];
        $center = $config['components']['center'];
        $footer = $config['components']['footer'];
    @endphp

    <title>{{ $navbar['content']['title'] }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext,vietnamese"
          rel="stylesheet">
    <link rel="shortcut icon" href="{{ $config['components']['navbar']['content']['image'] }}">

    <style type="text/css">

        :root {
            --main-bg-color: {{ $body['style']['background_color']['hex'] }};

            --logo-text-align: {{ $navbar['style']['brand_text_align'] }};
            --logo-text-color: {{ $navbar['style']['brand_color']['hex'] }};
            --logo-font-size: {{ $navbar['style']['brand_font_size'] }}px;
            --logo-font-weight: {{ $navbar['style']['brand_font_weight'] }};

            --header-bg-color: {{ $header['style']['background_color']['hex'] }};
            --header-color: {{ $header['style']['color']['hex'] }};
            --header-font-size: {{ $header['style']['font_size'] }}px;
            --header-font-weight: {{ $header['style']['font_weight'] }};
            --header-border-size: {{ $header['style']['border_bottom_size'] }}px;
            --header-border-color: {{ $header['style']['border_color']['hex'] ?? 'transparent' }};
            --header-min-height: {{ $header['style']['height'] }}px;
            --header-menu-align: {{ $navbar['style']['menu_float'] }};

            --navbar-bg-color: {{ $navbar['style']['background_color']['hex'] }};
            --navbar-color: {{ $navbar['style']['color']['hex'] }};
            --navbar-font-weight: {{ $navbar['style']['font_weight'] }};
            --navbar-font-size: {{ $navbar['style']['font_size'] }}px;
            --navbar-border-size: {{ $navbar['style']['border_bottom_size'] }}px;
            --navbar-border-color: {{ $navbar['style']['border_color']['hex'] }};
            --navbar-min-height: {{ $navbar['style']['height'] }}px;

            --content-color: {{ $center['style']['content_color']['hex'] ?? '#252525' }};
            --content-primary-color: {{ $center['style']['content_primary_color']['hex'] ?? '#1cdd6e' }};
            --content-secondary-color: {{ $center['style']['content_secondary_color']['hex'] ?? '#b0b0b0' }};
            --content-width: {{ $center['style']['content_width'] ?? 1024 }}px;
            --content-bg-color: {{ $center['style']['background_color']['hex'] }};
            --content-border-size: {{ $center['style']['border_left_right_size'] }}px;
            --content-border-color: {{ $center['style']['border_color']['hex'] ?? 'transparent' }};

            --button-font-size: {{ $center['style']['button_font_size'] }}px;
            --button-color: {{ $center['style']['button_color']['hex'] }};
            --button-bg-color: {{ $center['style']['button_background_color']['hex'] }};
            --button-border-size: {{ $center['style']['button_border_size'] }}px;
            --button-border-color: {{ $center['style']['button_border_color']['hex'] ?? 'transparent' }};

            --footer-bg-color: {{ $footer['style']['background_color']['hex'] }};
            --footer-text-align: {{ $footer['style']['text_align'] }};
            --footer-color: {{ $footer['style']['color']['hex'] }};
            --footer-font-size: {{ $footer['style']['font_size'] }}px;
            --footer-font-weight: {{ $footer['style']['font_weight'] }};
            --footer-border-size: {{ $footer['style']['border_top_size'] }}px;
            --footer-border-color: {{ $footer['style']['border_color']['hex'] ?? 'transparent' }};
            --footer-min-height: {{ $footer['style']['height'] }}px;
        }

        .app-pricebanner {
            background-color: {{ $header['style']['background_color']['hex'] }};
            text-align: {{ $header['style']['text_align'] }};
            color: {{ $header['style']['color']['hex'] }};
            font-size: {{ $header['style']['font_size'] }}px;
            font-weight: {{ $header['style']['font_weight'] }};
            border-bottom: {{ $header['style']['border_bottom_size'] }}px solid{{ $header['style']['border_color']['hex'] ?? 'transparent' }};
            min-height: {{ $header['style']['height'] }}px;
        }

    </style>

    <link rel="stylesheet" href="{{ themes('css/apps_theme_1.css') }}">

    <style type="text/css">
        {!! Config::get('currentPortal')->custom_css  !!}
    </style>
<body>

<div class="app">

    <!-- TODO make styling -->
    {{--    @include('frontend.partials.pricebanner')--}}

    <header class="app-header">

        <div class="app-header--wrapper">

            <!-- Collapsed Hamburger -->
            <button class="app-header__menu-toggle">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Branding Image -->
            <div class="app-header-logo">
                <a class="app-header-logo__link" href="{{ url('/') }}">

                    @if ($navbar['content']['image'])
                        <img src="{{ $navbar['content']['image'] }}">
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

            @if (count(Config::get('currentPortal')->languages) > 1)

                <div class="app-header__language">

                    <a class="dropdown-trigger"
                       href="#">{{ App::getLocale() }}</a>
                    <ul class="dropdown-menu">

                        @foreach (Config::get('currentPortal')->languages as $language)

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
            @foreach (Config::get('currentPortal')->localContentTypes as $contentType)
                <a href="{{ route('view.categories', $contentType) }}" title="{{ $contentType->label }}"
                   class="app-navbar-menu-item {{ Request::segment(2) == $contentType->id ? 'active' : ''  }}">

                    @if ($contentType->icon)
                        <img src="{{ $contentType->icon }}" class="app-navbar-menu-item__icon"
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

    @include('frontend.footer')

</div>

<script type="text/javascript">
    (function () {
        @if (Config::get('currentPortal')->exit_url)
            window.onbeforeunload = function () {
            window.setTimeout(function () {
                window.location = '{{ Config::get('currentPortal')->exit_url }}';
            }, 0);
            window.onbeforeunload = null;
            return 'Press "Stay On Page" to be redirected';
        };
        @endif

        // $('.app-header__menu-toggle').click(function () {
        //     $(this).toggleClass('open');
        // });
    }());
</script>

@yield('scripts')

</body>
</html>
