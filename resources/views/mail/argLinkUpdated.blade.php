@extends('mail.layouts._default')
@section('title', $arg->name)
@section('content')
<h1>{{config('app.name')}} has had a ARG Link update</h1>
<p>
    The {{$arg->name}} link has been updated, this could mean it has been modified or the website itself has changed since it was added.
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