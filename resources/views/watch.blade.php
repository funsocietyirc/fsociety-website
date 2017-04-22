<html>
    <head>
        <title>Watch YouTube - Powered By MrNodeBot</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="csrf-token" content="{{csrf_token()}}"/>
        <meta name="csrf-param" content="_token"/>
        {{--<script src="https://bot.fsociety.guru/socket.io/socket.io.js"></script>--}}
        <script src="http://192.168.1.2:8084/socket.io/socket.io.js"></script>

        <script src="{{elixir('js/laroute.js')}}"></script>
        <script src="{{elixir('js/app.js')}}"></script>
        <link rel="stylesheet" href={{elixir('css/uikit.css')}}>
        <link rel="stylesheet" href={{elixir('css/app.css')}}>
    </head>
    <body>
        <script>
            const activeChannel = '{{$activeChannel}}';
        </script>
        <div id="vue">
            <watch-youtube></watch-youtube>
        </div>
        <script src="{{elixir('js/vue.js')}}"></script>
    </body>
</html>