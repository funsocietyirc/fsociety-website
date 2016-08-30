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
                                <a href="{!! route('arg.index') !!}"><i class="uk-icon-book"></i></a>
                            </li>
                            <li>
                                <a href="{!! route('arg.create') !!}"><i class="uk-icon-plus"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="uk-grid uk-grid-large" data-uk-grid-margin>
                    @foreach($results as $result)
                        <article class="arg-item uk-width-large-1-3 uk-width-medium-1-2">
                            <div class="uk-block uk-cover-background"
                                 @if(File::exists(public_path('images/arg/tiles/'.$result->id.'.png'))) style="background:url('{!! asset('images/arg/tiles/' . $result->id .'.png') !!}') "@endif>
                                <div class="arg-item-content">
                                    <div class="uk-container uk-container-center" style="padding-top:10px">

                                        <h3><a href="{!! $result->url !!}"
                                               target="_blank">{!! title_case($result->name) !!}</a></h3>
                                        <hr>
                                        <dl class="uk-description-list-horizontal">
                                            <dt>Created By</dt>
                                            <dd>{!! $result->creator->name !!}</dd>
                                            <dt>Last Modified</dt>
                                            <dd>{!! $result->updated_at->diffForHumans() !!}</dd>
                                            <dt>Description</dt>
                                            <dd> {!! $result->description !!}</dd>
                                        </dl>
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
@endsection