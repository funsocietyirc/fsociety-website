<!DOCTYPE html>
<html lang="en-gb" dir="ltr" class="uk-height-1-1">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="{{elixir('js/app.js')}}"></script>
    <link rel="stylesheet" href={{elixir('css/uikit.css')}}>
    <link rel="stylesheet" href={{elixir('css/app.css')}}>
    @yield('head-style')
    <title>FSociety - @yield('title')</title>
</head>
<body class="@if(isset($fullHeight))uk-height-1-1 @endif">
@include('layout/_nav')
@include('flash::message')
@yield('content')
@yield('scripts')
</body>
</html>