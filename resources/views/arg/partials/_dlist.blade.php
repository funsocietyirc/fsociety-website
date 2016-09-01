<?php
    $result = isset($result) ? $result : $arg;
?>
<dl class="uk-description-list-horizontal">
    <dt>Created By</dt>
    <dd>{{ $result->creator->name }}</dd>
    <dt>Last Modified</dt>
    <dd>{{ $result->updated_at->diffForHumans() }}</dd>
    <dt>Description</dt>
    <dd> {{ $result->description }}</dd>
</dl>