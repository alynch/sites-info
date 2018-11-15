<div class="card mb-3">
    <div class="card-header">
        <h5>Environments</h5>
    </div>

    <div class="card-body">

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
    </div>
</div>
