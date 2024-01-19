@extends('layout')

@section('title', 'Profile - KPI Monitoring App')

@section('heading', 'Profile')

@section('content')

<div class="container content-container offwhite-bg">
    <ul class="nav nav-tabs" id="tab-nav">
        <li class="nav-item">
            <a class="nav-link active" id="personal-data-tab" data-bs-toggle="tab" href="#personal-data">Personal Data</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="update-password-tab" data-bs-toggle="tab" href="#update-password">Password</a>
        </li>
    </ul>

    <div class="tab-content" id="tab-content">
        <div class="tab-pane fade active show" id="personal-data">
            @include('personaldata')
        </div>

        <div class="tab-pane fade" id="update-password">
            @include('updatepassword')
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
