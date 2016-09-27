@extends('layout._main')
@section('title','IRC Image Gallery')
@section('content')
    <div id="vue">
        <gallery></gallery>
    </div>
@endsection
@section('head-script')
    <script src="{{elixir('js/vue.js')}}"></script>
@endsection