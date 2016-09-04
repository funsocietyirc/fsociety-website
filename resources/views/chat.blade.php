@section('title','IRC Chat')
@extends('layout/_main', ['fullHeight' => true])
@section('content')
    <div class="wrapper full-height">
        <div class="h_iframe full-height">
            <!-- a transparent image is preferable -->
            <img class="ratio" src="http://placehold.it/16x9"/>
            <iframe src="https://webchat.freenode.net/?channels=#fsociety @if(Auth::check())&nick={!! Auth::user()->name !!} @endif"
                    allowfullscreen></iframe>
        </div>
    </div>
@endsection
@section('scripts')
@endsection