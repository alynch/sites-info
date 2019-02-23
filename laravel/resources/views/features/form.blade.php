<div class="card">

    @if (isset($title))
    <div class="card-header">
        <h2>{{ $title }}</h2>
    </div>
    @endif

    <div class="card-body">
        @include('errors')

	<div class="form-group">
	    <label for="name">Name:</label>
	    <input type="text" id="name" name="name" class="form-control"
		value="{{ $feature->name ?: old('name') }}" />
	</div>

	<div class="form-group">
	    <label for="type">Type:</label>
	    <input type="text" id="type" name="type" class="form-control"
		value="{{ $feature->type ?: old('type') }}" />
	</div>

	<div class="form-group">
	    <label for="type">Label:</label>
	    <input type="text" id="label" name="label" class="form-control"
		value="{{ $feature->label ?: old('label') }}" />
	</div>

	<div class="form-group">
	    <label for="description">Description: </label>
	    <textarea id="description" name="description" class="form-control">{{ $feature->description }}</textarea>
	</div>

	<div>
	    <input type="submit" class="btn btn-primary" value="Save">
	</div>

    </div>
</div>
