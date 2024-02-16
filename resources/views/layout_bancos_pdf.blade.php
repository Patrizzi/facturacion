@php 
    use App\Banco;
    use App\BancoRegistro ;
    $banco=Banco::where('estado',0)->get(); 
@endphp
<table style="border-collapse:separate; border-spacing:1em;margin:">
    <tr>
    @if(count($banco) != 4 )
        <td class="border-none"></td>
    @endif
    @foreach($banco as $bancos)
        <?php $banco_registros = BancoRegistro::where('banco_id', $bancos->id)->get() ?>
        <td class="td-head" align="center">
            <img  src="{{asset('img/logos/'.$bancos->foto)}}" style="width: 60%;"><br><br>
                <span class="lol">
                @foreach($banco_registros as $banco_reg)    
                    <span class="strong">{{$banco_reg->tipo_cuenta}} {{$banco_reg->monedas_i->simbolo}}:</span> {{$banco_reg->nombre_cuenta}} <br>
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
        /* font-size: 70%; */
    }
    .lol{
        font-size: 75%;
    }
    .border-none{
        border: none;
    }
</style>