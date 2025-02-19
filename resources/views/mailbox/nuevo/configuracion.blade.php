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
                                <button class="btn btn-success mr-2" style="background-color: blue; border-color:blue;">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>

                            <div class="tab-content">
                                <!-- Contenido de Tab 1 -->
                                <div role="tabpanel" id="tab-1" class="tab-pane ">
                                </div>

                                <!-- Contenido de Tab 2 -->
                                <div role="tabpanel" id="tab-2" class="tab-pane">
                                </div>

                                <!-- Contenido de Tab 3 -->
                                <div role="tabpanel" id="tab-3" class="tab-pane active show">
                                    <div class="panel-body">
                                        <div class="row">
                                            <p>Gaby</p>
                                        </div>
                                    </div>
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
        $('#tab-3').addClass('active show');
  
});

</script>


@endsection