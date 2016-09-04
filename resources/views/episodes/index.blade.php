@section('title','Episodes')
@extends('layout/_main')
@section('content')
    <div class="episodes uk-text-center">
        <ul class="uk-grid uk-margin-bottom" data-uk-grid-margin>
            <li class="uk-width-small-1-3 uk-width-medium-1-3 uk-width-large-1-5">
                <a href="{{ route('episodes') }}"
                   class="uk-button uk-button-danger uk-width-1-1 season-button uk-margin-small-bottom">All Episodes</a>
                <a href="{{ route('season',1) }}"
                   class="uk-button uk-button-danger uk-width-1-1 season-button uk-margin-small-bottom">Season 1</a>
                <a href="{{ route('season',2) }}"
                   class="uk-button uk-button-danger uk-width-1-1 season-button uk-margin-small-bottom">Season 2</a>
            </li>
            @foreach($episodes as $episode)
                <li class="uk-animation-fade uk-width-small-1-3 uk-width-medium-1-3 uk-width-large-1-5">
                    <div class="episode-item"
                         data-episode-link="{{ route('episode',['slug' => $episode->slug]) }}">
                        <figure class="uk-overlay">
                            @if($episode['imageMedium'] )
                                <img src="{{ $episode['imageMedium'] }}" alt="">
                            @else
                                <img src="{{asset('images/episodes/fsociety.png')}}" alt="">
                            @endif
                            <figcaption class="uk-overlay-panel uk-overlay-top">
                                <span class="text">{{ $episode['name'] }}</span>
                            </figcaption>
                            <figcaption class="uk-overlay-panel uk-overlay-bottom uk-overlay-right">
                                <a class="no-link" data-disqus-identifier="{{ $episode->slug }}" href="#"></a>
                            </figcaption>
                        </figure>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
@section('scripts')
    <script>
        $(function () {
            $('.episode-item').each(function (index, value) {
                var self = $(this);
                var link = self.data('episode-link');
                self.click(function () {
                    window.location = link;
                });
                self.hover(function () {
                    self.children().toggleClass('hovered')
                }, function () {
                    self.children().toggleClass('hovered')
                });
            });
        });
    </script>
    <script id="dsq-count-scr" src="//fsociety.disqus.com/count.js" async></script>
@endsection