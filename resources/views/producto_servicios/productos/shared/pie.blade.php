<script>
    $(document).ready(function() {
        // C3 PARA PRODUCCTOS
        c3.generate({
            bindto: '#pie',
            data: {
                columns: [
                    ['Activos', {{ $p_statics['activos'] }}],
                    ['Inactivos', {{ $p_statics['inactivos'] }}],
                    ['Anulados', {{ $p_statics['anulados'] }}]
                ],
                colors: {
                    Activos: '#4d7ef7',
                    Inactivos: '#b3b3b3',
                    Anulados: '#e9e9e9'
                },
                type: 'pie'
            }
        });
        // BAR CHART PARA PRODUCTOS
    });
    //Flot Bar Chart
    $(function() {
        var barData = {
            label: "Marcas con más productos",
            data: {!! json_encode($barra_statics['barData'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
        };
        var barOptions = {
            xaxis: {
                ticks: {!! json_encode($barra_statics['ticks'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!}
            },
            series: {
                bars: {
                    show: true,
                    barWidth: 0.6,
                    fill: true,
                    fillColor: {
                        colors: [{
                            opacity: 0.8
                        }, {
                            opacity: 0.8
                        }]
                    }
                }
            },
            colors: ["#1ab394"],
            grid: {
                color: "#999999",
                hoverable: true,
                clickable: true,
                tickColor: "#D4D4D4",
                borderWidth: 0
            },
            legend: {
                show: false
            },
            tooltip: true,
            tooltipOpts: {
                content: "%s: %y productos"
            }
        };

        $.plot($("#flot-producto"), [barData], barOptions);

        // });
        // C3 PARA SERVICIOS
        // c3.generate({
        //     bindto: '#pie2',
        //     data: {
        //         columns: [
        //             ['Activos', {{ $s_statics['activos'] }}],
        //             ['Anulados', {{ $s_statics['anulados'] }}]
        //         ],
        //         colors: {
        //             Activos: '#1ab394',
        //             Inactivos: '#b4e5de'
        //         },
        //         type: 'pie'
        //     }
    });
</script>
