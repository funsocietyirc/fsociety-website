@extends('layout._main')
@section('title','IRC Link Watcher')
@section('content')
    <div id="vue">
        <links></links>
    </div>
@endsection
@section('head-script')
    <script>
        var activeSearch = '{{Request::input('search')}}';
    </script>
    <script src="{{elixir('js/vue.js')}}"></script>
@endsection