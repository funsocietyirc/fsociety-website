@section('title',$arg->name)
@extends('layout/_main')
@section('content')
    <div class="show-episode">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div class="episode-info uk-cover-background" style="background: url('/images/arg/banner.png')">
                    <div class="uk-container uk-container-center">
                        <div class="uk-block">
                            <h1 class="uk-text-truncate uk-text-center">{!! $arg->name !!}</h1>
                            <dl class="uk-description-list-horizontal">
                                <dt>URL</dt>
                                <dd><a href="{{$arg->url}}" title="{{$arg->name}}">{{$arg->url}}</a></dd>
                                <dt>Created By</dt>
                                <dd>{{$arg->creator->name}}</dd>
                                <dt>Description</dt>
                                <dd>{{$arg->description}}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="uk-container uk-container-center">
                        <div class="uk-block">
                            <h3>Discussion</h3>
                            @include('partials/_disqus',['slug' =>  $arg->url])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection