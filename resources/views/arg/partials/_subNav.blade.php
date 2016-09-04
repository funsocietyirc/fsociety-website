<?php
$result = isset($result) ? $result : $arg;
?>
<div class="uk-subnav uk-subnav-line">
    @can('edit', $result)
        <li><a href="{{ route('arg.edit', $result) }}"
               title="Capture URL">Edit</a>
        </li>
    @endcan
    @can('capture',$result)
        <li><a href="{{ route('arg.capture', $result) }}"
               title="Capture URL">Capture</a>
        </li>
    @endcan
    @can('delete', $result)
        <li><a href="{{ route('arg.destroy', $result) }}" data-method="delete"
               rel="nofollow"
               data-confirm="Are you sure you want to delete this?">Delete</a>
        </li>
    @endcan
    @can('modify-watch', $result)
        <li>
            <a href="{{route('arg.watch',$result)}}">@if(!$result->ignoreHash) Unwatch @else Watch @endif</a>
        </li>
    @endcan
</div>
