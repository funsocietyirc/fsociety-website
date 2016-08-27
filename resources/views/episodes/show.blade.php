@extends('layout/_main')
@section('content')
    <div class="show-episode">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div class="uk-block uk-block-medium uk-cover-background" style="@if($episode['imageOriginal'])background-image:url({!! $episode['imageOriginal'] !!}); @else background-image:url({!! asset('images/episodes/banner.png') !!});@endif">
                        <h1 class="uk-text-truncate uk-text-center">{!! $episode['name'] !!}</h1>
                </div>
                <dl class="uk-description-list-horizontal">
                    <dt>Season</dt>
                    <dd>
                        <a href="{{route('season',$episode['season_id'])}}">
                        {!! $episode['season_id'] !!}</dd>
                        </a>
                    <dt>Episode</dt>
                    <dd>{!! $episode['number'] !!}</dd>
                    <dt>Air Date</dt>
                    <dd>{!! $episode['airdate'] !!}</dd>
                    <dt>Run Time</dt>
                    <dd>{!! $episode['runtime'] !!} minuets</dd>
                    <dt>Summary</dt>
                    <dd>{!! $episode['summary'] !!}</dd>
                </dl>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection