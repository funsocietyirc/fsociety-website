@extends('layout/_main', [ 'fullHeight' => true])
@section('title','Password Reset')
@section('content')
    <div class="uk-vertical-align uk-text-center full-height">
        <div class="uk-vertical-align-middle">
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <div class="uk-panel uk-panel-header uk-panel-box login">
                        <h3 class="uk-panel-title">Reset Password</h3>
                        <p>It seems you have been forgetting things.</p>
                        <form class="uk-form uk-form-stacked" role="form" method="POST" action="{{ url('/password/reset') }}">

                            {{ csrf_field() }}

                            <div class="uk-form-row{{ $errors->has('email') ? ' uk-form-danger' : '' }}">
                                <label for="email" class="uk-form-label">E-Mail</label>
                                <input class="uk-width-1-1" id="email" type="email" name="email"
                                       value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="uk-form-row{{ $errors->has('password') ? ' uk-form-danger' : '' }}">
                                <label for="password" class="uk-form-label">Password</label>
                                <input class="uk-width-1-1" id="password" type="password" name="password">
                                @if ($errors->has('password'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="uk-form-row{{ $errors->has('password_confirmation') ? ' uk-form-danger' : '' }}">
                                <label for="password-confirm" class="uk-form-label">Confirm Password</label>
                                <input class="uk-width-1-1" id="password-confirm" type="password"
                                       name="password_confirmation">
                                @if ($errors->has('password_confirmation'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </div>
                                @endif
                            </div>

                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-success uk-width-1-1">
                                    Reset
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
