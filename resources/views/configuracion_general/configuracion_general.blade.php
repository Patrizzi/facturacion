 @extends('layout')

 @section('title', 'Configuración Sistema')
 @section('atributo_actu', 'hidden')
 @section('atributo_1', 'hidden')

 @section('content')

     @php
         use App\Categoria;
         $categorias = Categoria::get();

         //  use App\Familia;
         //  $familias = Familia::get();

         //  use App\Garantia;
         //  $garantia = Garantia::get();

         //  use App\Marca;
         //  $marcas = Marca::get();

         use App\Motivo;
         $motivos_compra = Motivo::get();
         $motivos_dev = Motivo::get();

         use App\TipoCambio;
         $tipo_cambio = TipoCambio::get();

         use App\Unidad_medida;
         $unidad_de_medida = Unidad_medida::get();

         use App\Validez;
         $validez = Validez::get();
     @endphp

     <div class="wrapper wrapper-content animated fadeInRight">
         <div class="row">
             <div class="col-lg-12">
                 <div class="ibox">
                     <div class="ibox-content d-flex justify-content-center">
                         <div class="row d-flex justify-content-between p-4">
                             <!-- Elementos de la fila -->
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <a href="{{ route('almacen.index') }}">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/almacen.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">ALMACÉN</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <a href="{{ route('apariencia.index') }}">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/apariencia.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">APARIENCIA</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <!--
                                                                                                            <a href="{{ route('categoria.index') }}">
                                                                                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/categoria.svg') }}" width="50px" alt="">
                                                                                                                <p class="pt-md-3 display-6 fs-4 text-white">CATEGORÍAS</p>
                                                                                                            </a>-->
                                     <a data-toggle="modal" href="#modal-forms5">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/categoria.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">CATEGORÍAS</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button" id="familia_button">
                                     <a data-toggle="modal" href="">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/familia.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">FAMILIAS</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button" id="garantia_button">
                                     <a data-toggle="modal" href="">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/garantia.png') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">GARANTÍA</p>
                                     </a>
                                 </button>
                             </div>

                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button" id="marcas_button">
                                     <a data-toggle="modal" href="#modal-forms7">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/marca.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">MARCAS</p>
                                     </a>
                                 </button>
                             </div>

                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <!--
                                                                                                            <a href="{{ route('motivo.index') }}">
                                                                                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/motivo.svg') }}" width="50px" alt="">
                                                                                                                <p class="pt-md-3 display-6 fs-4 text-white">MOTIVO</p>
                                                                                                            </a>-->
                                     <a data-toggle="modal" href="#modal-forms3">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/motivo.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">MOTIVOS</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <!--
                                                                                                            <a href="{{ route('tipo_cambio.index') }}">
                                                                                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/tipo-cambio.svg') }}" width="50px" alt="">
                                                                                                                <p class="pt-md-3 display-6 fs-4 text-white">TIPO CAMBIO</p>
                                                                                                            </a>-->
                                     <a data-toggle="modal" href="#modal-forms">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/tipo-cambio.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">TIPO CAMBIO</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <!--
                                                                                                            <a href="{{ route('unidad-medida.index') }}">
                                                                                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/unidad_medida.svg') }}" width="50px" alt="">
                                                                                                                <p class="pt-md-3 display-6 fs-4 text-white">U. DE MEDIDA</p>
                                                                                                            </a>-->
                                     <a data-toggle="modal" href="#modal-forms2">
                                         <img class="rounded bg-white p-2"
                                             src="{{ asset('img/logos/unidad_medida.svg') }}" width="50px"
                                             alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">U.DE MEDIDA</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <a href="{{ route('usuarios.index') }}">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/usuarios.svg') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">USUARIOS</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <button class="btn btn-success dim tam pt-4" type="button">
                                     <!-- <a href="{{ route('validez.index') }}">
                                                                                                                <img class="rounded bg-white p-2" src="{{ asset('img/logos/validez.png') }}" width="50px" alt="">
                                                                                                                <p class="pt-md-3 display-6 fs-4 text-white">VALIDEZ</p>
                                                                                                            </a>-->
                                     <a data-toggle="modal" href="#modal-forms8">
                                         <img class="rounded bg-white p-2" src="{{ asset('img/logos/validez.png') }}"
                                             width="50px" alt="">
                                         <p class="pt-md-3 display-6 fs-4 text-white">VALIDEZ</p>
                                     </a>
                                 </button>
                             </div>
                             <div class="col-lg-3 col-md-6 d-flex justify-content-center my-md-4">
                                 <!-- ELEMENTO FANTASMA - RELLENO -->
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>

     @include('configuracion_general.tipo_cambio.modal_create')

     @include('configuracion_general.unidad-de-medida.modal_create')

     @include('configuracion_general.motivo.modal_create')

     @include('configuracion_general.garantia.modal_create')

     @include('configuracion_general.categoria.modal_create')

     @include('configuracion_general.familia.modal_create')

     @include('configuracion_general.marca.modal_create')

     @include('configuracion_general.validez.modal_create')


     <!-- fin código Gaby-->
     <style>
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

         /* Tamaño de los botones del index */
         .tam {
             min-width: 150px;
             min-height: 150px;
         }

         .familia_descripcion {
             text-align: left;
         }

         .modal.fade.modal-xl-manual.show {
             /* left: 18%; */
         }

         .modal-xl-manual {
             margin: auto;
             max-width: 1140px !important;
             /* width: 1140px !important; */
         }

         .img_marcas {
             height: 100%;
             width: 100%;
         }
     </style>

     <script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
     <script src="{{ asset('js/popper.min.js') }}"></script>
     <script src="{{ asset('js/bootstrap.js') }}"></script>
     <script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
     <script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

     <script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
     <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>

     <script src="{{ asset('js/plugins/fullcalendar/moment.min.js') }}"></script>
     <script src="{{ asset('js/plugins/daterangepicker/daterangepicker.js') }}"></script>
     <script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>

     <!-- Data picker -->
     <script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js') }}"></script>
     <script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>

     <script src="{{ asset('js/plugins/jqueryMask/jquery.mask.min.js') }}"></script>
     <script src="{{ asset('js/plugins/jsKnob/jquery.knob.js') }}"></script>
     <script src="{{ asset('js/plugins/nouslider/jquery.nouislider.min.js') }}"></script>
     <script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
     <script src="{{ asset('js/plugins/ionRangeSlider/ion.rangeSlider.min.js') }}"></script>
     <script src="{{ asset('js/plugins/colorpicker/bootstrap-colorpicker.min.js') }}"></script>
     <script src="{{ asset('js/plugins/clockpicker/clockpicker.js') }}"></script>
     <script src="{{ asset('js/plugins/touchspin/jquery.bootstrap-touchspin.min.js') }}"></script>
     <script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
     <script src="{{ asset('js/plugins/bootstrap-tagsinput/bootstrap-tagsinput.js') }}"></script>
     <script src="{{ asset('js/plugins/dualListbox/jquery.bootstrap-duallistbox.js') }}"></script>
     <script src="{{ asset('js/plugins/cropper/cropper.min.js') }}"></script>

     <!-- Custom and plugin javascript -->
     <script src="{{ asset('js/inspinia.js') }}"></script>
     <script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>


     <script>
         $(document).ready(function() {
             $('.dataTables-categorias').DataTable({
                 pageLength: 25,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: []
             });
         });
     </script>
     {{-- 
     <script>
         $(document).ready(function() {
             $('.dataTables-marcas').DataTable({
                 pageLength: 10,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: []
             });
         });
     </script> --}}

     <script>
         $('#familia_button').on('click', function() {
             $('#modal-familia').modal('show');
             if (!$.fn.DataTable.isDataTable('.dataTables-familias')) {
                 $('.dataTables-familias').DataTable({
                     "serverSide": true,
                     "ajax": {
                         url: "{{ route('api.get_familias') }}",
                         method: "get",
                         data: function(d) {},
                         dataSrc: function(json) {
                             return json.data;
                         }
                     },
                     "pageLength": 10,
                     "columnDefs": [{
                         'targets': [0]
                     }, {
                         'targets': [1],
                         'className': 'familia_descripcion'
                     }, {
                         'targets': [2]
                     }, {
                         'targets': [3]
                     }, {
                         'targets': [4],
                         'render': function(data, type, full, meta) {
                             return "<a href='{{ route('familia.show', '') }}/" + full[0] +
                                 "'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a>";
                         }
                     }]
                 });
             } else {
                 // Si ya está inicializado, solo recarga los datos
                 $('.dataTables-familias').DataTable().ajax.reload();
             }
         });
         $('#garantia_button').on('click', function() {
             $('#modal-garantia').modal('show');
             if (!$.fn.DataTable.isDataTable('.dataTables-garantia')) {
                 $('.dataTables-garantia').DataTable({
                     "serverSide": true,
                     "ajax": {
                         url: "{{ route('api.get_garantias') }}",
                         method: "get",
                         data: function(d) {},
                         dataSrc: function(json) {
                             return json.data;
                         }
                     },
                     "pageLength": 10,
                     "columnDefs": [{
                         'targets': [0]
                     }, {
                         'targets': [1],
                         'className': 'garantia_descripcion'
                     }, {
                         'targets': [2],
                         'render': function(data, type, full, meta) {
                             return "<a href='{{ route('garantia.show', '') }}/" + full[0] +
                                 "'><button type='button' class='btn btn-success btn-sm'><i class='fa fa-eye'></i></button></a>";
                         }
                     }]
                 });
             } else {
                 // Si ya está inicializado, solo recarga los datos
                 $('.dataTables-garantia').DataTable().ajax.reload();
             }
         });
         //  Marcas
         function datatable_marcas() {
             $('.dataTables-marcas').DataTable({
                 "serverSide": true,
                 "ajax": {
                     url: "{{ route('api.get_marcas') }}",
                     method: "get",
                     data: function(d) {
                         d.value = $('#search_marca').val();
                     },
                     dataSrc: function(json) {
                         return json.data;
                     }
                 },
                 "pageLength": 10,
                 "columnDefs": [{
                     'targets': [4],
                     'render': function(data, type, full, meta) {
                         if (!data || data.trim() === "") {
                             return `<img src="{{ asset('archivos/imagenes/no-image') }}/" class="img_marcas" alt="Imagen cargada" width="20vmax">`;
                         }
                         return `<img src="{{ asset('archivos/imagenes/marcas/') }}/${data}" class="img_marcas" alt="Imagen cargada" width="20vmax">`;
                     }
                 }]
             });
         }
         $('#search_marca').keyup(function() {
             $('.dataTables-marcas').DataTable().ajax.reload();
         });
         $('#marcas_button').on('click', function() {
             console.log("marca boton")
             $('#modal-marcas').modal('show');
             if (!$.fn.DataTable.isDataTable('.dataTables-marcas')) {
                 datatable_marcas();
             } else {
                 $('.dataTables-marcas').DataTable().ajax.reload();
             }
         });
     </script>

     <script>
         //  $('#')
         //      $('.dataTables-garantia').DataTable({
         //          pageLength: 10,
         //          responsive: true,
         //          dom: '<"html5buttons"B>lTfgitp',
         //          buttons: []
         //      });
         //  });
     </script>

     <script>
         $(document).ready(function() {
             table1 = $('.dataTables-motivos1').DataTable({
                 pageLength: 12,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: [{
                         extend: 'copy'
                     },
                     {
                         extend: 'csv'
                     },
                     {
                         extend: 'excel',
                         title: 'ExampleFile'
                     },
                     {
                         extend: 'pdf',
                         title: 'ExampleFile'
                     },

                 ]

             });
             $('input[name="daterangemotivos1"]').daterangepicker({

                     "locale": {
                         "separator": " | ",
                         "applyLabel": "Guardar",
                         "cancelLabel": "Cancelar",
                         "fromLabel": "Desde",
                         "toLabel": "Hasta",
                         "customRangeLabel": "Custom",
                         "daysOfWeek": [
                             "Do",
                             "Lu",
                             "Ma",
                             "Mi",
                             "Ju",
                             "Vi",
                             "Sa"
                         ],
                         "monthNames": [
                             "Enero",
                             "Febrero",
                             "Marzo",
                             "Abril",
                             "Mayo",
                             "Junio",
                             "Julio",
                             "Agosto",
                             "Septiembre",
                             "Octubre",
                             "Noviembre",
                             "Diciembre"
                         ],
                         "firstDay": 1
                     }
                 },
                 function(start, end, label) {
                     var dates = [];
                     var currentDate = new Date(start);
                     while (currentDate <= end) {
                         var day = ('0' + currentDate.getDate()).slice(-2);
                         var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                         var year = currentDate.getFullYear();

                         var formattedDate = day + '-' + month + '-' + year;
                         dates.push(formattedDate);

                         currentDate.setDate(currentDate.getDate() + 1);
                     }
                     var dateRangeString = dates.join('|');
                     console.log(dateRangeString);
                     table1.column(2).search(dateRangeString, true, false).draw();
                 }
             );
         });

         function limpiar_select() {
             table1.column(2).search("").draw();
         }

         function revert_select() {
             table1.column(2).search(`{{ date('m-Y') }}`).draw();
         }
     </script>

     <script>
         $(document).ready(function() {
             table2 = $('.dataTables-motivos2').DataTable({
                 pageLength: 12,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: [{
                         extend: 'copy'
                     },
                     {
                         extend: 'csv'
                     },
                     {
                         extend: 'excel',
                         title: 'ExampleFile'
                     },
                     {
                         extend: 'pdf',
                         title: 'ExampleFile'
                     },

                     {
                         extend: 'print',
                         customize: function(win) {
                             $(win.document.body).addClass('white-bg');
                             $(win.document.body).css('font-size', '10px');

                             $(win.document.body).find('table')
                                 .addClass('compact')
                                 .css('font-size', 'inherit');
                         }
                     }
                 ]

             });
             $('input[name="daterangemotivos2"]').daterangepicker({

                     "locale": {
                         "separator": " | ",
                         "applyLabel": "Guardar",
                         "cancelLabel": "Cancelar",
                         "fromLabel": "Desde",
                         "toLabel": "Hasta",
                         "customRangeLabel": "Custom",
                         "daysOfWeek": [
                             "Do",
                             "Lu",
                             "Ma",
                             "Mi",
                             "Ju",
                             "Vi",
                             "Sa"
                         ],
                         "monthNames": [
                             "Enero",
                             "Febrero",
                             "Marzo",
                             "Abril",
                             "Mayo",
                             "Junio",
                             "Julio",
                             "Agosto",
                             "Septiembre",
                             "Octubre",
                             "Noviembre",
                             "Diciembre"
                         ],
                         "firstDay": 1
                     }
                 },
                 function(start, end, label) {
                     var dates = [];
                     var currentDate = new Date(start);
                     while (currentDate <= end) {
                         var day = ('0' + currentDate.getDate()).slice(-2);
                         var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                         var year = currentDate.getFullYear();

                         var formattedDate = day + '-' + month + '-' + year;
                         dates.push(formattedDate);

                         currentDate.setDate(currentDate.getDate() + 1);
                     }
                     var dateRangeString = dates.join('|');
                     console.log(dateRangeString);
                     table2.column(2).search(dateRangeString, true, false).draw();
                 }
             );
         });

         function limpiar_select() {
             table2.column(2).search("").draw();
         }

         function revert_select() {
             table2.column(2).search(`{{ date('m-Y') }}`).draw();
         }
     </script>

     <script>
         $(document).ready(function() {
             table3 = $('.dataTables-cambio12').DataTable({
                 pageLength: 12,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: [{
                         extend: 'copy'
                     },
                     {
                         extend: 'csv'
                     },
                     {
                         extend: 'excel',
                         title: 'ExampleFile'
                     },
                     {
                         extend: 'pdf',
                         title: 'ExampleFile'
                     },

                     {
                         extend: 'print',
                         customize: function(win) {
                             $(win.document.body).addClass('white-bg');
                             $(win.document.body).css('font-size', '10px');

                             $(win.document.body).find('table')
                                 .addClass('compact')
                                 .css('font-size', 'inherit');
                         }
                     }
                 ]

             });
             $('input[name="daterangecambio"]').daterangepicker({

                     "locale": {
                         "separator": " | ",
                         "applyLabel": "Guardar",
                         "cancelLabel": "Cancelar",
                         "fromLabel": "Desde",
                         "toLabel": "Hasta",
                         "customRangeLabel": "Custom",
                         "daysOfWeek": [
                             "Do",
                             "Lu",
                             "Ma",
                             "Mi",
                             "Ju",
                             "Vi",
                             "Sa"
                         ],
                         "monthNames": [
                             "Enero",
                             "Febrero",
                             "Marzo",
                             "Abril",
                             "Mayo",
                             "Junio",
                             "Julio",
                             "Agosto",
                             "Septiembre",
                             "Octubre",
                             "Noviembre",
                             "Diciembre"
                         ],
                         "firstDay": 1
                     }
                 },
                 function(start, end, label) {
                     var dates = [];
                     var currentDate = new Date(start);
                     while (currentDate <= end) {
                         var day = ('0' + currentDate.getDate()).slice(-2);
                         var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                         var year = currentDate.getFullYear();

                         var formattedDate = day + '-' + month + '-' + year;
                         dates.push(formattedDate);

                         currentDate.setDate(currentDate.getDate() + 1);
                     }
                     var dateRangeString = dates.join('|');
                     console.log(dateRangeString);
                     table3.column(5).search(dateRangeString, true, false).draw();
                 }
             );
         });

         function limpiar_select() {
             table3.column(5).search("").draw();
         }

         function revert_select() {
             table3.column(5).search(`{{ date('m-Y') }}`).draw();
         }
     </script>

     <script>
         $(document).ready(function() {
             table4 = $('.dataTables-medida').DataTable({
                 pageLength: 12,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: [{
                         extend: 'copy'
                     },
                     {
                         extend: 'csv'
                     },
                     {
                         extend: 'excel',
                         title: 'ExampleFile'
                     },
                     {
                         extend: 'pdf',
                         title: 'ExampleFile'
                     },

                     {
                         extend: 'print',
                         customize: function(win) {
                             $(win.document.body).addClass('white-bg');
                             $(win.document.body).css('font-size', '10px');

                             $(win.document.body).find('table')
                                 .addClass('compact')
                                 .css('font-size', 'inherit');
                         }
                     }
                 ]

             });
             $('input[name="daterangemedida"]').daterangepicker({

                     "locale": {
                         "separator": " | ",
                         "applyLabel": "Guardar",
                         "cancelLabel": "Cancelar",
                         "fromLabel": "Desde",
                         "toLabel": "Hasta",
                         "customRangeLabel": "Custom",
                         "daysOfWeek": [
                             "Do",
                             "Lu",
                             "Ma",
                             "Mi",
                             "Ju",
                             "Vi",
                             "Sa"
                         ],
                         "monthNames": [
                             "Enero",
                             "Febrero",
                             "Marzo",
                             "Abril",
                             "Mayo",
                             "Junio",
                             "Julio",
                             "Agosto",
                             "Septiembre",
                             "Octubre",
                             "Noviembre",
                             "Diciembre"
                         ],
                         "firstDay": 1
                     }
                 },
                 function(start, end, label) {
                     var dates = [];
                     var currentDate = new Date(start);
                     while (currentDate <= end) {
                         var day = ('0' + currentDate.getDate()).slice(-2);
                         var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                         var year = currentDate.getFullYear();

                         var formattedDate = day + '-' + month + '-' + year;
                         dates.push(formattedDate);

                         currentDate.setDate(currentDate.getDate() + 1);
                     }
                     var dateRangeString = dates.join('|');
                     console.log(dateRangeString);
                     table4.column(5).search(dateRangeString, true, false).draw();
                 }
             );
         });

         function limpiar_select() {
             table4.column(5).search("").draw();
         }

         function revert_select() {
             table4.column(5).search(`{{ date('m-Y') }}`).draw();
         }
     </script>

     <script>
         $(document).ready(function() {
             $('.dataTables-validez').DataTable({
                 pageLength: 10,
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 buttons: []
             });
         });
     </script>

     <style>
         .dropdown-menu {
             left: 70px;
             padding: 20px 0;
         }

         #DataTables_Table_0_wrapper {
             padding-right: 0px;
         }

         .table {
             width: 100% !important;
         }

         .ibox-content>.row {
             margin: auto;
         }
     </style>

     <script>
         $(document).ready(function() {
             $('.i-checks').iCheck({
                 checkboxClass: 'icheckbox_square-green',
                 radioClass: 'iradio_square-green',
             });

         });
     </script>

     <!-- Page-Level Scripts -->
     <script>
         $(document).ready(function() {
             table = $('.dataTables-example-facturacion').DataTable({
                 pageLength: 10,
                 order: [
                     [0, "desc"]
                 ],
                 responsive: true,
                 dom: '<"html5buttons"B>lTfgitp',
                 footerCallback: function(tr, data, start, end, display) {
                     var api = this.api(),
                         data;

                     // Remove the formatting to get integer data for summation
                     var intVal = function(i) {
                         return typeof i === 'string' ?
                             i.replace(/[\$,]/g, '') * 1 :
                             typeof i === 'number' ?
                             i : 0;
                     };

                     // Total over all pages
                     total = api
                         .column(5)
                         .data()
                         .reduce(function(a, b) {
                             return intVal(a) + intVal(b);
                         }, 0);

                     // Total filtered rows on the selected column (code part added)
                     var sumCol4Filtered = display.map(el => data[el][5]).reduce((a, b) => intVal(a) +
                         intVal(b), 0);

                     // Update footer
                     $(api.column(5).footer()).html(
                         'S/ ' + Math.round(sumCol4Filtered * 100) / 100
                     );
                 },
                 buttons: []
             });

             revert_select();

             $(document).on('change', '#select_tipo_coti', function(event) {
                 var nombre = $("#select_tipo_coti option:selected").val();
                 // console.log(nombre);
                 table.column(11).search(nombre).draw();
             });
             $('input[name="daterange"]').daterangepicker({
                     "locale": {
                         "separator": " | ",
                         "applyLabel": "Guardar",
                         "cancelLabel": "Cancelar",
                         "fromLabel": "Desde",
                         "toLabel": "Hasta",
                         "customRangeLabel": "Custom",
                         "daysOfWeek": [
                             "Do",
                             "Lu",
                             "Ma",
                             "Mi",
                             "Ju",
                             "Vi",
                             "Sa"
                         ],
                         "monthNames": [
                             "Enero",
                             "Febrero",
                             "Marzo",
                             "Abril",
                             "Mayo",
                             "Junio",
                             "Julio",
                             "Agosto",
                             "Septiembre",
                             "Octubre",
                             "Noviembre",
                             "Diciembre"
                         ],
                         "firstDay": 1
                     }
                 },
                 function(start, end, label) {
                     var dates = [];
                     var currentDate = new Date(start);
                     while (currentDate <= end) {
                         var day = ('0' + currentDate.getDate()).slice(-2);
                         var month = ('0' + (currentDate.getMonth() + 1)).slice(-2);
                         var year = currentDate.getFullYear();

                         var formattedDate = day + '-' + month + '-' + year;
                         dates.push(formattedDate);

                         currentDate.setDate(currentDate.getDate() + 1);
                     }
                     var dateRangeString = dates.join('|');
                     console.log(dateRangeString);
                     table.column(4).search(dateRangeString, true, false).draw();
                 }
             );
         });

         $(".select2_demo_1").select2();
         $(".select2_demo_2").select2();
         $(".select2_demo_3").select2({
             placeholder: "Tipo",
             allowClear: true
         });

         function limpiar_select() {
             table.column(4).search("").draw();
         }

         function revert_select() {
             table.column(4).search(`{{ date('m-Y') }}`).draw();
         }
     </script>
 @stop
