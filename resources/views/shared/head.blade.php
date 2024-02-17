<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link type="text/css" rel="stylesheet" href="{{ asset('css/global.css') }}">
    </link>
    <link type="text/css" rel="stylesheet" href="{{ mix('css/webpack/app.min.css') }}">
    </link>

    @foreach ($css ?? [] as $file)
    <link href={{ asset($file) }} type="text/css" rel="stylesheet" />
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ mix('js/webpack/app.min.js') }}"></script>
    <script src="{{ mix('js/webpack/components.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>

    <!-- Adsense config -->
    @if((isset(auth()->user()->id) && auth()->user()->isUser()) || isset($forceAdsense))
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-9415656016814762" crossorigin="anonymous">
    </script>
    @endif

    @foreach ($js ?? [] as $file)
    <script src={{ asset($file) }}></script>
    @endforeach

    <title>{{ $title ?? "QVagas" }}</title>
</head>