@extends('mail.layouts._default')
@section('title', $title)
@section('content')
<h1>{{config('app.name')}} : {{$title}}</h1>
<p>
    {{$body}}
</p>
<p>

</p>
<ul>
    <li>
        <a href="{{$arg->url}}">Open ARG Link</a>
    </li>
    <li>
        <a href="{{route('arg.show',$arg)}}">Open Site</a>
    </li>
</ul>
@stop