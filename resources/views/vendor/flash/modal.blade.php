@php
    $modalId = 'modal' . str_random(5);
@endphp
<div id="{!! $modalId !!}" class="uk-modal">
    <div class="uk-modal-dialog {{ $modalClass or '' }}">
        <div class="uk-modal-header">{{ $title }}</div>
        <p>
            {!! $body !!}
        </p>
        <div class="uk-modal-footer">
            <a class="uk-button uk-button-danger uk-modal-close">Agreed</a>
        </div>
    </div>
</div>
<script>
    $(function () {
        jQuery.UIkit.modal('#{!! $modalId !!}').show();
    });
</script>