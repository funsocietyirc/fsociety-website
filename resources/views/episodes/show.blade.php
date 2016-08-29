@section('title',$episode->name)
@extends('layout/_main')
@section('content')
    <div class="show-episode">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div class="episode-header uk-block uk-block-medium uk-cover-background" style="@if($episode->imageOriginal)background-image:url({!! $episode->imageOriginal !!}); @else background-image:url({!! asset('images/episodes/banner.png') !!});@endif">
                        <h1 class="uk-text-truncate uk-text-center">{!! $episode->name !!}</h1>
                </div>

                <div class="episode-info uk-cover-background">
                    <div class="uk-container uk-container-center">
                        <div class="uk-block">
                            <h3>Episode Info</h3>
                            <dl class="uk-description-list-horizontal">
                                <dt>Season</dt>
                                <dd>
                                    <a href="{{route('season',$episode->seasonId)}}">
                                        {!! $episode->season_id !!}
                                    </a>
                                </dd>
                                <dt>Episode</dt>
                                <dd>{!! $episode->number !!}</dd>
                                <dt>Air Date</dt>
                                <dd>{!! $episode->airdate !!}</dd>
                                <dt>Run Time</dt>
                                <dd>{!! $episode->runtime !!} minuets</dd>
                                <dt>Summary</dt>
                                <dd>{!! $episode->summary !!}</dd>
                            </dl>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="uk-container uk-container-center">
                        <div class="uk-block">
                            <h3>Discussion</h3>
                            @include('partials/_disqus',['slug' => $episode->slug])
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection