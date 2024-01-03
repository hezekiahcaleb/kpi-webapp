@extends('layout')

@section('title', 'Manage Form - KPI Monitoring App')

@section('heading')
    <a href="/manageform" class="heading no-style">Manage Form</a>
@endsection

@section('content')

<div class="text-end">
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
                <form action="/delete-form/{{$dt->id}}" method="POST">
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
