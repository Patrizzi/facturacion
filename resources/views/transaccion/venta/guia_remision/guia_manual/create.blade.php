@extends('layout')

@section('title', ' Guia de Remision Manual')
@section('breadcrumb', ' Guia de Remision Manual')
@section('breadcrumb2', ' Guia de Remision Manual')

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        $(".pro").keypress(function(e) {
            if (e.which == 13) {
                setTimeout(function() {
                    e.target.value += ' | ';
                }, 4);
                e.preventDefault();
            }
        });
    });
</script>
@section('content')

@include('layout_agregado_rapido')
<div class="social-bar">
    <a class="icon icon-facebook" target="_blank" data-toggle="modal" data-target="#ModalCliente"><i class="fa fa-user-o" aria-hidden="true"></i>cliente </a>
</div>


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row bg-white p-4 mx-2">
        <div class="col-lg-6">
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Cliente<span class="required">*</label>
                <div class="col-lg-10">
                     <select class="select2_demo_client" name="cliente" id="cliente" required=""></select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Almacén<span class="required">*</label>
                <div class="col-lg-10">
                    <select name="" id="" class="form-control">
                        <option value="">Opcion 1</option>
                        <option value="">Opcion 2</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class=" col-lg-6 ">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4">F. Emisión<span class="required">*</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control" value="{{date('d-m-Y')}}" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-5">F. Vencimiento<span class="required">*</label>
                        <div class="col-lg-7">
                            <input type="text" value="{{date('d-m-Y')}}" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Sucursal<span class="required">*</label>
                <div class="col-lg-10">
                    <select name="" id="" class="form-control">
                        <option value="">Opcion 1</option>
                        <option value="">Opcion 2</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Motivo<span class="required">*</label>
                <div class="col-lg-10">
                    <select name="" id="" class="form-control">
                        <option value="">Opcion 1</option>
                        <option value="">Opcion 2</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-form-label col-lg-2">Transporte<span class="required">*</label>
                <div class="col-lg-10">
                    <select name="" id="" class="form-control">
                        <option value="">Opcion 1</option>
                        <option value="">Opcion 2</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="col-md-12">
                <div class="form-group row d-flex align-items-center">
                    <label for="" class="col-lg-1 col-md-2">Observación<span class="required">*</label>
                    <div class="col-lg-11 col-md-10">
                        <textarea class="form-control" name="observacion" id="observacion" rows="1"></textarea>
                    </div>
            </div>
        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap');
    .word-style select,
    .word-style input,
    .word-style span{
        font-family: 'Outfit', sans-serif;
        font-size: 11px;
    }
    .required {
    color: red;
    margin-left: 2px;
  }
</style>




