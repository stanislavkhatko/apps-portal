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

            /*--banner-bg-color: ;*/
            /*--banner-text-align:;*/
            /*--banner-color:;*/
            /*--banner-font-size:;*/
            /*--banner-font-weight:;*/
            /*--banner-border-size:;*/
            /*--banner-border-color:;*/
            /*--banner-min-height:;*/

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

        /** navbar **/
        .app-header {
            background-color: {{ $navbar['style']['background_color']['hex'] }};
            border-width: {{ $navbar['style']['border_bottom_size'] }}px;
            border-color: {{ $navbar['style']['border_color']['hex'] }};
            border-style: solid;
        }

        .app-header-navbar {
            min-height: {{ $navbar['style']['height'] }}px;
        }

        .app-header-brand {
            color: {{ $navbar['style']['brand_color']['hex'] }};
            font-weight: {{ $navbar['style']['brand_font_weight'] }};
            font-size: {{ $navbar['style']['brand_font_size'] }}px;
            text-align: {{ $navbar['style']['brand_text_align'] }};
        }

        .navbar-default .navbar-brand:hover,
        .navbar-default .navbar-brand:focus {
            color: {{ $navbar['style']['color']['hex'] }};
        }

        .navbar-default .navbar-toggle {
            float: {{ $navbar['style']['menu_float'] }};
        }

        .dropdown {
            color: {{ $navbar['style']['color']['hex'] }};
            font-weight: {{ $navbar['style']['font_weight'] }};
            font-size: {{ $navbar['style']['font_size'] }}px;
        }

        /** end navbar **/

        /** center **/
        .app-content {
            background-color: {{ $center['style']['background_color']['hex'] }};
        }

        /** end center **/

        /** center buttons **/
        .bttn_light_blue {
            font-size: {{ $center['style']['button_font_size'] }}px;
            background-color: {{ $center['style']['button_background_color']['hex'] }};
            color: {{ $center['style']['button_color']['hex'] }};
            border-width: {{ $center['style']['button_border_size'] }}px;
            border-color: {{ $center['style']['button_border_color']['hex'] }};
            border-style: solid;
        }

        .download_bttn {
            font-size: {{ $center['style']['button_font_size'] }}px;
            background-color: {{ $center['style']['button_background_color']['hex'] }};
            color: {{ $center['style']['button_color']['hex'] }};
            border-width: {{ $center['style']['button_border_size'] }}px;
            border-color: {{ $center['style']['button_border_color']['hex'] }};
            border-style: solid;
        }

        .app_section .flickity-prev-next-button.previous, .app_section .flickity-prev-next-button.next {
            background-color: {{ $center['style']['button_background_color']['hex'] }};
        }

        .pagination_wrapper .pagination > .active > span {
            background-color: {{ $center['style']['button_background_color']['hex'] }};
            border-color: {{ $center['style']['button_background_color']['hex'] }};
        }

        .pagination_wrapper .pagination > li > a, .pagination_wrapper .pagination > .disabled > span {
            color: {{ $center['style']['button_background_color']['hex'] }};
            border: 1px solid{{ $center['style']['button_background_color']['hex'] }};
        }

        .pagination_wrapper .pagination > .active > span {
            color: {{ $center['style']['button_color']['hex'] }};
        }

    </style>

    <link rel="stylesheet" href="{{ themes('css/apps_theme_1.css') }}">

    <style type="text/css">
        {!! Config::get('currentPortal')->custom_css  !!}
    </style>
<body>

<div class="app">

    @include('frontend.partials.pricebanner')

    <header class="app-header">

        <!-- Collapsed Hamburger -->
        <button class="app-header__menu-toggle">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </button>

        <!-- Branding Image -->
        <a class="app-header-logo" href="{{ url('/') }}">

            @if ($navbar['content']['image'])
                <img src="{{ $navbar['content']['image'] }}">
            @endif
            {{ $navbar['content']['title'] }}
        </a>

        <div class="app-header__search">

        </div>

        <div class="app-header__login">

        </div>

        <div class="app-header__language">

        </div>

        <!-- Search field -->
        <form action="/search" method="POST" class="form-group">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="@lang('portal.search')"
                       required
                       minlength="5">
                <span class="input-group-btn">
                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"
                                                                            aria-hidden="true"></span></button>
                    </span>
            </div>
            {{ csrf_field() }}
        </form>

        <!-- Authentication Links -->
        @if(! session()->has('subscription'))
            <li>
                <a href="/authenticate" class="btn btn-default">
                    @lang('portal.login')
                </a>
            </li>
        @else
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                   aria-expanded="false">
                    {{ session('subscription')['msisdn'] }} <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class="fa fa-fw fa-btn fa-sign-out"></i>
                            @lang('portal.logout')
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                              style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
        @endif

        @if (count(Config::get('currentPortal')->languages) > 1)
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button"
                   aria-expanded="false">
                    <span class="flag-icon flag-icon-{{ Config::get('currentPortal')->getCountryIcon(App::getLocale()) }}"></span>
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        @foreach (Config::get('currentPortal')->languages as $language)

                            @if (App::getLocale() !== $language)
                                <a href="{{ route('view.change.language') }}"
                                   onclick="event.preventDefault(); document.getElementById('change-language-form-{{ $loop->index }}').submit();">
                                    <span class="flag-icon flag-icon-{{ Config::get('currentPortal')->getCountryIcon($language) }}"></span>
                                </a>
                            @endif

                            <form id="change-language-form-{{ $loop->index }}"
                                  action="{{ route('view.change.language') }}" method="POST"
                                  style="display: none;">
                                <input type="hidden" name="locale" value="{{ $language }}">
                                {{ csrf_field() }}
                            </form>

                        @endforeach
                    </li>
                </ul>
            </li>
        @endif
    </header>

    <div class="app-menu collapse" id="app-navbar-collapse">
        <div class="app-menu_wrapper">

            <a href="{{ url('/') }}" class="app-menu_item {{ Request::segment(1) == 'portal' ? 'active' : ''  }}">
                <div class="app-menu_icon">
                    <img src="/img/home.png" class="img-responsive">
                </div>
                <div class="app-menu_txt">
                    Home<br/>
                </div>
            </a>

            @foreach (Config::get('currentPortal')->localContentTypes as $contentType)
                <a href="{{ route('view.categories', $contentType) }}"
                   class="app-menu_item {{ Request::segment(2) == $contentType->id ? 'active' : ''  }}">
                    <div class="app-menu_icon">
                        @if ($contentType->icon)
                            <img src="{{ $contentType->icon }}" class="img-responsive"
                                 alt="{{ $contentType->label }}">
                        @else
                            <img src="/img/home.png" class="img-responsive" alt="{{ $contentType->label }}">
                        @endif
                    </div>

                    <div class="app-menu_txt" title="{{ $contentType->label }}">
                        {{ $contentType->label }}
                    </div>
                </a>
            @endforeach

        </div>
    </div>

    <div class="app-content">
        @yield('content')
    </div>

@include('frontend.footer')

<!-- Scripts -->
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">
    $(function () {
        @if (Config::get('currentPortal')->exit_url)
            window.onbeforeunload = function () {
            window.setTimeout(function () {
                window.location = '{{ Config::get('currentPortal')->exit_url }}';
            }, 0);
            window.onbeforeunload = null;
            return 'Press "Stay On Page" to be redirected';
        };
        @endif


        $('.app-header__menu-toggle').click(function () {
            $(this).toggleClass('open');
        });
    });
</script>

@yield('scripts')
</body>
</html>
