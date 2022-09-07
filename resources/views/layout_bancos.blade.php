@php use App\Banco  @endphp
@php use App\BancoRegistro @endphp
@php $banco=Banco::where('estado',0)->get(); @endphp
<div class="row flex" align="center">
    @foreach($banco as $bancos)
        <?php $banco_registros = BancoRegistro::where('banco_id', $bancos->id)->get() ?>
        <div class="col-sm-3 divs-cont" align="center">
            <p class="form-control" >
                <span class="inter-line">
                    <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 70%;"><br><br>
                    <span class="lol">
                    @foreach($banco_registros as $banco_reg)    
                        <strong>{{$banco_reg->descripcion1}} :</strong> {{$banco_reg->descripcion2}} <br>
                    @endforeach
                    </span>
                </span>
            </p>    
        </div>
    @endforeach
</div>
<style>
    .row{
        justify-content: center;
    }
    .divs-cont{
        display: flex ;
        justify-content: center;
        text-align: center;
        /* margin: auto; */
    }
    p.form-control{
        display: flex ;
        justify-content: center ;
        align-items: center ;
        border-color: #3D3D3D;
    }
    .lol{
        font-size: 12px;
    }
</style>
