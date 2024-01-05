@extends('layout')

@section('title', 'Dashboard - KPI Monitoring App')

@section('heading', 'Dashboard')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-4 my-2">
            <div class="card">
                <div class="card-body" id="score-card">
                    <h5 class="card-title text-center">Score</h5>
                    <canvas id="score-chart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-8 my-2">
            <div class="card">
                <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <a href="" class="nav-link active">Item 1</a>
                        </li>
                        <li class="nav-item">
                            <a href="" class="nav-link">Item 2</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col my-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Progress</h5>
                    <p class="card-text">Lorem ipsum dolor sit amet consectetur adipisicing elit. Nihil illum cupiditate, vero et iure eveniet enim, minus quos accusamus fugiat minima distinctio assumenda aliquid dolores voluptates doloremque animi velit quae.</p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js"></script> --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script type="text/javascript">
    var score = {!! json_encode($kpiResult->score) !!};
    const ctx = document.getElementById('score-chart').getContext('2d');

    const chartWidth = document.querySelector('#score-card').getBoundingClientRect().width - 34;
    const gradientSegment = ctx.createLinearGradient(0, 0, chartWidth, 0);
    gradientSegment.addColorStop(0, 'red');
    gradientSegment.addColorStop(0.5, 'yellow');
    gradientSegment.addColorStop(1, 'green');

    const data = {
            labels: ['Score', 'Gray Area'],
            datasets: [{
                label: '',
                data: [score, 150-score],
                backgroundColor: [
                    gradientSegment,
                    'rgba(0, 0, 0, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 26, 104, 0.2)',
                    'rgba(0, 0, 0, 0.2)'
                ],
                borderWidth: 1,
                cutout: '75%',
                circumference: 180,
                rotation: 270
            }]
        };

    const gaugeChartText = {
        id: 'gaugeChartText',
        afterDatasetsDraw(chart, args, pluginOptions){
            const {ctx, data, chartArea: {top, bottom, left, right, width, height}, scales: {r}} = chart;

            ctx.save();
            const xCoor = chart.getDatasetMeta(0).data[0].x;
            const yCoor = chart.getDatasetMeta(0).data[0].y;
            const dScore = data.datasets[0].data[0];
            let rating;
            if(dScore < 75){rating = 'Need Improvement';}
            else if(dScore >= 75 && dScore < 100){rating = 'Below Expectation';}
            else if(dScore >= 100 && dScore < 125){rating = 'Meet Expectation';}
            else if(dScore >= 125){rating = 'Above Expectation';}
            else{rating = 'Data Invalid';}

            ctx.font = '15px sans-serif';
            ctx.textBaseLine = 'top';
            ctx.textAlign = 'center';
            ctx.fillText('0', left+20, yCoor+20);
            ctx.fillText('150', right-20, yCoor+20);
            ctx.fillText(rating, xCoor, yCoor-40);
            ctx.font = '32px sans-serif';
            ctx.fillText(dScore, xCoor, yCoor);
        }
    };

    const config = {
        type: 'doughnut',
        data,
        options: {
            aspectRatio: 1.5,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: false
                }
            }
        },
        plugins: [gaugeChartText]
    };

    const scoreChart = new Chart(ctx, config);
</script>

@endsection