<!-- Mi codigo Fabricio-------------------------------------------------------------------------------------------------------------------- -->
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox">
            <div class="ibox-content">
                <div class="row">
                    <div class=" col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading" style="background-color: #007bff; text-align: center;">
                                DATOS DEL CLIENTE
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group row" style="display: flex; align-items: center;">
                                            <label class="col-sm-2" for="opciones" style="font-weight: bold;">Clientes:</label>
                                            <div class="col-sm-10">
                                                <select id="opciones" class="form-control">
                                                    <option value="opcion1">Gringo</option>
                                                    <option value="opcion2">Peruano</option>
                                                    <option value="opcion3">Fantasma</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group row" style="display: flex; align-items: center;">
                                            <label class="col-sm-2" for="n. ruc" style="font-weight: bold;">RUC:</label>
                                            <div class="col-sm-10">
                                                <input type="text" id="n. ruc" class="form-control" placeholder="Ingrese ruc">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-success">
                            <div class="panel-heading" style="background-color: #007bff; text-align: center;">
                                DATOS GENERALES
                            </div>
                            <div class="panel-body">
                                <form>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="texto" style="font-weight: bold">Sucursal:</label>
                                                <div class="col-10">
                                                    <input type="text" id="texto" class="form-control" placeholder="Escribe aquí...">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="texto" style="font-weight: bold;">Ubigeo:</label>
                                                <div class="col-10">
                                                    <input type="text" id="texto" class="form-control" placeholder="Escribe aquí...">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="tipo-transporte" style="font-weight: bold;">Motivo:</label>
                                                <div class="col-10">
                                                    <select id="tipo-transporte" class="form-control">
                                                        <option value="opcion1">Opción 1</option>
                                                        <option value="opcion2">Opción 2</option>
                                                        <option value="opcion3">Opción 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="observacion" style="font-weight: bold;">Observacion:</label>
                                                <div class="col-10">
                                                    <input type="text" id="observacion" class="form-control" placeholder="Escribe aquí...">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="fecha" style="font-weight: bold;">F.Emision:</label>
                                                <div class="col-10">
                                                    <input type="date" id="fecha" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="fecha" style="font-weight: bold;">F.Entrega:</label>
                                                <div class="col-10">
                                                    <input type="date" id="fecha" class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="transporte" style="font-weight: bold;">Transporte:</label>
                                                <div class="col-10">
                                                    <select id="id. transporte" class="form-control">
                                                        <option value="opcion1">Opción 1</option>
                                                        <option value="opcion2">Opción 2</option>
                                                        <option value="opcion3">Opción 3</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row" style="display: flex; align-items: center;">
                                                <label class="col-2" for="n_documento" style="font-weight: bold;">Documento :</label>
                                                <div class="col-10">
                                                    <input type="text" id="texto" class="form-control" placeholder="Escribe aquí...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>


                                <!-- Contenido de Nested Tab 1 -->
                                <div class="table-responsive">
                                    <table class="table table-striped  table-hover">
                                        <br>
                                        <thead>
                                            <tr style="text-align: center;">
                                                <td  style="background-color: #007bff; color: white;">ACCION</td>
                                                <td  style="background-color: #007bff; color: white;">Articulo</td>
                                                <td  style="background-color: #007bff; color: white;">Stock</td>
                                                <td  style="background-color: #007bff; color: white;">Cantidad</td>
                                                <td  style="background-color: #007bff; color: white;">Serie</td>
                                                <td  style="background-color: #007bff; color: white;">P. Unid.</td>
                                                <td  style="background-color: #007bff; color: white;">P. total</td>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <tr  style="align-items: center;">
                                                <td >
                                                    <div>
                                                        <button type="button" class="btn btn-success" id="btn-agregar" onclick="toggleForm()"><i class="fa fa-plus"></i></button>
                                                        <button class="btn btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                                    </div>
                                                </td>
                                                <td >
                                                    <select id="opciones" class="form-control" style="flex-grow: 1;">
                                                        <option value="opcion1"></option>
                                                        <option value="opcion1">Opción 1</option>
                                                        <option value="opcion2">Opción 2</option>
                                                        <option value="opcion3">Opción 3</option>
                                                    </select>
                                                </td>
                                                <td >
                                                    <input type="text" id="stock" class="form-control" placeholder="Stock">
                                                </td>
                                                <td >
                                                    <input type="text" id="n. serie" class="form-control" placeholder="N.serie">
                                                </td>
                                                <td >
                                                    <input type="text" id="cant" class="form-control" placeholder="Cant">
                                                </td>
                                                <td >
                                                    <input type="text" id="n. serie" class="form-control" placeholder="Peso en KG">
                                                </td>
                                                <td >
                                                    <input type="text" id="n. serie" class="form-control" placeholder="Total en KG">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div>
                                    <button class="btn btn-success" style="margin-right: 10px; background-color: #007bff;">Guardar</button>
                                </div>




                                <!-- Formulario oculto -->
                        <div id="form-container" style="display: none; position: fixed; top: 40%; left: 50%; transform: translate(-50%, -50%); background-color: white; border-radius: 5px; padding: 10px; text-align: center;">
                            <div class="modal-content">
                                <h2 style="background-color: #007bff; color: white; text-align: center;">CONSULTAR PRODUCTO</h2>
                                <div cclass="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <td class="col-md-2" style="background-color: #007bff; color: white;">ID</td>
                                                <td class="col-md-3" style="background-color: #007bff; color: white;">CODIGO</td>
                                                <td class="col-md-5" style="background-color: #007bff; color: white;">PRODUCTO</td>
                                                <td class="col-md-2" style="background-color: #007bff; color: white;">STOCK</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="col-md-2">
                                                <input type="text" id="texto" class="form-control" placeholder="Id">
                                            </td>
                                            <td class="col-md-3">
                                                <input type="text" id="texto" class="form-control" placeholder="Codigo">
                                            </td>
                                            <td class="col-md-5">
                                                <input type="text" id="texto" class="form-control" placeholder="Producto">
                                            </td>
                                            <td class="col-md-2">
                                                <input type="text" id="texto" class="form-control" placeholder="Stock">
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                                <hr>
                                <div cclass="table-responsive">
                                    <table class="table table-striped table-bordered">
                                        <tbody>
                                        <tr>
                                            <td class="col-md-2">
                                                <h5>0001</h5>
                                            </td>
                                            <td class="col-md-3">
                                                <h5>15236</h5>
                                            </td>
                                            <td class="col-md-5">
                                                <h5>monitor teros</h5>
                                            </td>
                                            <td class="col-md-2">
                                                <h5>25</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-2">
                                                <h5>0002</h5>
                                            </td>
                                            <td class="col-md-3">
                                                <h5>25638</h5>
                                            </td>
                                            <td class="col-md-5">
                                                <h5>placa madre</h5>
                                            </td>
                                            <td class="col-md-2">
                                                <h5>56</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="col-md-2">
                                                <h5>0003</h5>
                                            </td>
                                            <td class="col-md-3">
                                                <h5>69526</h5>
                                            </td>
                                            <td class="col-md-5">
                                                <h5>mouse gamer envidia</h5>
                                            </td>
                                            <td class="col-md-2">
                                                <h5>120</h5>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <hr>
                                </div>
                            </div>
                        </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








