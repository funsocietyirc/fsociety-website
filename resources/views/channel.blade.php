@extends('layout._main')
@section('title', $channel . ' Usage Statistics' . isset($nick) ? 'For ' . strtoupper($nick) : '' )
@section('content')
    <div class="uk-grid uk-container-center">
        <div class="uk-width-1-1 uk-text-center uk-margin-bottom uk-margin-top">
            <h1>{{strtoupper($channel)}} Usage Statistics {!! isset($nick) ? 'For ' . strtoupper($nick) : '' !!}</h1>
        </div>

        <div class="uk-width-1-1">
            <div class="uk-panel">
                <div id="vue">
                    <channel-usage channel-name="{!! $channel !!}" nick-name="{!! isset($nick) ? $nick : '' !!}"></channel-usage>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('head-script')
    <script>
        var channel = '{!! $channel !!}';;
        var nick = '{!! isset($nick) ? $nick : '' !!}';
    </script>
    <script src="{{elixir('js/vue.js')}}"></script>
@endsection