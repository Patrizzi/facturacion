@php use App\Banco  @endphp
@php use App\BancoRegistro @endphp
@php $banco=Banco::where('estado',0)->get(); @endphp
<table style="border-collapse:separate; border-spacing:1em;margin:">
    <tr>
    @if(count($banco) != 4 )
        <td class="border-none"></td>
    @endif
    @foreach($banco as $bancos)
        <?php $banco_registros = BancoRegistro::where('banco_id', $bancos->id)->get() ?>
        <td class="td-head" align="center">
            <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 70%;"><br><br>
                <span class="lol">
                @foreach($banco_registros as $banco_reg)    
                    <span class="strong">{{$banco_reg->descripcion1}} :</span> {{$banco_reg->descripcion2}} <br>
                @endforeach
            </span>
        </td>
    @endforeach
    @if(count($banco) != 4 )
        <td class="border-none"></td>
    @endif
    </tr>


</table>


<style>
    /* PARA CENTRAR LOS DIVS PROVENIENTESAL BANCO */
     /* all */
     .td-head{
        width: 25%;
        height: auto;
        border: 1px #aaaaaa solid;
        border-radius: 8px;
        vertical-align: middle;
        padding-top: -1px;
        padding-bottom: -1px;
    }
    .strong{
        font-weight: bold;
        font-size: 13px;
    }
    .lol{
        font-size: 13px;
    }
    .border-none{
        border: none;
    }
</style>