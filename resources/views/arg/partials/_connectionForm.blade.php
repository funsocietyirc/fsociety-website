<form class="uk-form"
      data-confirm="Are you sure you want to add this Connection?" data-disable-with="Saving..." action="{{route('arg.connect', $result)}}" method="post">
    {{csrf_field()}}
    <select class="uk-form-small" name="episode">
        <option disabled selected>Add new Mention</option>
        @foreach($result->availableConnections() as $connection)
            <option value="{{$connection->id}}">{{$connection->name}}</option>
        @endforeach
    </select>
    <button type="submit"><i class="uk-icon-anchor"></i></button>
</form>