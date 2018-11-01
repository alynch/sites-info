<h2>Environments</h2>

@foreach ($environments as $environment)
<div class="form-group row">
    <label for="env-{{ $environment->id }}" class="col-sm-2 col-form-label">
        {{ $environment->name }}
    </label>

    <div class="col-sm-10">
      <input type="text" class="form-control"
            id="env-{{ $environment->id }}"
            name="env[{{ $environment->id }}]" 
            value="{{ $environment->url ?: old('env.' . $environment->id) }}"/>
    </div>
    </div>
@endforeach


