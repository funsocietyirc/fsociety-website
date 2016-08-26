<div class="uk-form-row{{ $errors->has('g-recaptcha-response') ? ' uk-form-danger' : '' }}">
    <div class="uk-container-center">
        {!! app('captcha')->display()!!}
    </div>
    @if ($errors->has('g-recaptcha-response'))
        <div class="uk-form-help-block">
            <strong>Watch Mr. Robot, do not be Mr. Robot</strong>
        </div>
    @endif
</div>