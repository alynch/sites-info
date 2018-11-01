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
		value="{{ $environment->name ?: old('name') }}" />
	</div>

	<div class="form-group">
	    <label for="code">Code:</label>
	    <input type="text" id="code" name="code" class="form-control"
		value="{{ $environment->code ?: old('code') }}" />
	</div>

	<div class="form-group">
	    <label for="description">Description: </label>
	    <textarea id="description" name="description" class="form-control">{{ $environment->description }}</textarea>
	</div>

	<div class="form-group">
	    <label for="sort_order">Sort order: </label>
	    <input type="number" id="sort_order" name="sort_order" class="form-control"
		value="{{ $environment->sort_order ?: old('sort_order') }}" />
	</div>

	<div>
	    <input type="submit" class="btn btn-primary" value="Save">
	</div>

    </div>
</div>
