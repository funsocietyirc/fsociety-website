@extends('layout/_main', [ 'fullHeight' => true])
@section('title','Submit Alternate Reality Game Link')
@section('content')
    <div class="uk-vertical-align uk-text-center full-height">
        <div class="uk-vertical-align-middle">
            <div class="uk-block uk-block-large">
                <div class="uk-container uk-container-center arg-create-container">
                    <div class="uk-panel uk-panel-header">
                        <h3 class="uk-panel-title">ARG Link Submission</h3>
                        <p>
                            Have you stumbled on something?
                        </p>
                        <form class="uk-form uk-form-stacked" role="form" method="POST"
                              action="{{ route('arg.store') }}">
                            @include('arg.partials._form')
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
