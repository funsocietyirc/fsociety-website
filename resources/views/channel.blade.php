@extends('layout._main')
@section('title', $channel . ' Usage Statistics ' . (isset($nick) && $nick != '' ? 'For ' . strtoupper($nick) : '') )
@section('content')
    <div class="uk-grid uk-container-center">
        <header class="uk-block  uk-cover-background uk-width-1-1">
            <h1 class="uk-text-truncate uk-text-center">
                <span class="to">{{strtoupper($channel)}}</span> Usage Statistics <span class="from">{{ isset($nick) && $nick != '' ? 'For ' . strtoupper($nick) : ''}}</span>
            </h1>
        </header>

        <div class="uk-width-1-1 uk-text-center uk-margin-bottom uk-margin-top">
        </div>

        <div id="vue" class="uk-width-1-1">
            <channel-usage style="width:1100px; margin:0 auto;" channel-name="{{$channel}}" nick-name="{{isset($nick) ? $nick : ''}}"></channel-usage>
        </div>

    </div>
@endsection
@section('head-script')
    <script>
        var channel = '{{$channel}}';;
        var nick = '{{ isset($nick) ? $nick : '' }}';
    </script>
    <script src="{{elixir('js/vue.js')}}"></script>
@endsection