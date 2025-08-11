<!-- d3 and c3 charts -->
<script src="{{ asset('js/plugins/d3/d3.min.js') }}"></script>
<script src="{{ asset('js/plugins/c3/c3.min.js') }}"></script>
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
    // C3 PARA SERVICIOS
    c3.generate({
        bindto: '#pie2',
        data: {
            columns: [
                ['Activos', {{ $s_statics['activos'] }}],
                ['Anulados', {{ $s_statics['anulados'] }}]
            ],
            colors: {
                Activos: '#1ab394',
                Inactivos: '#b4e5de'
            },
            type: 'pie'
        }
    });
</script>
