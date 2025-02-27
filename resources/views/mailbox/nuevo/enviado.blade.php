@extends('layout')
@section('title', 'Email')
@section('breadcrumb', 'Email')
@section('breadcrumb2', 'Email')

@section('atributo_1', 'hidden')
@section('atributo_actu', 'hidden')
@section('content')

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox">
                <div class="panel panel-success">
                    <div class="panel-heading text-center">
                    <h2><strong> Correo</strong></h2>
                    </div>
                    <div class="ibox-content">
                        <div class="tabs-container">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <ul class="nav nav-tabs" role="tablist">
                                @include('mailbox\nuevo\tabs')
                                </ul>
                                <a href="#crear" data-toggle="modal">
                                    <button class="btn btn-success mr-2" style="background-color: blue; border-color:blue;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </a>
                            </div>

                            <div class="tab-content">
                                <!-- Contenido de Tab 1 -->
                                <div role="tabpanel" id="tab-1" class="tab-pane active show">
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-md-5 mb-2">
                                                <div class="input-group">
                                                    <input type="search" id="search" class="form-control" placeholder="Buscar...">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="button" style="background-color: blue; border-color:blue;">Buscar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5 mb-2">
                                                <div class="input-group">
                                                    <input type="text" id="daterange" name="daterange" class="form-control" value="{{ date('m/01/Y') }} - {{ date('m/t/Y') }}">
                                                    <div class="input-group-append">
                                                        <button type="button" class="btn btn-secondary" onclick="revert_select()">
                                                            <i class="fa fa-history"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-primary" style="background-color: blue; border-color:blue;" onclick="limpiar_select()">
                                                            <i class="fa fa-eraser"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2 mb-2 d-flex justify-content-end">
                                                <button class="btn btn-danger mr-2"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover text-center datatables-enviado">
                                                <thead>
                                                    <tr>
                                                        <th><input type="checkbox"  class="i-checks" name="input[]"></th>
                                                        <th>Correo</th>
                                                        <th>Motivo</th>
                                                        <th>Fecha</th>
                                                        <th>Adjunto</th>
                                                        <th>Acción</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><input type="checkbox"  class="i-checks" name="input[]"></td>
                                                        <td>jyp@gmail.com</td>
                                                        <td>eqwqweqwqe</td>
                                                        <td>10-02-2024</td>
                                                        <td>Doc</td>
                                                        <td>
                                                            <a href="#ver" data-toggle="modal">
                                                                <button class="btn btn-success btn-sm">
                                                                    <i class="fa fa-eye"></i>
                                                                </button>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contenido de Tab 2 -->
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                </div>

                                <!-- Contenido de Tab 3 -->
                                <div role="tabpanel" id="tab-3" class="tab-pane">
                                </div>

                                <!-- Contenido de Tab 4 -->
                                <div role="tabpanel" id="tab-4" class="tab-pane">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Fin -->

@include('mailbox\nuevo\ver')
@include('mailbox\nuevo\crear')

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

<!-- check -->
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script src="{{ asset('js/icheck.min.js') }}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>
<link href="{{asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
<!-- Jasny -->
<script src="{{asset('js/plugins/jasny/jasny-bootstrap.min.js')}}"></script>
<link href="{{asset('css/plugins/jasny/jasny-bootstrap.min.css')}}" rel="stylesheet">

<link href="{{asset('css/plugins/codemirror/codemirror.css')}}" rel="stylesheet">
<!-- Switchery -->
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">

<!-- Chosen -->
<script src="{{ asset('js/plugins/chosen/chosen.jquery.js') }}"></script>
<link href="{{ asset('css/plugins/chosen/bootstrap-chosen.css') }}" rel="stylesheet">

<script>
    $(document).ready(function(){
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
</script>

<script>
    $(document).ready(function(){
        $('.summernote').summernote();
        var elem = document.querySelector('.js-switch');
        var switchery = new Switchery(elem, { color: '#1AB394' });
   });

   $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>

<script>
    $(document).ready(function () {
        // Add slimscroll to element
        $('.scroll_content').slimscroll({
            height: '350px'
        })
    });

</script>

<script>
    $(document).ready(function(){
        $(".select2_demo_1").select2();
        $(".select2_demo_2").select2();
        $(".select2_demo_3").select2({
            placeholder: "Select a state",
            allowClear: true
        });
        $('.chosen-select').chosen({width: "100%"});
    });
</script>

<style>
    #DataTables_Table_0_length{
        display:none;
    }
    #DataTables_Table_0_filter{
        display: none;
    }
    div.dt-buttons{
        display: none;
    }
</style>

<script>
    $(document).ready(function () {
        $('#tab-1').addClass('active show');

        $('.datatables-enviado').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons"B>lTfgitp',
            buttons: []
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

    function limpiar_select() {
        table.column(4).search("").draw();
    }
    function revert_select() {
        table.column(4).search(`{{ date('m-Y') }}`).draw();
    }

</script>



@endsection
