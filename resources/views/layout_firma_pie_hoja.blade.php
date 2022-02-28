
<div class="row">
    <div class="col-sm-3">
        <p><u>Atendido Por: </u></p>
        Teléfono :  {{$empresa->telefono}}<br>
        Celular : {{$cotizacion->user_personal->celular }}<br>
        Email : {{$cotizacion->user_personal->email_user}}<br>
        Web : {{$empresa->pagina_web}} <br>
    </div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3"></div>
    <div class="col-sm-3"><br><br>
        @if(empty($firma))
        @else
        <center><img src="{{asset('archivos/imagenes/firma_digital/'.$firma)}}" style="" width="150px" height="100px"></center>
        @endif
        <hr>
        <center>{{$cotizacion->user_personal->nombre}}</center>
    </div>
</div>