<!DOCTYPE html>
<html lang="en-gb" dir="ltr" class="uk-height-1-1">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js"
            integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.4/js/uikit.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/uikit/2.26.4/css/uikit.min.css"/>
    <link rel="stylesheet" href={{@asset('css/app.css')}}>
    <title>#fsociety</title>
</head>

<body class="uk-height-1-1">
@include('layout/_nav')
@yield('content')
@yield('scripts')
</body>
</html>