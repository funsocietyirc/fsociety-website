@extends('layout._main')
@section('title', 'IRC Channels Dashboard')
@section('meta')
    <meta name="robots" content="noindex,nofollow">
@endsection
@section('content')
    <div id="vue">
        <channel-dash></channel-dash>
    </div>
@endsection
@section('head-script')
    <script src="{{elixir('js/vue.js')}}"></script>
@endsection