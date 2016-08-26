@extends('layout/_main')
@section('content')
    <div class="full-height show-episode">
        <div class="uk-grid">
            <div class="uk-width-1-1">
                <figure class="uk-overlay">
                    <img class="uk-width-1-1" src="{!! $episode['imageOriginal'] !!}" alt="">
                    <figcaption class="uk-overlay-panel">...</figcaption>
                </figure>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
@endsection