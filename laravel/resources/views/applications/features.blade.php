<div class="card mb-3">
    <div class="card-header">
        <h5>Features</h5>
    </div>

    <div class="card-body">

        @foreach ($features as $feature)
        <div class="form-check">
            <label for="features-{{ $feature->id }}" class="col-sm-2 col-form-label">
                {{ $feature->name }}
            </label>

              <input type="checkbox" class="mt-3"
                    id="features-{{ $feature->id }}"
                    @if ($application->features->contains($feature->id)) checked @endif
                    name="features[]"
                    value="{{ $feature->id }}"/>
            </div>
        @endforeach
    </div>
</div>
