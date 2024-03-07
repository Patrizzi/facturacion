<div class="col-sm-4 text-center" align="center">
    {{-- <address class="col-sm-4" align="left"> --}}
        <img src="{{asset('img/logos/')}}/{{$empresa->foto}}" alt="" style="max-width: 100%">
    {{-- </address> --}}
</div>
<div class="col-sm-4 text-center" style="font-size: 13px">
    <strong>{{$empresa->razon_social}}</strong>
    <br>
        Tel.: {{$empresa->telefono}} / Móvil: {{$empresa->movil}} 
    <br>
        {{$empresa->correo}}
    <br>
        {{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}} - {{$empresa->pais}}
</div>