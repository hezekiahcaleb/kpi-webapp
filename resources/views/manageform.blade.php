@extends('layout')

@section('title', 'Manage Form - KPI Monitoring App')

@section('heading')
    <a href="/manageform" class="heading no-style">Manage Form</a>
@endsection

@section('content')

<div class="container content-container offwhite-bg">
    <div class="text-end mb-2">
        <a href="/addform" class="btn btn-primary" id="addFormBtn">Add Form</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Form Name</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $dt)
            <tr>
                <td>{{ ($currentPage-1) * 5 + $loop->iteration }}</td>
                <td><a href="/detail/{{$dt->id}}" class="text-dark">{{$dt->form_name}}</a></td>
                <td>{{$dt->form_description}}</td>
                <td class="d-flex">
                    <a href="/editform/{{$dt->id}}" class="me-4"><i class="bi-pencil-square"></i></a>
                    <button type="button" class="unstyled-button delete-button" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="bi-trash3"></i></button>
                </td>
            </tr>
            @empty
                <td>Data not found.</td>
            @endforelse
        </tbody>
    </table>
    <nav>
        <ul class="pagination justify-content-center">
            <li class="page-item"><a class="page-link" href="{{$data->previousPageUrl()}}">Previous</a></li>
            <li class="page-item"><a class="page-link" href="{{$data->nextPageUrl()}}">Next</a></li>
        </ul>
    </nav>
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
                    <form action="/delete-form/{{$dt->id}}" method="POST">
                        {{method_field('delete')}}
                        {{csrf_field()}}
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
