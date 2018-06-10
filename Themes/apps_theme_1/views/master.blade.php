<!DOCTYPE html>
<html lang="en">
<head>

@php

    $portal = Config::get('currentPortal');
    $config = json_decode($portal->config, true);

    $header = $config['components']['header'];
    $navbar = $config['components']['navbar'];
    $body = $config['components']['body'];
    $center = $config['components']['center'];
    $footer = $config['components']['footer'];

@endphp

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async
            src="https://www.googletagmanager.com/gtag/js?id={{ $portal->analytic_tag }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }

        gtag('js', new Date());

        gtag('config', '{{ $portal->analytic_tag }}');
    </script>

    <title>{{ $navbar['content']['title'] }} - @yield('title')</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700&amp;subset=cyrillic,cyrillic-ext,greek,greek-ext,latin-ext"
          rel="stylesheet">
    <link rel="shortcut icon" href="{{ '/cache/original' . $config['components']['navbar']['content']['image'] }}">

    <style type="text/css">

        :root {
            --main-bg-image: url({{ $body['style']['image'] }});
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
            --content-primary-color: {{ $center['style']['content_primary_color']['hex'] ?? '#ff1919' }};
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

    </style>

    <link rel="stylesheet" href="{{ mix('/Themes/apps_theme_1/assets/css/apps_theme_1.css') }}">

    <style type="text/css">
        {!! $portal->custom_css  !!}
    </style>
</head>

<body>

@yield('body')

<script type="text/javascript">
    (function () {
        @if ($portal->exit_url)
            window.onbeforeunload = function () {
            window.setTimeout(function () {
                window.location = '{{ $portal->exit_url }}';
            }, 0);
            window.onbeforeunload = null;
            return 'Press "Stay On Page" to be redirected';
        };
        @endif


        //        var menu = document.getElementById("menu-toggle");
        //        menu.onclick = toggleMenu;
        //        function toggleMenu() {
        //            menu.classList.toggle("open");
        //        }

        document.querySelector('.dropdown-trigger').addEventListener('click', function () {
            this.parentNode.classList.toggle('active')
        }, false);

    }());
</script>

@yield('script')

</body>
</html>
