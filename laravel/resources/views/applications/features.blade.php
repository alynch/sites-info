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

            @include('applications.' . $feature->type)
        </div>
        @endforeach
    </div>
</div>
