@extends('layout')

@section('title', 'Dashboard - Performance Monitoring App')

@section('heading', 'Dashboard')

@php
    $user = auth()->user();
    $children = $user->role->children;
@endphp

@section('content')

<div class="container">
    <div class="row">
        <div class="col-lg-4 my-2">
            <div class="card shadow-sm">
                <div class="card-body text-center" id="score-card">
                    <h5 class="card-title">Average Score</h5>
                    <canvas id="score-chart"></canvas>
                    <h2>{{empty($latestKpi) ? '-' : $latestKpi['score']}}</h2>
                    <p>{{empty($latestKpi) ? '-' : $latestKpi['evaluation']}}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-8 my-2">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center">Details</h5>
                    <input type="month" name="period" id="reportperiod" class="">
                    @if (!$children->isEmpty())
                        <select id="reportemployee">
                            <option value="{{$user->id}}">{{$user->role->role_name}} - {{$user->name}}</option>
                            @foreach ($children as $child)
                                @foreach ($child->users as $employees)
                                    <option value="{{$employees->id}}"><b>{{$child->role_name}}</b> - {{$employees->name}}</option>
                                @endforeach
                            @endforeach
                        </select>
                    @endif
                    <button type="button" class="btn btn-primary" id="reportbutton">Go</button>
                    <div id="dynamic-report">
                    </div>
                    <div class="spinner-container d-flex justify-content-center d-none" id="report-spinner">
                        <div class="spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 my-2">
            <div class="card shadow-sm">
                <div class="card-body row">
                    <h5 class="card-title">Progress</h5>
                    <select id="trendperiod" class="col-1">
                        @foreach (range($yearRange[0], $yearRange[1]) as $year)
                            <option value="{{$year}}" {{$yearRange[0] == $year ? 'selected' : ''}}>{{$year}}</option>
                        @endforeach
                    </select>
                    <select id="trendemployee" name="employees[]" multiple="multiple" class="col-4">
                        <option value="{{$user->id}}">{{$user->role->role_name}} - {{$user->name}}</option>
                        @if (!$children->isEmpty())
                                @foreach ($children as $child)
                                    @foreach ($child->users as $employees)
                                        <option value="{{$employees->id}}">{{$child->role_name}} - {{$employees->name}}</option>
                                    @endforeach
                                @endforeach
                        @endif
                    </select>
                    <button type="button" class="btn btn-primary col-1" id="trendbutton">Go</button>
                    <hr class="my-3"/>
                    <div id="dynamic-trend" class="row">
                        <div class="spinner-container d-flex justify-content-center d-none" id="trend-spinner">
                            <div class="spinner-border" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                        </div>
                        <canvas id="trend-chart" class="col-12 d-none"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
    //gaugeChart
    var latestKpi = JSON.parse('{!!json_encode($latestKpi)!!}');
    var score = 0;
    var evaluation = "-";
    if(latestKpi.length > 0 || latestKpi.length != 0){
        score = latestKpi['score'];
        evaluation = latestKpi['evaluation'];
    }

    const ctx = document.getElementById('score-chart').getContext('2d');

    const data = {
            labels: ['Need Improvement', 'Below Expectation', 'Meet Expectation', 'Above Expectation'],
            datasets: [{
                label: 'Score',
                data: [75, 25, 25, 25],
                backgroundColor: [
                    'rgba(251, 105, 98, 1)',
                    'rgba(252, 252, 153, 1)',
                    'rgba(121, 222, 121, 1)',
                    'rgba(12, 192, 120, 1)'
                ],
                borderColor: [
                    'rgba(255, 255, 255, 1)'
                ],
                borderWidth: 5,
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

            ctx.font = '15px sans-serif';
            ctx.textBaseLine = 'top';
            ctx.textAlign = 'center';
            ctx.fillText('0', left+20, yCoor+20);
            ctx.fillText('150', right-20, yCoor+20);
        }
    };

    const gaugeNeedle = {
        id : 'gaugeNeedle',
        afterDatasetsDraw(chart, args, plugins){
            const{ctx, data} = chart;

            ctx.save();
            const xCenter = chart.getDatasetMeta(0).data[0].x;
            const yCenter = chart.getDatasetMeta(0).data[0].y;
            const outRadius = chart.getDatasetMeta(0).data[0].outerRadius;
            const innerRadius = chart.getDatasetMeta(0).data[0].innerRadius;
            const midSlice = (outRadius - innerRadius) / 2;
            const radius = 10;
            const angle = Math.PI / 180;
            const needleValue = score;
            const dataTotal = data.datasets[0].data.reduce((a, b) => a + b, 0);
            const circumference = ((chart.getDatasetMeta(0).data[0].circumference / Math.PI) / data.datasets[0].data[0]) * needleValue;

            ctx.translate(xCenter, yCenter);
            ctx.rotate(Math.PI * (circumference + 1.5))

            ctx.beginPath();
            ctx.strokeStyle = 'black';
            ctx.fillStyle = 'black';
            ctx.lineWidth = 1;
            ctx.moveTo(0-radius, 0);
            ctx.lineTo(0, 0 - innerRadius - midSlice);
            ctx.lineTo(0+radius, 0);
            ctx.closePath();
            ctx.stroke();
            ctx.fill();

            ctx.beginPath();
            ctx.arc(0, 0, radius, 0, angle * 360, false);
            ctx.fill();

            ctx.restore();
        }
    };

    const config = {
        type: 'doughnut',
        data,
        options: {
            layout : {
                // padding: {
                //     bottom: 20
                // }
            },
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
        plugins: [gaugeChartText, gaugeNeedle]
    };

    const scoreChart = new Chart(ctx, config);

    $(document).ready(function(){
        function showSpinner(spinnerId) {
            $(spinnerId).removeClass('d-none');
        }

        function hideSpinner(spinnerId) {
            $(spinnerId).addClass('d-none');
        }

        $('#trendemployee').select2({
            placeholder: "Select employees"
        });
        var userHasChildren = {!!json_encode(!$children->isEmpty())!!};
        //reports
        $('#reportbutton').on("click" ,function(){
            $('#dynamic-report').html('');
            showSpinner('#report-spinner');
            var selectedPeriod = $('#reportperiod').val();
            var selectedUser = $('#reportemployee').val();
            var url = '/getReport/' + selectedPeriod;
            if(userHasChildren){
                url = '/getChildReport/' + selectedPeriod + '/' + selectedUser;
            }
            if(selectedPeriod != ''){
                $.ajax({
                url: url,
                type: 'GET',
                success: function(response){
                    hideSpinner('#report-spinner');
                    $('#dynamic-report').html(response);
                }
                })
                .fail(function(){
                    hideSpinner('#report-spinner');
                    $('#dynamic-report').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
                });
            } else {
                hideSpinner('#report-spinner');
            }
        });

        //trends
        $('#trendbutton').on("click", function(){
            showSpinner('#trend-spinner');
            var selectedPeriod = $('#trendperiod').val();
            var selectedUser = $('#trendemployee').select2('data');
            var arrUser = selectedUser.map(i => i.id);
            $.ajax({
                url: '/getKpiByYear/' + selectedPeriod + '/' + encodeURIComponent(JSON.stringify(arrUser)),
                type: 'GET',
                dataType: 'json',
                success: function(data){
                    createTrendChart(data);
                }
            })
            .fail(function(){
                hideSpinner('#trend-spinner');
                $('#trend-chart').addClass('d-none');
                $('#dynamic-trend').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
            });
        });

        function createTrendChart(rawData){
            var trendChart = Chart.getChart("trend-chart");
            if(trendChart){
                trendChart.destroy();
            }
            $('#trend-chart').removeClass('d-none');
            let trendCtx = document.getElementById('trend-chart').getContext('2d');
            let months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

            const data = [];
            for(const user of new Set(rawData.map((d) => d.user_id))){
                const name = rawData.find((d) => d.user_id === user).name;
                const scoresByMonth = Array(12).fill(null);
                const scoreData = rawData.filter((d) => d.user_id === user).forEach((d) => {
                    const {month, score} = d;
                    scoresByMonth[month - 1] = score;
                });
                data.push({label: name, data: scoresByMonth});
            }

            var datasets = [];
            data.forEach(item => {
                const dataset = {
                    label: item.label,
                    data: item.data,
                    spanGaps: true
                };
                datasets.push(dataset);
            });
            console.log(datasets);

            const trendData = {
                labels: months,
                datasets: datasets
            };

            const trendConfig = {
                type: 'line',
                data: trendData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 150,
                            ticks: {
                                stepSize: 10
                            }
                        }
                    }
                }
            };

            hideSpinner('#trend-spinner');
            trendChart = new Chart(trendCtx, trendConfig);
            trendChart.update();
        }
    });
</script>
@endsection
