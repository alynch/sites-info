<div class="card mb-3">
    <div class="card-body">

        @include('errors')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" class="form-control"
                value="{{ $application->name ?: old('name') }}"/>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" class="form-control">{{ $application->description }}</textarea>
        </div>

        <div class="form-group row">
            <div class="col-sm-10">
            <label>Group:</label>
            <select name="group_id" class="form-control">
                <option value="">Select one</option>
                @foreach ($groups as $group)
                <option value="{{ $group->id }}"
                    @if ($application->group_id == $group->id) selected @endif>
                    {{ $group->name }}
                </option>
                @endforeach
            </select>

            </div>
        </div>
    </div>
</div>

        @include('applications.environments')

        @include('applications.timeline')

        <div>
            <input type="submit" class="btn btn-primary" value="Save">
        </div>


