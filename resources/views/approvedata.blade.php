@extends('layout')

@section('title', 'Approval - Performance Monitoring App')

@section('heading', 'Approve Data')

@php
    $user = auth()->user();
    $children = $user->role->children;
@endphp

@section('content')

<div class="container content-container offwhite-bg">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <th scope="col">No</th>
                <th scope="col">Employee</th>
                <th scope="col">Form</th>
                <th scope="col">Period</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($data as $dt)
                <tr>
                    <th scope="row">{{ ($currentPage-1) * 5 + $loop->iteration }}</th>
                    <td>{{$dt->user->name}}</td>
                    <td>{{$dt->form_name}}</td>
                    <td>{{$dt->period}}</td>
                    <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#approveModal" data-index="{{$dt->id}}" id="approve-modal-btn">Approve</button></td>
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
    <div class="modal fade" id="approveModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Approve KPI</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                </div>
                <div class="modal-footer">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script type="text/javascript">
    $(document).ready(function(){
        $(document).on('click', '#approve-modal-btn', function(e){
            e.preventDefault();
            $('.modal-body').html('');
            $id = $(this).data('index');

            $.ajax({
                url: '/getApprovalDetail/' + $id,
                type: 'GET',
                dataType: 'html'
            })
            .done(function(data){
                $('.modal-body').html('');
                $('.modal-body').html(data);
                $('.modal-footer').html('<form action="/approve/'+$id+'" method="POST">@csrf<button type="submit" class="btn btn-primary mx-2">Approve</button><button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button></form>');
            })
            .fail(function(){
                $('.modal-body').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            });

        });
    });
</script>

@endsection
