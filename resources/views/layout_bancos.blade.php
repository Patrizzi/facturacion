@php use App\Banco @endphp
@php $banco=Banco::where('estado',0)->get(); @endphp
<div class="row flex" align="center">
    @foreach($banco as $bancos)
    <div class="col-sm-3 divs-cont">
        <p class="form-control" >
            <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 100px;height: 30px;">
            <br>
            N° S/. : {{$bancos->numero_soles}}
            <br>
            N° $ : {{$bancos->numero_dolares}}<br>
        </p>
    </div>
    @endforeach
</div>
