@extends('layout._main')
@section('title','IRC Image Gallery')
@section('meta')
    <meta name="robots" content="noindex,nofollow">
@endsection
@section('content')
    <div id="vue">
        <gallery></gallery>
    </div>
@endsection
@section('head-script')
    <script src="{{elixir('js/vue.js')}}"></script>
    <script src="/js/infinite.js"></script>
@endsection