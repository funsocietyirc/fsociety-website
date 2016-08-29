@extends('layout/_main', [ 'fullHeight' => true])
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
                        <form class="uk-form uk-form-stacked" role="form" method="POST" action="{{ route('arg.store') }}">
                            {{ csrf_field() }}
                            <div class="uk-form-row{{ $errors->has('url') ? ' uk-form-danger' : '' }}">
                                <label for="name" class="uk-form-label">Name</label>
                                <input class="uk-width-1-1" id="name" type="text" name="name" value="{{ old('name') }}"
                                       autofocus>
                                @if ($errors->has('name'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="uk-form-row{{ $errors->has('url') ? ' uk-form-danger' : '' }}">
                                <label for="url" class="uk-form-label">URL</label>
                                <input class="uk-width-1-1" id="url" type="text" name="url"
                                       value="{{ old('url') }}">
                                @if ($errors->has('url'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('url') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="uk-form-row{{ $errors->has('description') ? ' uk-form-danger' : '' }}">
                                <label for="description" class="uk-form-label">Description</label>
                                <textarea rows="5" cols="5" class="uk-width-1-1" id="description" name="description"></textarea>
                                @if ($errors->has('description'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-success uk-width-1-1">
                                    Share
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
