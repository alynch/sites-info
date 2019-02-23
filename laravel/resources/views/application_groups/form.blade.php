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
		value="{{ $group->name ?: old('name') }}" />
	</div>

	<div class="form-group">
	    <label for="description">Description: </label>
	    <textarea id="description" name="description" class="form-control">{{ $group->description }}</textarea>
	</div>

        <div>
            <input type="submit" class="btn btn-primary" value="Save">
        </div>

    </div>
</div>

