@extends('layout/_main', [ 'fullHeight' => true])
@section('title','Login')
@section('content')
    <div class="uk-vertical-align uk-text-center full-height">
        <div class="uk-vertical-align-middle">
            <div class="uk-grid">
                <div class="uk-width-medium-1-1">
                    <div class="uk-panel uk-panel-header uk-panel-box login">
                        <h3 class="uk-panel-title">Hello Friend</h3>
                        <p>Note: If you previously signed up, your login name is what ever was before the @ in the email you provided us.</p>
                        <form class="uk-form uk-form-stacked" role="form" method="POST" action="{{ url('/login') }}">
                            {{ csrf_field() }}

                            <div class="uk-form-row{{ $errors->has('nick') ? ' uk-form-danger' : '' }}">
                                <label for="nick class="uk-form-label">Nick</label>
                                <input class="uk-width-1-1" id="nick" type="text" name="nick"
                                       value="{{ old('nick') }}" autofocus>
                                @if ($errors->has('nick'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('nick') }}</strong>
                                    </div>
                                @endif
                            </div>
                            <div class="uk-form-row{{ $errors->has('password') ? ' uk-form-danger' : '' }}">
                                <label for="password" class="uk-form-label">Password</label>

                                <input class="uk-width-1-1" id="password" type="password" name="password">
                                <div></div>
                                @if ($errors->has('password'))
                                    <div class="uk-form-help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                            </div>
                            @if(config('app.env') !== 'local')
                                @include('layout._recaptcha')
                            @endif
                            <div class="uk-form-row">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-form-row">
                                <button type="submit" class="uk-button uk-button-success uk-width-1-1">
                                    Login
                                </button>
                            </div>
                            <div class="uk-form-row">
                                <a class="uk-button uk-button-primary uk-width-1-1" href="{{ url('/password/reset') }}">
                                    Forgot Your Password?
                                </a>
                            </div>
                            <div class="uk-form-row">
                                <a class="uk-button uk-button-success uk-width-1-1" href="{{ url('/register') }}">
                                    Sign up Now
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
