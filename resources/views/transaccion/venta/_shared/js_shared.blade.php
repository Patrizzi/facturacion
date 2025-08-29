<style>
    select.form-control:not([size]):not([multiple]) {
        height: 100%;
    }

    .dropdown-menu {
        left: 70px;
        padding: 20px 0;
    }

    .dataTables_wrapper {
        padding-bottom: 0px !important;
    }

    .table {
        width: 100% !important;
    }

    .ibox-content>.row {
        margin: auto;
    }

    .nav-tabs-right {
        margin-left: auto;
        /* Esto empuja el tab hacia la derecha */
    }

    .search-responsive {
        padding-right: 15px;
        padding-left: 15px;
    }

    .tab-pane.active.show {
        border-right: 1px solid #e7eaec;
        border-left: 1px solid #e7eaec;
        border-bottom: 1px solid #e7eaec;
    }

    .btn-link {
        width: 100%;
    }

    /* OCULTANDO LO DE ORGANIZAR*/
    /* Ver (números) */
    div.dataTables_length {
        /* display: none; */
    }

    /* El Buscar */
    div.dataTables_filter {
        /* display: none; */
    }

    /* CSV, Excel, PDF, Print */
    div.dt-buttons {
        /* display: none; */
    }

    /* PANTALLA TABLET */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .row>.col-md-6 {
            margin-bottom: 12px;
        }
    }
</style>

<script>
    const topScroll = document.querySelector('.tabs-scroll-top');
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
