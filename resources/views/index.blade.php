@extends('layout')

@section('title', 'KPI Monitoring App')

@section('heading', 'Home')

@section('content')
    <h1>Welcome to KPI Monitoring App</h1>
    <p>Input, monitor and analyze your employees performance.</p>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Data Input</div>
                <div class="card-body">
                    <p>Input your monthly performance data.</p>
                    {{-- <a href="{{ route('realtime-metrics') }}" class="btn btn-primary">View Real-time Metrics</a> --}}
                    <a class="btn btn-primary">Input KPI Data</a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Historical Reports</div>
                <div class="card-body">
                    <p>Generate historical reports to analyze performance over time, identify bottlenecks, and make data-driven decisions.</p>
                    {{-- <a href="{{ route('historical-reports') }}" class="btn btn-primary">View Historical Reports</a> --}}
                    <a class="btn btn-primary">View Historical Reports</a>
                </div>
            </div>
        </div>
    </div>
@endsection
