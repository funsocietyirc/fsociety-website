@extends('layout/_main')
@section('content')
    <div class="full-height show-episode">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div class="uk-block uk-block-medium uk-cover-background" style="background-image:url({!! $episode['imageOriginal'] !!});">
                        <h1 class="uk-text-truncate uk-text-center">{!! $episode['name'] !!}</h1>
                </div>
                <dl class="uk-description-list-horizontal">
                    <dt>Season</dt>
                    <dd>{!! $episode['season_id'] !!}</dd>
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