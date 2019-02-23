<input type="checkbox" data-toggle="toggle"
    id="features-{{ $feature->id }}"
    @if ($application->features->contains($feature->id)) checked @endif
    name="features[]"
    value="{{ $feature->id }}"/>
