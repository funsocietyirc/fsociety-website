@if (session()->has('flash_notification.message'))
    @if (session()->has('flash_notification.overlay'))
        @include('flash::modal', [
            'modalClass' => 'flash-modal',
            'title'      => session('flash_notification.title'),
            'body'       => session('flash_notification.message')
        ])
    @else
        <div class="uk-alert uk-alert-{{ session('flash_notification.level') }}
        {{ session()->has('flash_notification.important') ? 'alert-important' : '' }}" data-uk-alert>
            @if(session()->has('flash_notification.important'))
                <a href="" class="uk-alert-close uk-close"></a>
            @endif
            <p>
                {!! session('flash_notification.message') !!}
            </p>
        </div>
    @endif
@endif
