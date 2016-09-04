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
                            <li class="uk-active">
                                <a href="{{ route('arg.index') }}"><i class="uk-icon-book"></i></a>
                            </li>
                            <li>
                                <a href="{{ route('arg.create') }}"><i class="uk-icon-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="uk-grid uk-grid-large uk-grid-match" data-uk-grid-margin>
                    @foreach($results as $result)
                        <article class="arg-item uk-width-large-1-3 uk-width-medium-1-2">
                            <div class="arg-item-content">
                                <div class="uk-block uk-cover-background uk-grid-match"
                                     @if(File::exists(public_path('images/arg/tiles/'.$result->id.'.png'))) style="background:url('{!! asset('images/arg/tiles/' . $result->id .'.png') !!}') "@endif>
                                    <div class="height-1-1 inner-block ">
                                        <h2><a href="{{route('arg.show',$result)}}"
                                               target="_blank">{{ title_case($result->name) }}</a></h2>
                                        @include('arg.partials._dlist')
                                        <div class="uk-subnav uk-subnav-line">
                                            @can('edit', $result)
                                                <li><a href="{{ route('arg.edit', $result) }}"
                                                       title="Capture URL">Edit</a>
                                                </li>
                                            @endcan
                                            @can('capture',$result)
                                                <li><a href="{{ route('arg.capture', $result) }}"
                                                       title="Capture URL">Capture</a>
                                                </li>
                                            @endcan
                                            @can('delete', $result)
                                                <li><a href="{{ route('arg.destroy', $result) }}" data-method="delete"
                                                       rel="nofollow"
                                                       data-confirm="Are you sure you want to delete this?">Delete</a>
                                                </li>
                                            @endcan
                                        </div>
                                        <a class="no-link" data-disqus-identifier="{{$result->url}}" href="#"></a>
                                        @include('arg.partials._connectionForm')
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script id="dsq-count-scr" src="//fsociety.disqus.com/count.js" async></script>
@endsection