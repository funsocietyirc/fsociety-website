@extends('layout/_main')
@section('content')
    <div class="uk-vertical-align full-height">
        <div class="uk-vertical-align-middle uk-text-center">
            <div class="episodes">
                <ul class="uk-grid" data-uk-grid-margin>
                   @foreach($episodes as $episode)
                        <li class="uk-animation-fade uk-width-small-1-3 uk-width-medium-1-3 uk-width-large-1-5">
                            <div class="episode-item" data-episode-link="">
                                @if($episode['imageMedium'] )
                                    <img src="{!! $episode['imageMedium'] !!}" alt="">
                                @else
                                    <img src="{!! asset('images/episodes/fsociety.png') !!}" alt="">
                                @endif
                                <p>
                                    {!! $episode['name'] !!}
                                </p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        $(function() {
            $('.episode-item').each(function(index, value) {
                var self = $(this);
                var link = self.data('episode-link');
                self.click(function () {
                   window.location = link;
                });
                self.hover(function() {
                    self.children().toggleClass('hovered')
                }, function() {
                    self.children().toggleClass('hovered')
                });
            });
        });
    </script>
@endsection