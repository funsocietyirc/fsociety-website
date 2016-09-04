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
                                <dt>Connections</dt>
                                <dd>@include('arg.partials._connectionForm')</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                @if($arg->connections()->count())
                    <div class="uk-container uk-container-center">
                        <div class="multiple-items">
                            @foreach($arg->connections()->get() as $connection)
                                <div>
                                    <figure class="uk-overlay"
                                            data-link="{{route('episode', $connection->episode->slug)}}">
                                        <img src="{{$connection->episode->imageMedium}}" alt="" class="uk-width-1-1">
                                        <figcaption class="uk-overlay-panel uk-overlay-background uk-overlay-bottom"
                                                    style="text-align: center;">
                                            {{$connection->episode->name}}
                                        </figcaption>
                                    </figure>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="uk-container uk-container-center">
                    <div class="uk-block">
                        <h3>Discussion</h3>
                        @include('partials/_disqus',['slug' =>  $arg->url])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @if($arg->connections()->count())
        <script type="text/javascript">
            $(function () {
                $('.uk-overlay').click(function (e) {
                    window.location = $(this).data('link');
                })
                $('.multiple-items').slick({
                    dots: true,
                    infinite: true,
                    speed: 300,
                    slidesToShow: 4,
                    slidesToScroll: 4,
                    responsive: [
                        {
                            breakpoint: 1024,
                            settings: {
                                slidesToShow: 3,
                                slidesToScroll: 3,
                                infinite: true,
                                dots: true
                            }
                        },
                        {
                            breakpoint: 600,
                            settings: {
                                slidesToShow: 2,
                                slidesToScroll: 2
                            }
                        },
                        {
                            breakpoint: 480,
                            settings: {
                                slidesToShow: 1,
                                slidesToScroll: 1
                            }
                        }
                    ]
                });

            });
        </script>
    @endif
@endsection