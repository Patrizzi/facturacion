@extends('layout')
@section('title', 'Inicio')
@section('atributo_actu', 'hidden')
@section('atributo_1', 'hidden')

@section('foto', auth()->user()->avatar)
@section('nombre', auth()->user()->personal->nombres)
@section('area', auth()->user()->name)
@section('content')
<style>
    ul{padding-left: 0px;}
</style>
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5 style="color:#0073c1"><img src="{{asset('sunat.png')}}" width="25px">SUNAT</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                     <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none">
                                <span class="label label-success float-right">18%</span>
                                <h5>IGV </h5>
                            </div>
                            <div class="ibox-content" align="center">
                                <h1>{{$moneda_nacional->simbolo.round($igv_nacional,2)}}</h1>
                                <small >Calculo aproximado del impuesto a pagar</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none" >
                                <span class="label label-info float-right">{{strftime('%B')}}</span>
                                <h5>Facturas del Mes</h5>
                            </div>
                            <div class="ibox-content" align="center">
                                <h1 > {{$coun_fac_mes}} </h1>
                                <small>Calculo Exacto de Facturas Creadas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none">
                                <span class="label label-info float-right">{{strftime('%B')}}</span>
                                <h5>Boletas Del Mes</h5>
                            </div>
                            <div class="ibox-content" align="center">
                                <h1>{{$coun_bol_mes}}</h1>
                                <small>Calculo Exacto de Boletas Creadas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="ibox ">
                            <div class="ibox-title" style="border-top:none">
                                <span class="label label-success float-right">{{date('d-m-Y')}}</span>
                                <h5>Tipo de Cambio</h5>
                            </div>
                            <div class="ibox-content">
                                <div class="row">
                                    <div class="col-sm-6"><small>Compra :</small><h1>{{$consulta->compra}}</h1> </div>
                                    <div class="col-sm-6"><small>Venta :</small><h1>{{$consulta->venta}}</h1></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-4">
        <div class="ibox ">
            <div class="ibox-title">
                <h5>Messages</h5>
            </div>
            <div class="ibox-content ibox-heading">
                <h3><i class="fa fa-envelope-o"></i> New messages</h3>
                <small><i class="fa fa-tim"></i> You have 22 new messages and 16 waiting in draft folder.</small>
            </div>
            <div class="ibox-content">
                <div class="feed-activity-list">

                    <div class="feed-element">
                        <div>
                            <small class="float-right text-navy">1m ago</small>
                            <strong>Monica Smith</strong>
                            <div>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum</div>
                            <small class="text-muted">Today 5:60 pm - 12.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="float-right">2m ago</small>
                            <strong>Jogn Angel</strong>
                            <div>There are many variations of passages of Lorem Ipsum available</div>
                            <small class="text-muted">Today 2:23 pm - 11.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="float-right">5m ago</small>
                            <strong>Jesica Ocean</strong>
                            <div>Contrary to popular belief, Lorem Ipsum</div>
                            <small class="text-muted">Today 1:00 pm - 08.06.2014</small>
                        </div>
                    </div>

                    <div class="feed-element">
                        <div>
                            <small class="float-right">5m ago</small>
                            <strong>Monica Jackson</strong>
                            <div>The generated Lorem Ipsum is therefore </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>


                    <div class="feed-element">
                        <div>
                            <small class="float-right">5m ago</small>
                            <strong>Anna Legend</strong>
                            <div>All the Lorem Ipsum generators on the Internet tend to repeat </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="float-right">5m ago</small>
                            <strong>Damian Nowak</strong>
                            <div>The standard chunk of Lorem Ipsum used </div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>
                    <div class="feed-element">
                        <div>
                            <small class="float-right">5m ago</small>
                            <strong>Gary Smith</strong>
                            <div>200 Latin words, combined with a handful</div>
                            <small class="text-muted">Yesterday 8:48 pm - 10.06.2014</small>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">

        <div class="row">
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Usuario Activo</h5>
                    </div>
                    <div class="ibox-content table-responsive">
                        <div class="widget-head-color-box navy-bg p-lg text-center" style="background:#23c6c8 !important">
                            <div class="m-b-md">
                            <h3 class="font-bold no-margins">{{ auth()->user()->personal->nombres}} {{ auth()->user()->personal->apellidos}} </h3>
                            <small>Asuario interacuando en el sistema</small></div>
                            {{-- <img src="img/a4.jpg" class="rounded-circle circle-border m-b-md" alt="profile"> --}}
                              <img alt="image" class="rounded-circle circle-border m-b-md" src=" {{ asset('/profile/images/')}}/{{auth()->user()->avatar}} " />
                            <div>
                                <span>100 Tweets</span> |
                                <span>350 Following</span> |
                                <span>610 Followers</span>
                            </div>
                        </div>
                        <div class="widget-text-box">
                            <h4 class="media-heading">Alex Smith</h4>
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                            <div class="text-right">
                                <a href=""  class="btn btn-xs btn-white"><i class="fa fa-thumbs-up"></i> Like </a>
                                <a href="" class="btn btn-xs btn-primary"><i class="fa fa-heart"></i> Love</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Small todo list</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <ul class="todo-list m-t small-list">
                            <li>
                                <a href="#" class="check-link"><i class="fa fa-check-square"></i> </a>
                                <span class="m-l-xs todo-completed">Buy a milk</span>

                            </li>
                            <li>
                                <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                <span class="m-l-xs">Go to shop and find some products.</span>

                            </li>
                            <li>
                                <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                <span class="m-l-xs">Send documents to Mike</span>
                                <small class="label label-primary"><i class="fa fa-clock-o"></i> 1 mins</small>
                            </li>
                            <li>
                                <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                <span class="m-l-xs">Go to the doctor dr Smith</span>
                            </li>
                            <li>
                                <a href="#" class="check-link"><i class="fa fa-check-square"></i> </a>
                                <span class="m-l-xs todo-completed">Plan vacation</span>
                            </li>
                            <li>
                                <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                <span class="m-l-xs">Create new stuff</span>
                            </li>
                            <li>
                                <a href="#" class="check-link"><i class="fa fa-square-o"></i> </a>
                                <span class="m-l-xs">Call to Anna for dinner</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox ">
                    <div class="ibox-title">
                        <h5>Transactions worldwide</h5>
                        <div class="ibox-tools">
                            <a class="collapse-link">
                                <i class="fa fa-chevron-up"></i>
                            </a>
                            <a class="close-link">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">

                        <div class="row">
                            <div class="col-lg-6">
                                <table class="table table-hover margin bottom">
                                    <thead>
                                        <tr>
                                            <th style="width: 1%" class="text-center">No.</th>
                                            <th>Transaction</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-center">1</td>
                                            <td> Security doors
                                            </td>
                                            <td class="text-center small">16 Jun 2014</td>
                                            <td class="text-center"><span class="label label-primary">$483.00</span></td>

                                        </tr>
                                        <tr>
                                            <td class="text-center">2</td>
                                            <td> Wardrobes
                                            </td>
                                            <td class="text-center small">10 Jun 2014</td>
                                            <td class="text-center"><span class="label label-primary">$327.00</span></td>

                                        </tr>
                                        <tr>
                                            <td class="text-center">3</td>
                                            <td> Set of tools
                                            </td>
                                            <td class="text-center small">12 Jun 2014</td>
                                            <td class="text-center"><span class="label label-warning">$125.00</span></td>

                                        </tr>
                                        <tr>
                                            <td class="text-center">4</td>
                                            <td> Panoramic pictures</td>
                                            <td class="text-center small">22 Jun 2013</td>
                                            <td class="text-center"><span class="label label-primary">$344.00</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">5</td>
                                            <td>Phones</td>
                                            <td class="text-center small">24 Jun 2013</td>
                                            <td class="text-center"><span class="label label-primary">$235.00</span></td>
                                        </tr>
                                        <tr>
                                            <td class="text-center">6</td>
                                            <td>Monitors</td>
                                            <td class="text-center small">26 Jun 2013</td>
                                            <td class="text-center"><span class="label label-primary">$100.00</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6">
                                <div id="world-map" style="height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @include('partials.page_script_general')