<style>
    label.col-form-label::marker{
        list-style:none;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        font-size: 12px;
    }
    .select2-container--default .select2-selection--single {
        border: none;
    }
    span.select2.select2-container.select2-container--default{
        width: 100%!important;
        background-color: #FFFFFF;
        background-image: none;
        border-radius: 1px;
        display: block;
        padding: 3px 12px;
        border: 1px solid #e5e6e7;
    }
    .select2-hidden-accessible{
        width: auto !important;

    }
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] { -moz-appearance:textfield; }
    @media only screen and (max-width: 1497px){
        .td_selected > span.select2.select2-container.select2-container--default{
            min-width: 376px !important;
        }
    }
</style>
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<!-- Jquery Validate -->
<script src="{{asset('js/plugins/validate/jquery.validate.min.js')}}"></script>

<!-- Steps -->
<script src="{{asset('js/plugins/steps/jquery.steps.min.js')}}"></script>
<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(document).ready(function() {
        articlesSelect2();
        $('.select2_demo_almacen').select2();
    });

    $(".select2_demo_client").select2({
        placeholder: "Seleccionar Cliente",
        ajax: {
            minimumInputLength: 1,
            url: "{{ route('pa.clients') }}",
            dataType: 'json',
            type: "POST",
            delay: 10,
            data: function (params) {
                return {
                    _token: "{{ csrf_token() }}",
                    search: params.term // search term
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            id: item.id,
                            text: item.nombre + ' | ' +  item.numero_documento,
                        };
                    })
                };
            },
            cache: true
        }
    });
    function articlesSelect2() {
        $(".select2_demo_productos").select2({
            placeholder: "Seleccionar Producto",
            ajax: {
                minimumInputLength: 1,
                url: "{{ route('pa.ajax_remision') }}",
                dataType: 'json',
                type: "POST",
                // delay: 1500,
                data: function (params) {
                    return {
                        _token: "{{ csrf_token() }}",
                        id: params.id,
                        search: params.term, // search term
                        tipo_doc: 'manual'

                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                id:  item.id + " | " + item.cod_prod + " | " + item.cod_origi + " | " + item.nombre,
                                text: item.id + " | " + item.cod_prod + " | " + item.cod_origi + " | " + item.nombre,
                            };
                        })
                    };
                },
                cache: true,
                passive: true
            }
        });

    }
    function ajax(a){
        if(a==0){
            var articulo = document.getElementById(`articulo`).value;
        }else{
            var articulo = document.getElementById(`articulo${a}`).value;
        }
        $.ajax({
            type: "post",
            url: "{{ route('remision_m.peso_ajax') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'articulo': articulo
            },
            success: function (msg) {
                $(`#peso${a}`).val(msg);
                $(`#peso_view${a}`).val(msg);
                $(`#peso_ori${a}`).val(msg);
                sum_total();
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });

    }
    //
    var i = 2;
    $(".addmore").on('click', function () {
        var data = `[
            <tr>
                <td>
                    <button type="button" class='delete borrar e btn btn-danger'><i class="fa fa-trash" aria-hidden="true"></i></button>
                </td>
                <td class="td_selected">
                    <select class="select2_demo_productos" name="articulo[]" id="articulo${i}" style="width: 100%;" onchange="ajax(${i})" required></select>
                    <textarea class="form-control" name="descripcion[]" placeholder="Detalle del Producto" id="" rows="1" style="margin-top: 5px"></textarea>
                </td>
                <td>
                    <input style="min-width: 100px" type="text" name="cantidad[]" id="cantidad${i}" class="form-control" required onkeypress="return event.charCode >= 48 && event.charCode <= 57" onkeyup="peso_view_p(${i});sum_total()" >
                </td>
                <td>
                    <textarea style="min-width: 250px" name="serie[]"  id="n_serie${i}"  class="form-control" placeholder="Numero de Serie"></textarea>
                </td>
                <td>
                    <div class="input-group" style="min-width: 140px">
                        <input  type="text" name="peso[]" id="peso${i}" class="form-control" required step="0.01" onkeypress="return event.charCode >= 46 && event.charCode <= 57" onkeyup="peso_view_p(${i});sum_total()" >
                        <div class="input-group-append">
                            <span class="input-group-addon">KG</span>
                        </div>
                        <input style="min-width: 100px" type="hidden" name="peso_view" id="peso_view${i}" onkeyup="sum_total()">
                        <input style="min-width: 100px" type="hidden" name="peso_ori" id="peso_ori${i}" onkeyup="sum_total()">
                    </div>
                </td>
                <td>
                    <div class="input-group" style="min-width: 130px">
                        <input  type="text" name="peso_tot[]" step="0.01" disabled  id="peso_tot${i}" class="form-control" required onkeypress="return event.charCode >= 46 && event.charCode <= 57" onkeyup="sum_total()">
                        <div class="input-group-append">
                            <span class="input-group-addon">KG</span>
                        </div>
                        </div>
                </td>
            </tr>
        ]`;
        $('.tables').append(data);
        articlesSelect2();
        i++
    });
    $(document).on('click', '.borrar', function (event) {
        event.preventDefault();
        var e = document.getElementsByClassName("e").length;
        var fila = $(this).parents("tr");
        // ELIMINAR TR
        if (e>1) {
            fila.closest('tr').remove();
            $(".borrar").prop("disabled", false);
            $(".addmore").prop("disabled", false);
        }else{
            $(".borrar").prop("disabled", true);
            $(".addmore").prop("disabled", false);
        }
    });
    function test(a) {
        var x = (a.value || a.options[a.selectedIndex].value);  //crossbrowser solution =)
        if (x ==2)/*Transaporte Privado*/
        {
            document.getElementById("transporte_privado").removeAttribute("hidden");
            document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_privado").setAttribute("required", "required");
            document.getElementById("conductor").setAttribute("required", "required");
            document.getElementById("vehiculo_publico").removeAttribute("required");

        }
        if(x==0)/*Sin Transporte*/
        {
            document.getElementById("transporte_privado").setAttribute("hidden", "hidden");
            document.getElementById("transporte_publico").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_publico").removeAttribute("required");
            document.getElementById("vehiculo_privado").removeAttribute("required");
            document.getElementById("conductor").removeAttribute("required");


        }
        if(x==1)/*Transporte Público*/
        {
            document.getElementById("transporte_publico").removeAttribute("hidden");
            document.getElementById("transporte_privado").setAttribute("hidden", "hidden");

            document.getElementById("vehiculo_publico").setAttribute("required", "required");
            document.getElementById("vehiculo_privado").removeAttribute("required");
            document.getElementById("conductor").removeAttribute("required");
        }
    }
    function almacen_cod(){
        var almacen = $('#almacen').val();
        console.log(almacen);
        $.ajax({
            type: "post",
            url: "{{ route('remision_m.almacen_remision_m') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'almacen': almacen
            },
            success: function (msg) {
                $('#cod_guia').html(msg);
            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });

    }
    function peso_view_p(a){
        var peso = $(`#peso${a}`).val();
        var cantidad = $(`#cantidad${a}`).val();
        console.log(peso);
        $(`#peso_view${a}`).val(peso);
        $(`#peso_tot${a}`).val(peso * cantidad);
        $(`#peso_ori${a}`).val(peso * cantidad);
    }

    function sum_total(){
        var total_t = 0;
        var totalInp = $('[name="peso_ori"]');
        console.log(totalInp)
        // console.log(totalInp);
        totalInp.each(function(){
            if (!isNaN(parseFloat($(this).val()))) {
            total_t += parseFloat($(this).val());
            }
        });
        var tot = total_t;
        console.log(tot);
        $('#peso_total').val(tot);

    }
    function mult_peso(b){
        // var cantidad = $(`#cantidad${b}`).val();
        // var peso_ori = $(`#peso_ori${b}`).val();
        // var peso_multi = parseInt(cantidad) * parseFloat(peso_ori);
        // $(`#peso_view${b}`).val(peso_multi);
        // $(`#peso${b}`).val(peso_multi);
        // sum_total();



        // $(`#peso${b}`).val(peso_multi);



        // // var
    }
    function change_cli(){
        var cliente = $('#cliente').val();
        $('#sucursal_list').empty();
        $('#postal_input').val("");
        $('#sucursal_input').val("");
        $.ajax({
            type: "post",
            url: "{{ route('guia_remision.ajax_sucursal') }}",
            data: {
                '_token': $('input[name=_token]').val(),
                'cliente': cliente
            },
            success: function (msg) {

                let cod_co = msg.cod_postal;
                let msg_length = cod_co.length;
                // console.log(msg_length)
                var list = document.getElementById('sucursal_list');
                var p_list = document.getElementById('postal_cod_list');

                if(msg_length == 1){
                    $('#sucursal_input').val(msg.sucursal[0]);
                    $('#postal_input').val(msg.cod_postal[0]);
                    document.getElementById('input_post_array').value = msg.cod_postal[0];
                    document.getElementById('input_suc_array').value = msg.sucursal[0];
                }else{
                    $('#sucursal_input').attr('placeholder','Seleccionar Sucursal');
                    $('#postal_input').attr('placeholder','Selec. Codigo Ubigeo');
                    for (let i = 0; i < msg_length; i++) {
                        var option = document.createElement('option');
                        option.value = msg.sucursal[i];
                        list.appendChild(option);
                        document.getElementById('input_post_array').value = msg.cod_postal;
                        document.getElementById('input_suc_array').value = msg.sucursal;

                        // var option2 = document.createElement('option');
                        // option2.value = msg.cod_postal[i];
                        // p_list.appendChild(option2);
                    }
                }

                // sum_total();

            },
            error: function(eject) {
                if(eject.status===400){
                    console.log(eject.responseJSON.error);
                }
            },
            cache:true
        });
    }
    function select_sucursal(){
        var valor_input = $('#sucursal_input').val();
        var all_suc = document.getElementById('input_suc_array').value;
        var all_postal = document.getElementById('input_post_array').value;
        // CODIGO PARA SEPARAR LAS SUCURSALES
        const split_suc = all_suc.split(',');
        // CODIGO PARA SEPARAR LASA SUCURSALES
        const split_post = all_postal.split(',');
        for (let i_suc = 0; i_suc < split_suc.length; i_suc++) {
            var el_suc = split_suc[i_suc];
            console.log(el_suc);
            if(el_suc == valor_input){
                $('#postal_input').val(split_post[i_suc]);
            }

        }
    }
    function delete_guion(string){//solo letras y numeros
        return string.replace(/-/g, "");
    }
</script>
<script>
    // Mostrar el formulario de buscar producto
    document.getElementById("btn-agregar").onclick = function() {
        var formContainer = document.getElementById("form-container");
        formContainer.style.display = formContainer.style.display === "none" ? "block" : "none";
    };
</script>
@endsection
