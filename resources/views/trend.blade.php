<hr />
<div class="container">
    <div class="row">
        test
        <canvas id="trend-chart"></canvas>
    </div>
</div>

<script type="text/javascript">
    const trendCtx = document.getElementById('trend-chart').getContext('2d');

    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

    const trendData = {
        labels: months,
        datasets: [{
            label: 'My First Dataset',
            data: [65, 59, 80, 81, 56, 55, 40, 65, 59, 80, 81, 56],
            fill: false,
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    };

    const trendConfig = {
        type: 'line',
        data: trendData,
    };

    const trendChart = new Chart(trendCtx, trendConfig);
</script>
