@php
    $config = json_decode(Config::get('currentPortal')->config, true);
    //dd($config);

    $header = $config['components']['header'];
    $navbar = $config['components']['navbar'];
    $body = $config['components']['body'];
    $center = $config['components']['center'];
    $footer = $config['components']['footer'];

    $components2 = $config['components2'];
@endphp


        <!DOCTYPE html>
<html lang="en">
<head>
    <title></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=0">

    <link rel="stylesheet" href="{{ themes('css/apps_theme_3.css') }}?{{ date('YmdHis') }}">

    <style type="text/css">

        .header_brand_wrapper {
            color: {{ $navbar['style']['brand_color']['hex'] }};
            font-weight: {{ $navbar['style']['brand_font_weight'] }};
            font-size: {{ $navbar['style']['brand_font_size'] }}px;
            text-align: {{ $navbar['style']['brand_text_align'] }};
        }

        /** navbar **/
        .nav_wrapper {
            background-color: {{ $navbar['style']['background_color']['hex'] }};
            border-bottom-width: {{ $navbar['style']['border_bottom_size'] }}px;
            border-bottom-color: {{ $navbar['style']['border_color']['hex'] }};
            border-bottom-style: solid;
            color: {{ $navbar['style']['color']['hex'] }};
            font-size: {{ $navbar['style']['font_size'] }}px;
            font-weight: {{ $navbar['style']['font_weight'] }};
        }

        .carousel-inner .play_bttn {
            background-color: {{ $navbar['style']['background_color']['hex'] }};
            color: {{ $navbar['style']['color']['hex'] }};
        }

        .carousel-indicators .active {
            background-color: {{ $navbar['style']['background_color']['hex'] }};
        }

        .carousel-indicators li {
            border: 1px solid {{ $navbar['style']['background_color']['hex'] }};
        }

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

        .navbar-default .navbar-brand {
            color: {{ $navbar['style']['brand_color']['hex'] }};
            font-weight: {{ $navbar['style']['brand_font_weight'] }};
            font-size: {{ $navbar['style']['brand_font_size'] }}px;
            @if ($navbar['style']['brand_text_align'] == 'center')
                  transform: translateX(-50%);
            left: 50%;
            position: absolute;
            @endif 
              min-height: {{ $navbar['style']['height'] }}px;
        }

        .navbar-default .navbar-nav .open .dropdown-menu > li > a {
            color: {{ $navbar['style']['brand_color']['hex'] }};
        }

        .navbar-default .navbar-toggle .icon-bar {
            background-color: {{ $navbar['style']['brand_color']['hex'] }};
        }

        .navbar-default .navbar-brand:hover,
        .navbar-default .navbar-brand:focus {
            color: {{ $navbar['style']['color']['hex'] }};
        }

        .navbar-default .navbar-nav .open .dropdown-menu > li > a {
            color: {{ $navbar['style']['color']['hex'] }};
        }

        .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover, .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
            color: {{ $navbar['style']['color']['hex'] }};
        }

        .navbar-default .navbar-toggle:hover, .navbar-default .navbar-toggle:focus {
            background-color: transparent !important;
        }

        .navbar-default .navbar-nav > .open > a, .navbar-default .navbar-nav > .open > a:hover, .navbar-default .navbar-nav > .open > a:focus {
            color: {{ $navbar['style']['color']['hex'] }};
            background-color: transparent;
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
            border: 1px solid {{ $center['style']['button_background_color']['hex'] }};
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

        .footer, .footer a {
            font-weight: {{ $footer['style']['font_weight'] }};
            color: {{ $footer['style']['color']['hex'] }};
            font-size: {{ $footer['style']['font_size'] }}px;
        }

        /** end footer **/

        .pagination_wrapper .pagination > .active > span {
            background-color: {{ $navbar['style']['background_color']['hex'] }};
        }

        .pagination_wrapper .pagination > li > a, .pagination_wrapper .pagination > .disabled > span {
            color: {{ $navbar['style']['background_color']['hex'] }};
            border: 1px solid {{ $navbar['style']['background_color']['hex'] }};
        }

        .pagination_wrapper .pagination > .active > span {
            border-color: {{ $navbar['style']['background_color']['hex'] }};
        }


    </style>

    <style type="text/css">
        {!! Config::get('currentPortal')->custom_css !!}
    </style>
<body>

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


<div class="language_wrapper">

    @if (count(Config::get('currentPortal')->languages) > 1)

        {{--  <a class="nav_item" href="#">
             <span class="flag-icon flag-icon-{{ App::getLocale() == 'en' ? 'gb' : App::getLocale() }}"></span>
         </a> --}}

        @foreach (Config::get('currentPortal')->languages as $language)

            @if (App::getLocale() !== $language)
                <a class="nav_item" href="{{ route('view.change.language') }}"
                   onclick="event.preventDefault(); document.getElementById('change-language-form-{{ $loop->index }}').submit();">
                    <span class="flag-icon flag-icon-{{ $language == 'en' ? 'gb' : $language }}"></span>
                </a>
            @endif

            <form id="change-language-form-{{ $loop->index }}" action="{{ route('view.change.language') }}"
                  method="POST" style="display: none;">
                <input type="hidden" name="locale" value="{{ $language }}">
                {{ csrf_field() }}
            </form>

        @endforeach

    @endif

</div>


<div class="header_brand_wrapper">

    <a href="/" class="header_brand_content">
        @if ($navbar['content']['image'])
            <img src="/storage/{{ $navbar['content']['image'] }}" class="img-responsive"/>
        @endif

        @if ($navbar['content']['title'])
            <div class="title">
                {{ $navbar['content']['title'] }}
            </div>
            <!-- title -->
        @endif

        <div style="clear:both;"></div>
    </a>
    <!-- header_brand_content -->

</div>
<!-- header_brand_wrapper -->


<div style="clear:both;"></div>

<div class="nav_wrapper">

    <div class="nav_items_wrapper">

        @foreach (Config::get('currentPortal')->localContentTypes as $localContentType)

            @foreach($localContentType->localCategories as $localCategory)

                <a class="nav_item" href="{{ route('view.category', [$localContentType->id, $localCategory]) }}">
                    {{ $localCategory->label }}
                </a>

            @endforeach

        @endforeach


    <!-- Authentication Links -->
        @if(! session()->has('subscription'))
            <span class="spacerke">-</span>
            <a class="nav_item" href="authenticate">
                @lang('portal.login')
            </a>
        @else
            <span class="spacerke">-</span>
            <a class="nav_item" href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                @lang('portal.logout')
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>

        @endif

    </div>
    <!-- nav_items_wrapper -->
</div>
<!-- nav_wrapper -->

@yield('content')

@include('frontend.footer')
<!-- Scripts -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
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
        }
        @endif
    });

</script>

@yield('scripts')
</body>
</html>
