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

<div class="container form-container offwhite-bg">
    <form action="{{ $type=='add' ? '/add-form' : '/update-form/'.$formData->id}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="formname">Form Name</label>
            <input type="text" name="formname" id="" class="form-control" placeholder="Form Name" value="{{$type=='update' ? $formData->form_name : ''}}" required>
        </div>
        <div class="form-group">
            <label for="formdesc">Description</label>
            <input type="text" name="formdesc" id="" class="form-control" placeholder="Description" value="{{$type=='update' ? $formData->form_description : ''}}" required>
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
        <div class="form-group">
            <h4 class="sub-title">Period</h4>
            <div class="row">
                <div class="col-6">
                    <label for="from">From</label>
                    <input type="month" name="from" id="from" value="{{$type=='update' ? str($formData->from)->limit(7, '') : ''}}" required>
                </div>
                <div class="col-6">
                    <label for="to">To</label>
                    <input type="month" name="to" id="to" value="{{$type=='update' ? str($formData->to)->limit(7, '') : ''}}" required>
                </div>
            </div>
        </div>
        <div class="form-group indicator-table">
            <h4 class="sub-title">Indicators</h4>
            <table class="table table-bordered table-hover align-middle" id="dynamicAddRemove">
                <tr class="text-center">
                    <th>Name</th>
                    <th>Description</th>
                    <th>Target</th>
                    <th>Weight (%)</th>
                    <th>Higher Better?</th>
                    <th>Action</th>
                </tr>
                @if ($type == 'update' && isset($formDetailData))
                    @foreach ($formDetailData as $indicator)
                        <tr>
                            <td class="d-none"><input type="text" name="indicator[{{$loop->index}}][id]" value="{{$indicator->id}}"></td>
                            <td><input type="text" name="indicator[{{$loop->index}}][name]" placeholder="Enter Indicator Name" class="form-control" value="{{$indicator->indicator_name}}"></td>
                            <td><input type="text" name="indicator[{{$loop->index}}][description]" placeholder="Enter Description" class="form-control" value="{{$indicator->description}}"></td>
                            <td><input type="number" min="0" name="indicator[{{$loop->index}}][target]" placeholder="Enter Target" class="form-control" value="{{$indicator->target}}"></td>
                            <td><input type="number" min="0" max="100" name="indicator[{{$loop->index}}][weight]" placeholder="Enter Weight" class="form-control" value="{{$indicator->weight}}"></td>
                            <td class="text-center"><input type="checkbox" name="indicator[{{$loop->index}}][higherbetter]" class="form-check-input" {{$indicator->higher_better ? "checked" : ''}}></td>
                            <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="d-none"><input type="text" name="indicator[0][id]"></td>
                        <td><input type="text" name="indicator[0][name]" placeholder="Enter Indicator Name" class="form-control" required></td>
                        <td><input type="text" name="indicator[0][description]" placeholder="Enter Description" class="form-control" required></td>
                        <td><input type="number" min="0" name="indicator[0][target]" placeholder="Enter Target" class="form-control" required></td>
                        <td><input type="number" min="0" max="100" name="indicator[0][weight]" placeholder="Enter Weight" class="form-control" required></td>
                        <td class="text-center"><input type="checkbox" name="indicator[0][higherbetter]" class="form-check-input" checked></td>
                        <td><button type="button" class="btn btn-danger remove-tr">Remove</button></td>
                    </tr>
                @endif
            </table>
            <button type="button" name="add" id="add-btn" class="btn btn-success">Add Indicator</button>
        </div>
        <div class="text-end me-2 mb-2">
            <button type="submit" class="btn btn-primary">Save Form</button>
        </div>
    </form>
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{$error}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{session()->get('message')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    var type = {!! json_encode($type) !!};
    var formDetailData = {!! json_encode($formDetailData) !!};
    var i = 1;
    if(type == 'update' && formDetailData.length > 0){
        i = formDetailData.length;
    }
    $("#add-btn").click(function(){
        $("#dynamicAddRemove").append('<tr><td class="d-none"><input type="text" name="indicator['+i+'][id]"></td><td><input type="text" name="indicator['+i+'][name]" placeholder="Enter Indicator Name" class="form-control"></td><td><input type="text" name="indicator['+i+'][description]" placeholder="Enter Description" class="form-control"></td><td><input type="number" name="indicator['+i+'][target]" placeholder="Enter Target" class="form-control"></td><td><input type="text" name="indicator['+i+'][weight]" placeholder="Enter Weight" class="form-control"></td><td class="text-center"><input type="checkbox" name="indicator['+i+'][higherbetter]" class="form-check-input" checked></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
        i++;
    });
    $(document).on('click', '.remove-tr', function(){
        $(this).parents('tr').remove();
    });
</script>

@endsection
