 <style>
     select.form-control:not([size]):not([multiple]) {
         height: 100%;
     }

     .dropdown-menu {
         left: 70px;
         padding: 20px 0;
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
         /* Esto empuja el tab hacia la derecha */
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
 </style>
 <!-- Mainly scripts -->
 <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
 <script src="{{ asset('js/popper.min.js') }}"></script>
 <script src="{{ asset('js/bootstrap.js') }}"></script>
 <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
 <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

 <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
 <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

 <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
 <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
 <!-- Custom and plugin javascript -->
 <script src="{{ asset('js/inspinia.js') }}"></script>
 <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


 <script src="{{ asset('js/plugins/slick/slick.min.js') }}"></script>

 <!-- check -->
 <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
 <script src="{{ asset('js/icheck.min.js') }}"></script>
