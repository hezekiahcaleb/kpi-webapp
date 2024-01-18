@isset($type)

<form action="{{$type=='add' ? '/add-user' : '/update-user/'.$user->id}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" name="name" placeholder="Name" value="{{$type=='update' ? $user->name : ''}}" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" name="email" placeholder="Email" value="{{$type=='update' ? $user->email : ''}}" required>
    </div>
    <div class="form-group">
        <label for="parent">Role</label>
        <select class="form-select" name="role">
            <option value=null disabled {{$type=='add' ? 'selected' : ''}}>-</option>
            @foreach ($roleList as $role)
                <option value="{{$role->id}}" {{(($type=='update') && ($role->id == $user->role_id)) ? 'selected' : ''}}>{{$role->role_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="d-flex justify-content-end me-1">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

@endisset
