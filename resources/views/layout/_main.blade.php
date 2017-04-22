<!DOCTYPE html>
<html lang="en-us" dir="ltr" class="uk-height-1-1">
<head>
    <title>FSociety - @yield('title')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}"/>
    <meta name="csrf-param" content="_token"/>
    <meta name="description" content="Community content driven site made in homage to the critically acclaimed series Mr. Robot."/>
    <meta name="robots" content="noindex,follow,noodp"/>
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="object" />
    <meta property="og:title" content="FSociety - Welcome" />
    <meta property="og:description" content="Community content driven site made in homage to the critically acclaimed series Mr. Robot." />
    <meta property="og:url" content="{{Request::url()}}" />
    <meta property="og:site_name" content="FSociety" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:description" content="Community content driven site made in homage to the critically acclaimed series Mr. Robot." />
    <meta name="twitter:title" content="FSociety" />
    <meta name="twitter:site" content="@funsocietyirc" />
    @yield('meta')
    <script src="https://bot.fsociety.guru/socket.io/socket.io.js"></script>
    <script src="{{elixir('js/laroute.js')}}"></script>
    <script src="{{elixir('js/app.js')}}"></script>
    <script src="{{elixir('js/sockets.js')}}"></script>
    <link rel="stylesheet" href={{elixir('css/uikit.css')}}>
    <link rel="stylesheet" href={{elixir('css/app.css')}}>
    @yield('head-style')
    @yield('head-script')
</head>
<body class="@if(isset($fullHeight))uk-height-1-1 @endif">
@include('layout/_nav')
@include('flash::message')
@yield('content')
@include('layout/_footer')
@yield('scripts')
</body>
</html>