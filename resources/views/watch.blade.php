<html>
    <head>
        <title>Watch Youtube</title>
        <meta name="robots" content="noindex,nofollow">
        <meta name="csrf-token" content="{{csrf_token()}}"/>
        <meta name="csrf-param" content="_token"/>
        <script src="{{elixir('js/laroute.js')}}"></script>
        <script src="{{elixir('js/app.js')}}"></script>
    </head>
    <body>
        <div id="vue">
            <watch-youtube></watch-youtube>
        </div>
        <script src="{{elixir('js/vue.js')}}"></script>
    </body>
</html>