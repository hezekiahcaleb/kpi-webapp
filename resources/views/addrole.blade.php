@isset($type)

<form action="{{$type=='add' ? '/add-role' : '/update-role/'.$roleData->id}}" method="POST">
    @csrf
    <div class="form-group">
        <label for="rolename">Role Name</label>
        <input type="text" class="form-control" name="rolename" placeholder="Role Name" value="{{$type=='update' ? $roleData->role_name : ''}}">
    </div>
    <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-select" name="parent">
            <option value="0">-</option>
            @foreach ($roleList as $role)
                <option value="{{$role->id}}" {{(($type=='update') && ($role->id == $roleData->parent_id)) ? 'selected' : ''}}>{{$role->role_name}}</option>
            @endforeach
        </select>
    </div>
    <div class="d-flex justify-content-end me-1">
        <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>

@endisset
