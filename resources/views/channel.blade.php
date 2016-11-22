@extends('layout._main')
@section('title', $channel . ' Statistics')
@section('content')
    <div id="vue">
        <channel-usage channel-name="{!! $channel !!}"></channel-usage>
    </div>
@endsection
@section('head-script')
    <script>
        var channel = '{!! $channel !!}';
    </script>
    <script src="{{elixir('js/vue.js')}}"></script>
@endsection