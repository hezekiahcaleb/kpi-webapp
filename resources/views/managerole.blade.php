@extends('layout')

@section('title', 'Manage Role - KPI Monitoring App')

@section('heading')
    <a href="/managerole" class="heading no-style">Manage Role</a>
@endsection

@section('content')

<div class="text-end">
    <button type="button" class="btn btn-primary modal-button" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-action="Add" data-url="/addrole/">Add Role</button>
</div>

<table class="table table-hover align-middle">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Role Name</th>
            <th scope="col">Parent</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse($data as $dt)
        <tr>
            <th scope="row">{{ ($currentPage-1) * 5 + $loop->iteration }}</th>
            <td>{{$dt->role_name}}</td>
            <td>
                @if ($dt->parent)
                    {{$dt->parent->role_name}}
                @else
                    -
                @endif
            </td>
            <td class="d-flex">
                <button class="unstyled-button update-button modal-button" data-bs-toggle="modal" data-bs-target="#addRoleModal" data-action="Edit" data-url="/editrole/{{$dt->id}}" data-bs-index="{{$dt->id}}"><i class="bi-pencil-square"></i></button>
                <form action="/delete-role/{{$dt->id}}" method="POST">
                    {{method_field('delete')}}
                    {{csrf_field()}}
                    <button class="unstyled-button delete-button"><i class="bi-trash3"></i></button>
                </form>
            </td>
        </tr>
        @empty
            <td>Data not found.</td>
        @endforelse
    </tbody>
</table>
<div class="modal fade" id="addRoleModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Manage Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>
<nav>
    <ul class="pagination">
        <li class="page-item"><a class="page-link" href="{{$data->previousPageUrl()}}">Previous</a></li>
        <li class="page-item"><a class="page-link" href="{{$data->nextPageUrl()}}">Next</a></li>
    </ul>
</nav>
@if (session()->has('message'))
    <div class="text-center my-4">
        <i class="text-success">{{session()->get('message')}}</i>
    </div>
@endif

@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '.modal-button', function(e){
            e.preventDefault();

            var url = $(this).data('url');
            var action = $(this).data('action');

            $('.modal-title').text(action+' Role');

            $('.modal-body').html('');

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(data){
                $('.modal-body').html('');
                $('.modal-body').html(data);
            })
            .fail(function(){
                $('.modal-body').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            });

        });
    });
</script>

@endsection
