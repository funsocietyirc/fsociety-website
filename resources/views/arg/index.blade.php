@extends('layout/_main')
@section('title','Alternate Realty Game Link Tracker')
@section('content')
    <div class="arg-layout">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <header class="uk-block  uk-cover-background">
                    <h1 class="uk-text-truncate uk-text-center">
                        Alternate Reality Links
                    </h1>
                </header>
                <div class="arg-nav">
                    <div class="uk-container ">
                        <ul class="uk-subnav  uk-subnav-pill uk-flex-center">
                            <li class="{{isActiveRoute('arg.index')}}">
                                <a href="{{ route('arg.index') }}"><i class="uk-icon-book"></i></a>
                            </li>
                            <li>
                                <a href="{{ route('arg.create') }}"><i class="uk-icon-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="uk-flex uk-flex-center" >
                    <div class="uk-grid uk-grid-match" data-uk-grid-margin>
                        @foreach($results as $result)
                            <article class="arg-item uk-width-large-1-3 uk-width-medium-1-2 uk-grid-match">
                                <div class="arg-item-content uk-grid-match">
                                    <div class="uk-block uk-cover-background"
                                         @if(File::exists(public_path('images/arg/tiles/'.$result->id.'.png'))) style="background:url('{!! asset('images/arg/tiles/' . $result->id .'.png') !!}') "@endif>
                                        <div class="height-1-1 inner-block uk-height-1-1">
                                            <h2><a href="{{route('arg.show',$result)}}">{{ title_case($result->name) }}</a></h2>
                                            @include('arg.partials._dlist')
                                            @include('arg.partials._subNav')
                                            @include('arg.partials._connectionForm')
                                            <a class="no-link" data-disqus-identifier="{{$result->url}}" href="#"></a>

                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script id="dsq-count-scr" src="//fsociety.disqus.com/count.js" async></script>
@endsection