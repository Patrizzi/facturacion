<style>
    .table-responsive {
        overflow: visible !important;
    }

    select.form-control:not([size]):not([multiple]) {
        height: 100%;
    }

    .nav-tabs.dropdown-menu {
        left: -112px !important;
        /* padding: 10px 5px !important; */
    }

    #DataTables_Table_0_wrapper {
        /* padding-right: 0px; */
    }

    .table {
        width: 100% !important;
    }

    .ibox-content>.row {
        margin: auto;
    }

    .nav-tabs-right {
        margin-left: auto;
    }

    .search-responsive {
        padding-right: 15px;
        padding-left: 15px;
    }

    .tab-pane.active.show {
        border-right: 1px;
        border-left: 1px;
        border-bottom: 1px;
    }

    .btn-link {
        width: 100%;
    }

    /* OCULTANDO LO DE ORGANIZAR*/
    /* Ver (números) */
    div.dataTables_length {
        display: none;
    }

    /* El Buscar */
    div.dataTables_filter {
        display: none;
    }

    /* CSV, Excel, PDF, Print */
    div.dt-buttons {
        display: none;
    }

    .dropdown-menu {
        left: 70px;
        padding: 20px 0;
    }

    /* PANTALLA TABLET */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .row>.col-md-6 {
            margin-bottom: 12px;
        }
    }

    .slick-slider {
        margin-bottom: 0px;
    }

    .slick-prev {
        left: 20px;
    }

    .slick-next {
        right: 20px;
    }

    .slick-slider>button {
        z-index: 9999;
    }

    .slick-dots {
        display: none !important;
    }

    .tab-pane.active.show {
        border-right: 1px solid #e7eaec;
        border-left: 1px solid #e7eaec;
        border-bottom: 1px solid #e7eaec;
    }

    #DataTables_Table_0_wrapper {
        padding-bottom: 0px;
    }

    .column-actions {
        /* display: inline-flex; */
    }

    .wrapper-hover {
        position: relative;
        display: inline-block;
    }

    .contenedor {
        display: none;
        position: absolute;
        top: -80px;
        left: 20px;
        z-index: 20;
    }

    .wrapper-hover:hover .contenedor {
        display: block;
    }

    .mini-overlay {
        position: relative;
        width: 140px;
        background-color: #fff;
        color: #000;
        font-size: 12px;
        border-radius: 8px;
        padding: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
    }

    .info_overlay {
        text-decoration: underline;
        font-weight: bold;
    }

    .pago_m {
        display: none;
    }

    .pago_m.m_pago_1 {
        display: block;
    }

    #view_all {
        display: none;
    }

    .view_pagos {
        display: none;
    }

</style>
<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
<script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>

<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">

<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


<script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>

<script>
    const topScroll = document.querySelector('.tabs-scroll-top-comprobantes');
    const bottomScroll = document.querySelector('.tabs-scroll-bottom');

    const ghost = document.createElement('div');
    ghost.style.height = "1px";
    topScroll.appendChild(ghost);

    function syncWidth() {
        const ancho = Math.max(bottomScroll.scrollWidth, 720);
        ghost.style.width = ancho + "px";
    }

    // Sincronizar movimientos
    topScroll.addEventListener('scroll', () => {
        bottomScroll.scrollLeft = topScroll.scrollLeft;
    });
    bottomScroll.addEventListener('scroll', () => {
        topScroll.scrollLeft = bottomScroll.scrollLeft;
    });

    window.addEventListener('resize', syncWidth);
    window.addEventListener('load', syncWidth);
    syncWidth();

    //  SCROOLL TABLA RESPONSIVE
    const topScroll2 = document.querySelector('.scrooll-table-responsive');
    const bottomScroll2 = document.querySelector('.table-responsive');

    const ghost2 = document.createElement('div');
    ghost2.style.height = "1px";
    topScroll2.appendChild(ghost2);

    function syncWidth2() {
        const ancho = Math.max(bottomScroll2.scrollWidth, 720);
        ghost2.style.width = ancho + "px";
    }

    // Sincronizar movimientos
    topScroll2.addEventListener('scroll', () => {
        bottomScroll2.scrollLeft = topScroll2.scrollLeft;
    });
    bottomScroll2.addEventListener('scroll', () => {
        topScroll2.scrollLeft = bottomScroll2.scrollLeft;
    });

    window.addEventListener('resize', syncWidth2);
    window.addEventListener('load', syncWidth2);
    syncWidth2();
</script>
