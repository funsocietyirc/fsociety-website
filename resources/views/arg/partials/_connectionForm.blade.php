<?php
$result = isset($result) ? $result : (isset($arg) ? $arg : null)
?>

<form class="connections-form" data-confirm="Are you sure you want to add this Connection?"
      data-disable-with="Saving..." action="{{route('arg.connect', $result)}}" method="post">
    {{csrf_field()}}
    <div class="connections-form-row">
        <label for="name"></label>
        <select id="name" name="episode">
            <option disabled selected>Add new Connection</option>
            @foreach($result->availableConnections() as $connection)
                <option value="{{$connection->id}}">{{$connection->name}}</option>
            @endforeach
        </select>
    </div>
    <div class="connections-form-row">
        <button type="submit"><i class="uk-icon-anchor"></i></button>
    </div>
</form>