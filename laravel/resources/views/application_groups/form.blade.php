<div class="card">

<div class="card-body">
@include('errors')

<div class="form-group">
    <label>Name:
    <input type="text" name="name" class="form-control" value="{{ $group->name }}"/>
    </label>
</div>

<div class="form-group">
    <label>Description:
    <textarea name="description" class="form-control">{{ $group->description }}</textarea>
    </label>
</div>

<div>
    <input type="submit" class="btn btn-primary" value="Save">
</div>

</div>
</div>

