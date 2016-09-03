@section('title',$episode->name)
@extends('layout/_main')
@section('content')
    <div class="show-episode">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <div class="episode-header uk-block uk-cover-background" style="@if($episode->imageOriginal)background-image:url({!! $episode->imageOriginal !!}); @else background-image:url({!! asset('images/episodes/banner.png') !!});@endif">
                    <div class="uk-cover-background">
                        <div class="uk-container uk-container-center">
                            <div class="uk-block episode-info">
                                <h1 class="uk-text-truncate uk-text-center">{!! $episode->name !!}</h1>
                                <dl class="uk-description-list-horizontal">
                                    <dt>Season</dt>
                                    <dd>
                                        <a href="{{route('season',$episode->season_id)}}">
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
                </div>
                @if($episode->connections()->count())
                    <div class="uk-container uk-container-center">
                        <div class="uk-block">
                            <h3>Alternate Reality Links</h3>
                            <ul class="uk-subnav uk-subnav-line">
                                @foreach($episode->connections()->get() as $connection)
                                    <li><a href="{{route('arg.show',$connection)}}">{{$connection->argLink->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
                <div class="uk-container uk-container-center">
                    <div class="uk-block">
                        <h3>Discussion</h3>
                        @include('partials/_disqus',['slug' => $episode->slug])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection