<td style="width: 30%;border-color: white" rowspan="2" valign="top">
    <img align="" src="{{asset('img/logos/')}}/{{$empresa->foto}}" style="margin-top: 0px;" width="300px" />
    <br>
</td>
<td style="width: 40%;border-color: white;text-align: center;" rowspan="2" valign="top" >
   <strong>{{$empresa->razon_social}}</strong>
   <br>
   Telefono: {{$empresa->telefono}} / Móvil: {{$empresa->movil}}
   <br>
   {{$empresa->correo}}
   <br>
   {{$empresa->calle}} - {{$empresa->ciudad}} - {{$empresa->region_provincia}} - {{$empresa->pais}}
</td>