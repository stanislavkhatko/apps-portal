@php

    $config = json_decode(Config::get('currentPortal')->config, true);
    //dd($config);

    $header = $config['components']['header'];
    $navbar = $config['components']['navbar'];
    $body = $config['components']['body'];
    $center = $config['components']['center'];
    $footer = $config['components']['footer'];

@endphp

        <!DOCTYPE html>
<html lang="en">
<head>
    <title>{{ $navbar['content']['title'] }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="https://fonts.googleapis.com/css?family=Titillium+Web:400,700" rel="stylesheet">

    <link rel="stylesheet" href="{{ themes('css/apps_theme_2.css') }}?{{ date('YmdHis') }}">

    <style>

        /** header **/
        .top_banner {
            text-align: {{ $header['style']['text_align'] }};
            background-color: {{ $header['style']['background_color']['hex'] }};
            color: {{ $header['style']['color']['hex'] }};
            font-size: {{ $header['style']['font_size'] }}px;
            font-weight: {{ $header['style']['font_weight'] }};
            min-height: {{ $header['style']['height'] }}px;
            border-bottom-width: {{ $header['style']['border_bottom_size'] }}px;
            border-bottom-color: {{ $header['style']['border_color']['hex'] }};
            @if ($header && $header['style']['border_bottom_size'] > 0)
                          border-bottom-style: solid;
        @endif






        }

        /** end header **/

        /** navbar **/
        .navbar-default {
            background-color: {{ $navbar['style']['background_color']['hex'] }};
            border-bottom-width: {{ $navbar['style']['border_bottom_size'] }}px;
            border-bottom-color: {{ $navbar['style']['border_color']['hex'] }};
            border-bottom-style: solid;
            min-height: {{ $navbar['style']['height'] }}px;
        }

        .navbar-default .navbar-brand {
            color: {{ $navbar['style']['brand_color']['hex'] }};
            font-weight: {{ $navbar['style']['brand_font_weight'] }};
            font-size: {{ $navbar['style']['brand_font_size'] }}px;
            @if ($navbar['style']['brand_text_align'] == 'center')
                          transform: translateX(-50%);
            left: 50%;
            position: absolute;
        @endif






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

        /** body **/
        body {
            background-color: {{ $body['style']['background_color']['hex'] }};
        }

        /** end body **/

        /** center **/
        .portal_container {
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

        /** end center buttons **/

        /** footer **/
        .footer {
            text-align: {{ $footer['style']['text_align'] }};
            min-height: {{ $footer['style']['height'] }}px;
            background-color: {{ $footer['style']['background_color']['hex'] }};
            border-top-width: {{ $footer['style']['border_top_size'] }}px;
            border-top-color: {{ $footer['style']['border_color']['hex'] }};
            @if ($footer && $footer['style']['border_top_size'] > 0)
                          border-top-style: solid;
        @endif






        }

        .footer a {
            font-weight: {{ $footer['style']['font_weight'] }};
            color: {{ $footer['style']['color']['hex'] }};
            font-size: {{ $footer['style']['font_size'] }}px;
        }

    </style>

    <style>
        {!! Config::get('currentPortal')->custom_css  !!}
    </style>
<body>

<!-- Price banner -->
@foreach(Config::get('currentPortal')->priceBanners as $priceBanner)
    @if (App::getLocale() == $priceBanner->lang_code)
        @if ($priceBanner->visible == 1)
            <div class="top_banner" style="padding-top: 12px;cursor: pointer;"
                 @if (Config::get('currentPortal')->offer_url) onclick="location.href='{{ Config::get('currentPortal')->offer_url }}';" @endif>
                {!! $priceBanner->body !!}
            </div>
            <div style="clear:both;"></div>
        @endif
    @endif
@endforeach
<!-- End Price banner -->

<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
                    data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="pull-left">{{ $navbar['content']['title'] }}</div>
                @if ($navbar['content']['image'])
                    <img src="{{ $navbar['content']['image'] }}" class="img-responsive"
                         style="max-height: 50px;position: relative;top: -19px;left:10px;"/>
                @endif
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">

            <form action="/search" method="POST" class="hidden">
                <input type="text" name="search" placeholder="Search name">
                <button type="submit">Search</button>
                {{ csrf_field() }}
            </form>

            <!-- Login/Logout block -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if(! session()->has('subscription'))
                    <li>
                        <a href="/authenticate" style="padding: 0;">
                            <div class="bttn_portal">
                                @lang('portal.login')
                            </div>
                        </a>
                    </li>
                @else
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            {{ session('subscription')['msisdn'] }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

            <!-- Language block -->
                @if (count(Config::get('currentPortal')->languages) > 1)
                    <li class="dropdown">

                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
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

            </ul>
        </div>
    </div>
</nav>

<!-- Menu block -->
<div class="category_menu_banner">
    <div class="container category_menu_wrapper">

        <!-- Home menu item -->
        <a href="{{ url('/') }}" class="category_menu_item {{ Request::segment(1) == 'portal' ? 'active' : ''  }}"
           style="width: 16.66%;">
            <div class="category_menu_icon">
                <img src="/img/home.png" class="img-responsive">
            </div>
            <div class="category_menu_txt">
                @lang('portal.home')
            </div>
        </a>

        <!-- Content type items / Navigation -->
        @foreach (Config::get('currentPortal')->localContentTypes as $contentType)
            <a href="{{ route('view.categories', $contentType) }}"
               class="category_menu_item {{ Request::segment(2) == $contentType->id ? 'active' : ''  }}"
               style="width: 16.66%;">
                <div class="category_menu_icon">
                    <img src="{{ $contentType->icon ?? '/img/home.png' }}" class="img-responsive">
                </div>

                <div class="category_menu_txt">
                    {{ $contentType->label }}
                </div>
            </a>
        @endforeach

    </div>
</div>
<!-- End navigation menu -->

<div id="app" class="container portal_container">
    @yield('content')
</div>


@include('frontend.footer')

<!-- Scripts -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script type="text/javascript">

    $(function () {
        var $featured_carousel = $('.featured_carousel').flickity({
            autoPlay: 3000,
            contain: true,
            wrapAround: false,
            pageDots: false,
            prevNextButtons: false,
            imagesLoaded: true
        });

        $featured_carousel.css({opacity: 1});

        var $carousel = $('.carousel').flickity({
            contain: true,
            wrapAround: false,
            pageDots: false,
            cellAlign: "left",
            imagesLoaded: true
        });

        $carousel.css({opacity: 1});

        @if (Config::get('currentPortal')->exit_url)
            window.onbeforeunload = function () {
            window.setTimeout(function () {
                window.location = '{{ Config::get('currentPortal')->exit_url }}';
            }, 0);
            window.onbeforeunload = null;
            return 'Press "Stay On Page" to be redirected';
        };
        @endif

    });

</script>

@yield('scripts')
</body>
</html>
