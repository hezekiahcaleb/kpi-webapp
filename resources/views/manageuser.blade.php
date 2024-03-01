@extends('layout')

@section('title', 'Manage User - KPI Monitoring App')

@section('heading')
    <a href="/manageuser" class="heading no-style">Manage User</a>
@endsection

@section('content')
<div class="container content-container offwhite-bg">
    <div class="text-end mb-2">
        <button type="button" class="btn btn-primary modal-button addedit-button" data-bs-toggle="modal" data-bs-target="#addUserModal" data-action="Add" data-url="/adduser/">Add User</button>
    </div>

    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $dt)
            <tr>
                <th scope="row">{{ ($currentPage-1) * 10 + $loop->iteration }}</th>
                <td>{{$dt->name}}</td>
                <td>{{$dt->email}}</td>
                <td>{{$dt->role_id==null ? '-' : $dt->role->role_name}}</td>
                <td class="d-flex">
                    <button class="unstyled-button update-button modal-button addedit-button" data-bs-toggle="modal" data-bs-target="#addUserModal" data-action="Edit" data-url="/edituser/{{$dt->id}}" data-bs-index="{{$dt->id}}"><i class="bi-pencil-square"></i></button>
                    <button type="button" class="unstyled-button delete-button" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi-trash3"></i></button>
                </td>
            </tr>
            @empty
                <td>Data not found.</td>
            @endforelse
        </tbody>
    </table>
    <div class="modal fade" id="addUserModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Manage User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <form action="/delete-user/{{$dt->id}}" method="POST">
                        {{method_field('delete')}}
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="{{$data->previousPageUrl()}}">Previous</a></li>
            <li class="page-item"><a class="page-link" href="{{$data->nextPageUrl()}}">Next</a></li>
        </ul>
    </nav>

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
    $(document).ready(function(){
        $(document).on('click', '.addedit-button', function(e){
            e.preventDefault();

            var url = $(this).data('url');
            var action = $(this).data('action');

            $('#addUserModal .modal-title').text(action+' User');

            $('#addUserModal .modal-body').html('');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(data){
                $('#addUserModal .modal-body').html('');
                $('#addUserModal .modal-body').html(data);
            })
            .fail(function(){
                $('#addUserModal .modal-body').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            });

        });
    });
</script>

@endsection
