<div class="ibox">
    <div class="ibox-title">
        <h3>{{ $title }}</h3>
    </div>
    <div class="ibox-content">
        <canvas id="doughnutChart"></canvas>
    </div>
</div>

    {!! push_asset_once('js/plugins/chartJs/Chart.min.js') !!}
    <script>
        $(function() {
            var doughnutData = {
                labels: @json($data['labels']),
                datasets: [{
                    data: @json($data['values']),
                    backgroundColor: @json($data['colors'])
                }]
            };

            var doughnutOptions = {
                responsive: true
            };

            var ctx4 = document.getElementById("doughnutChart").getContext("2d");
            new Chart(ctx4, {
                type: 'doughnut',
                data: doughnutData,
                options: doughnutOptions
            });
        });
    </script>
