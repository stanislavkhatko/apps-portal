<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $item->titleTranslated }}</title>
    <style>
        body {
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }

        iframe {
            width: 100%;
            min-height: 100vh;
        }
        
    </style>
</head>
<body>
<iframe src="{{ $item->download['link'] }}" style="position:fixed; top:0px; left:0px; bottom:0px; right:0px; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden; z-index:999999;">
    @lang('portal.not_supported_iframes')
</iframe>
</body>
</html>