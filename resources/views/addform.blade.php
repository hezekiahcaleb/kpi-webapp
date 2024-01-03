@extends('layout')

@section('title', 'Manage Form - KPI Monitoring App')

@section('heading')
    <a href="/manageform" class="heading no-style">Manage Form</a>
    <span class="ms-2 me-2">/</span>
    <a href="/addform" class="heading no-style">
        @if ($type == 'add')
            Add Form
        @elseif ($type == 'update')
            Edit Form
        @endif
    </a>
@endsection

@section('content')

<div class="container form-container">
    <form action="{{ $type=='add' ? '/add-form' : '/update-form/'.$formData->id}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="formname">Form Name</label>
            <input type="text" name="formname" id="" class="form-control" placeholder="Form Name" value="{{$type=='update' ? $formData->form_name : ''}}">
        </div>
        <div class="form-group">
            <label for="formdesc">Description</label>
            <input type="text" name="formdesc" id="" class="form-control" placeholder="Description" value="{{$type=='update' ? $formData->form_description : ''}}">
        </div>
        <div class="form-group">
            <label for="role">Roles</label>
            <div class="dropdown">
                <a class="btn btn-primary dropdown-toggle" href="#" role="button" id="roleDropdownBtn" data-bs-toggle="dropdown">Roles</a>
                <ul class="dropdown-menu" aria-labelledby="roleDropdownBtn">
                    @foreach ($roles as $role)
                    <li>
                        <a class="dropdown-item" href="#">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="{{$role->id}}" name="mapping[]" value="{{$role->id}}" {{($type=='update' && $formMappingData->contains('role_id', $role->id)) ? 'checked' : ''}}>
                                <label class="form-check-label" for="{{$role->id}}">{{$role->role_name}}</label>
                            </div>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        <div class="form-group indicator-table">
            <h4 class="sub-title">Indicators</h4>
            <table class="table table-bordered table-hover" id="dynamicAddRemove">
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Target</th>
                    <th>Weight (%)</th>
                    <th>Action</th>
                </tr>
                @if ($type == 'update' && isset($formDetailData))
                    @foreach ($formDetailData as $indicator)
                        <tr>
                            <td class="d-none"><input type="text" name="indicator[{{$loop->index}}][id]" value="{{$indicator->id}}"></td>
                            <td><input type="text" name="indicator[{{$loop->index}}][name]" placeholder="Enter Indicator Name" class="form-control" value="{{$indicator->indicator_name}}"></td>
                            <td><input type="text" name="indicator[{{$loop->index}}][description]" placeholder="Enter Description" class="form-control" value="{{$indicator->description}}"></td>
                            <td><input type="text" name="indicator[{{$loop->index}}][target]" placeholder="Enter Target" class="form-control" value="{{$indicator->target}}"></td>
                            <td><input type="text" name="indicator[{{$loop->index}}][weight]" placeholder="Enter Weight" class="form-control" value="{{$indicator->weight}}"></td>
                            <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="d-none"><input type="text" name="indicator[0][id]"></td>
                        <td><input type="text" name="indicator[0][name]" placeholder="Enter Indicator Name" class="form-control"></td>
                        <td><input type="text" name="indicator[0][description]" placeholder="Enter Description" class="form-control"></td>
                        <td><input type="text" name="indicator[0][target]" placeholder="Enter Target" class="form-control"></td>
                        <td><input type="text" name="indicator[0][weight]" placeholder="Enter Weight" class="form-control"></td>
                        <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
                    </tr>
                @endif
            </table>
            <button type="button" name="add" id="add-btn" class="btn btn-success">Add Indicator</button>
        </div>
        <div class="text-end me-2">
            <button type="submit" class="btn btn-primary">SAVE FORM</button>
        </div>
    </form>
    <div class="text-center my-4">
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <i class="text-danger">{{$error}}</i>
                <br>
            @endforeach
        @endif
    </div>
    @if (session()->has('message'))
        <div class="text-center my-4">
            <i class="text-success">{{session()->get('message')}}</i>
        </div>
    @endif
</div>

<script type="text/javascript">
    var i = 1;
    $("#add-btn").click(function(){
        $("#dynamicAddRemove").append('<tr><td class="d-none"><input type="text" name="indicator['+i+'][id]"></td><td><input type="text" name="indicator['+i+'][name]" placeholder="Enter Indicator Name" class="form-control"></td><td><input type="text" name="indicator['+i+'][description]" placeholder="Enter Description" class="form-control"></td><td><input type="number" name="indicator['+i+'][target]" placeholder="Enter Target" class="form-control"></td><td><input type="text" name="indicator['+i+'][weight]" placeholder="Enter Weight" class="form-control"></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        i++;
    });
    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
    });
</script>

@endsection
