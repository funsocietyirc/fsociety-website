@extends('layout/_main', [ 'fullHeight' => true])
@section('title','Edit Alternate Reality Game Link')
@section('content')
    <div class="uk-vertical-align uk-text-center full-height">
        <div class="uk-vertical-align-middle">
            <div class="uk-block uk-block-large">
                <div class="uk-container uk-container-center arg-create-container">
                    <div class="uk-panel uk-panel-header">
                        <h3 class="uk-panel-title">ARG Link Edit</h3>
                        <form class="uk-form uk-form-stacked" role="form" method="POST" action="{{ route('arg.update', $arg) }}">
                            {{ method_field('PUT') }}
                            @include('arg.partials._form')
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
