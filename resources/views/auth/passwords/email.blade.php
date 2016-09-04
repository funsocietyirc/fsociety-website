@extends('layout/_main', [ 'fullHeight' => true])
@section('title', 'Request Password Reset')
@section('content')
    <div class="uk-vertical-align uk-text-center full-height">
        <div class="uk-vertical-align-middle">
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">

                    <div class="uk-panel uk-panel-header uk-panel-box login">
                        <h3 class="uk-panel-title">I promise I wont lie</h3>
                        @if (session('status'))
                            <div class="uk-alert uk-alert-success" data-uk-alert>
                                <a href="" class="uk-alert-close uk-close"></a>
                                <p>
                                    {{ session('status') }}
                                </p>
                            </div>

                        @endif
                        <form class="uk-form uk-form-stacked" role="form" method="POST"
                              action="{{ url('/password/email') }}">
                            {{ csrf_field() }}

                            <div class="uk-form-row{{ $errors->has('email') ? ' uk-form-danger' : '' }}">
                                <label for="email" class="uk-form-label">E-Mail Address</label>

                                <input id="email" type="email" class="uk-width-1-1" name="email"
                                       value="{{ old('email') }}">

                                @if ($errors->has('email'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-success uk-width-1-1">
                                    Send Password Reset Link
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
