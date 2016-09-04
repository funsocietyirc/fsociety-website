{{ csrf_field() }}
<div class="uk-form-row{{ $errors->has('url') ? ' uk-form-danger' : '' }}">
    <label for="name" class="uk-form-label">Name</label>
    <input class="uk-width-1-1" id="name" type="text" name="name" value="{{ $arg->name ?? old('name') }}" autofocus>
    @if ($errors->has('name'))
        <div class="uk-form-help-block">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
    @endif
</div>
<div class="uk-form-row{{ $errors->has('url') ? ' uk-form-danger' : '' }}">
    <label for="url" class="uk-form-label">URL</label>
    <input class="uk-width-1-1" id="url" type="text" name="url"
           value="{{ $arg->url ?? old('url') }}">
    @if ($errors->has('url'))
        <div class="uk-form-help-block">
            <strong>{{ $errors->first('url') }}</strong>
        </div>
    @endif
</div>

<div class="uk-form-row{{ $errors->has('description') ? ' uk-form-danger' : '' }}">
    <label for="description" class="uk-form-label">Description</label>
    <textarea rows="5" cols="5" class="uk-width-1-1" id="description"
              name="description">{{$arg->description ?? old('description')}}</textarea>
    @if ($errors->has('description'))
        <div class="uk-form-help-block">
            <strong>{{ $errors->first('description') }}</strong>
        </div>
    @endif
</div>
<div class="uk-form-row">
    <button type="submit" class="uk-button uk-button-success uk-width-1-1">Share</button>
</div>
