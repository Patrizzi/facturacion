<?php
namespace App;

use Greenter\Model\Client\Client;
use Greenter\Model\Sale\Charge;

use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
use Greenter\Model\Despatch\Vehicle;
use Greenter\Model\Despatch\Driver;

use Greenter\Model\Sale\FormaPagos\FormaPagoContado;
use Greenter\Model\Sale\Invoice;
use Greenter\Model\Sale\SaleDetail;
use Greenter\Model\Sale\Legend;
use Greenter\Model\Response\BillResult;
use Greenter\Model\Sale\Cuota;
use Greenter\Model\Sale\FormaPagos\FormaPagoCredito;
use Greenter\Model\Sale\Document;
use Greenter\Model\Despatch\Despatch;
use Greenter\Model\Despatch\DespatchDetail;
use Greenter\Model\Despatch\Direction;
use Greenter\Model\Despatch\Shipment;
use Greenter\Model\Despatch\Transportist;
use Greenter\Model\Sale\Note;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;
use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Luecano\NumeroALetras\NumeroALetras;
use App\Empresa;
use App\Igv;
use App\Cuotas_Credito;
use App\Guia_remision;
use App\TransportePublico;
use PDO;
use App\config_acceso_sunat;

use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

// DATOS DE PRUEBA
// RUC: 20000000001
// Usuario: MODDATOS
// Contraseña: moddatos
//DATA DE CPE SUNAT DOC https://cpe.sunat.gob.pe/node/88

class Config_fe extends Model
{
    protected $table = 'config_fe';

    protected $guarded = [];

    public static function factura($factura,$facturas_registros,$guia,$facturacion_manual=0){

        if($facturacion_manual==1){
            // return "funciona";
        }

        //libro: https://cpe.sunat.gob.pe/sites/default/files/inline-files/guia%2Bxml%2Bfactura%2Bversion%202-1%2B1%2B0%20%282%29_0.pdf
        // return $guia;
        if($guia==1){
                $guia_ex = Guia_remision::where('cod_guia', $factura->guia_remision)->first();
                $guia_ex_m = GuiaRemisionManual::where('cod_guia', $factura->guia_remision)->first();
            if(isset($guia_ex) || isset($guia_ex_m)){
                $split_g = explode('-',$factura->guia_remision);
                $split_20 =  (int)$split_g[1];
                $new_cod_guia = $split_g[0].'-'.$split_20;


                $guiaRemision = (new Document())
                ->setTipoDoc('07') // Guia de Remision remitente: 09, catalogo 01
                ->setNroDoc($new_cod_guia); // Serie y correlativo de la guia de remision


            }else{
                $new_cod_guia = $factura->guia_remision;
                $guiaRemision = (new Document())
                ->setTipoDoc('09') // Guia de Remision remitente: 09, catalogo 01
                ->setNroDoc($new_cod_guia); // Serie y correlativo de la guia de remision
            }
            

        }

        $empresa=Empresa::first();
        $igv=Igv::first();

        // Cliente
        $client = (new Client())
        ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
        ->setNumDoc($factura->cliente->numero_documento) //ruc del receptor
        ->setRznSocial($factura->cliente->empresa); //nombre empresa

        // Emisor
        $address = (new Address())
        ->setUbigueo('150101')
        ->setDepartamento($empresa->region_provincia)
        ->setProvincia($empresa->region_provincia)
        ->setDistrito($empresa->ciudad)
        ->setUrbanizacion('-')
        ->setDireccion($empresa->calle)
        ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.
        
        $company = (new Company())
        ->setRuc($empresa->ruc)
        ->setRazonSocial($empresa->razon_social)
        ->setNombreComercial($empresa->nombre)
        ->setAddress($address);


        $igv_f=0;
        $gravada=0;
        $precio=0;


     foreach($facturas_registros as $cont => $factura_registro){
            if(isset($factura_registro->producto->codigo_producto)){
                $item_nombre = $factura_registro->producto->codigo_producto;
                $desc_nombre = $factura_registro->producto->nombre;
                $afec = $factura_registro->producto->tipo_afec_i_producto->codigo;
                $codigo_item = 'NIU';
            }else{
                $item_nombre = $factura_registro->servicio->codigo_servicio;
                $desc_nombre = $factura_registro->servicio->nombre;
                $afec = $factura_registro->servicio->tipo_afec_i_serv->codigo;
                $codigo_item = 'ZZ';
            }
            //gravada
            if( in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
                $item[$cont] = (new SaleDetail())
                ->setCodProducto($item_nombre)
                ->setUnidad($codigo_item)
                ->setCantidad($factura_registro->cantidad)
                ->setMtoValorUnitario($factura_registro->precio_unitario_comi)
                ->setDescripcion($desc_nombre)
                ->setMtoBaseIgv($factura_registro->precio_unitario_comi*$factura_registro->cantidad)
                ->setPorcentajeIgv($igv->igv_total)
                ->setIgv($factura_registro->precio_unitario_comi*$factura_registro->cantidad*(($igv->igv_total)/100))
                ->setTipAfeIgv($afec)
                ->setTotalImpuestos($factura_registro->precio_unitario_comi*$factura_registro->cantidad*(($igv->igv_total)/100))
                ->setMtoValorVenta($factura_registro->precio_unitario_comi*$factura_registro->cantidad)
                ->setMtoPrecioUnitario($factura_registro->precio_unitario_comi+($factura_registro->precio_unitario_comi*(($igv->igv_total)/100)))
                ;

                $igv_f=$factura_registro->precio_unitario_comi*$factura_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
                $precio=$factura_registro->precio_unitario_comi*$factura_registro->cantidad+$precio;
            }else{
                $item[$cont] = (new SaleDetail())
                ->setCodProducto($item_nombre)
                ->setUnidad($codigo_item)
                ->setCantidad($factura_registro->cantidad)
                ->setMtoValorUnitario($factura_registro->precio_unitario_comi)
                ->setDescripcion($desc_nombre)
                ->setMtoBaseIgv($factura_registro->precio_unitario_comi*$factura_registro->cantidad)
                ->setPorcentajeIgv(0)
                ->setIgv(0)
                ->setTipAfeIgv($afec)
                ->setTotalImpuestos($factura_registro->precio_unitario_comi*$factura_registro->cantidad*(($igv->igv_total)/100)) 
                ->setMtoValorVenta($factura_registro->precio_unitario_comi*$factura_registro->cantidad)
                ->setMtoPrecioUnitario($factura_registro->precio_unitario_comi+($factura_registro->precio_unitario_comi*(($igv->igv_total)/100)))
                ;
                $precio=$factura_registro->precio_unitario_comi*$factura_registro->cantidad+$precio;
            }
            
            //sumatorias
            if($factura_registro->precio_unitario_comi*$factura_registro->cantidad*(($igv->igv_total)/100)!=0){
                $gravada=$gravada+$factura_registro->precio_unitario_comi*$factura_registro->cantidad;
            }
        }
        $total=$igv_f+$precio;
        

        //codigo factura
        $codigo_factura=$factura->codigo_fac;
        $serie=explode("-",$codigo_factura);

        $correlativo=$serie[1];
        $serie=$serie[0];

        if($factura->forma_pago_id==1){
            // Venta - contado
            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            //->setFechaEmision(new DateTime('2020-08-24 13:05:00-05:00')) // Zona horaria: Lima
            ->setFechaEmision($factura->created_at)
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado

            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02

            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            if($guia==1){
                $guia_doc_r = Guia_remision::where('cod_guia', $factura->guia_remision)->first();
                $guia_doc_r_m = GuiaRemisionManual::where('cod_guia', $factura->guia_remision)->first();
                if(isset($guia_doc_r) || isset($guia_doc_r_m)){
                    $invoice->setRelDocs([
                        $guiaRemision // Incluir guia remision de FACTURA ELECTRONICA
                    ]);
                }else{
                    $invoice->setGuias([
                        $guiaRemision // Incluir guia remision.
                    ]);
                }
            }


            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);

            return $invoice;
        }else{
            // Venta - crédito
            if($facturacion_manual==0){
                $cuotas=Cuotas_Credito::where('facturacion_id',$factura->id)->get();
            }else{
                $cuotas=Cuotas_Credito::where('facturacion_m_id',$factura->id)->get();
            }
            

            foreach ($cuotas as $key => $cuota) {
                # code...
                $cuotas_credito[$key]=(new Cuota())
                ->setMonto($cuota->monto)
                ->setFechaPago(new DateTime($cuota->fecha_pago));
            }

            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision($factura->updated_at)
            ->setFormaPago(new FormaPagoCredito(round($total,2))) // FormaPago: credito
            ->setCuotas(
                $cuotas_credito
            )
            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            if($guia==1){
                $guia_doc_r = Guia_remision::where('cod_guia', $factura->guia_remision)->first();
                $guia_doc_r_m = GuiaRemisionManual::where('cod_guia', $factura->guia_remision)->first();
                if(isset($guia_doc_r) || isset($guia_doc_r_m)){
                    $invoice->setRelDocs([
                        $guiaRemision // Incluir guia remision de FACTURA ELECTRONICA
                    ]);
                }else{
                    $invoice->setGuias([
                        $guiaRemision // Incluir guia remision.
                    ]);
                }
            }


            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);
            return $invoice;
        }
    }

    public static function factura_servicio($factura,$facturas_registros,$guia){

        $empresa=Empresa::first();
        $igv=Igv::first();
        // Cliente
        $client = (new Client())
        ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
        ->setNumDoc($factura->cliente->numero_documento) //ruc del receptor
        ->setRznSocial($factura->cliente->empresa); //nombre empresa

        // Emisor
        $address = (new Address())
        ->setUbigueo('150101')
        ->setDepartamento($empresa->region_provincia)
        ->setProvincia($empresa->region_provincia)
        ->setDistrito($empresa->ciudad)
        ->setUrbanizacion('-')
        ->setDireccion($empresa->calle)
        ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
        ->setRuc($empresa->ruc)
        ->setRazonSocial($empresa->razon_social)
        ->setNombreComercial($empresa->nombre)
        ->setAddress($address);


        $igv_f=0;
        $gravada=0;
        $precio=0;


        foreach($facturas_registros as $cont => $factura_registro){
            //grabada
            if( in_array($factura_registro->servicio->tipo_afec_i_serv->codigo, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
                $item[$cont] = (new SaleDetail())
                ->setCodProducto($factura_registro->servicio->codigo_servicio)//codigo del producto
                ->setUnidad('ZZ') // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
                ->setCantidad($factura_registro->cantidad)
                ->setMtoValorUnitario($factura_registro->precio)
                ->setDescripcion($factura_registro->servicio->nombre)
                ->setMtoBaseIgv($factura_registro->precio*$factura_registro->cantidad)
                ->setPorcentajeIgv($igv->igv_total) // 18%
                ->setIgv($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100))
                ->setTipAfeIgv($factura_registro->servicio->tipo_afec_i_serv->codigo) 
                ->setTotalImpuestos($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
                ->setMtoValorVenta($factura_registro->precio*$factura_registro->cantidad)
                ->setMtoPrecioUnitario($factura_registro->precio+($factura_registro->precio*(($igv->igv_total)/100)))
                ;
                //sumatorias
                $igv_f=$factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
                $precio=$factura_registro->precio*$factura_registro->cantidad+$precio;
            }else{
                $item[$cont] = (new SaleDetail())
                ->setCodProducto($factura_registro->servicio->codigo_servicio)//codigo del producto
                ->setUnidad('ZZ') // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
                ->setCantidad($factura_registro->cantidad)
                ->setMtoValorUnitario($factura_registro->precio)
                ->setDescripcion($factura_registro->servicio->nombre)
                ->setMtoBaseIgv($factura_registro->precio*$factura_registro->cantidad)
                ->setPorcentajeIgv(0) // 18%
                ->setIgv(0)
                ->setTipAfeIgv($factura_registro->servicio->tipo_afec_i_serv->codigo) 
                ->setTotalImpuestos($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
                ->setMtoValorVenta($factura_registro->precio*$factura_registro->cantidad)
                ->setMtoPrecioUnitario($factura_registro->precio+($factura_registro->precio*(($igv->igv_total)/100)))
                ;
                //sumatorias
                $precio=$factura_registro->precio*$factura_registro->cantidad+$precio;
            }
            
            if($factura_registro->precio*$factura_registro->cantidad*(($igv->igv_total)/100)!=0){
                $gravada=$gravada+$factura_registro->precio*$factura_registro->cantidad;
            }
        }
        $total=$igv_f+$precio;
        // return $gravada;

        //codigo factura
        $codigo_factura=$factura->codigo_fac;
        $serie=explode("-",$codigo_factura);

        $correlativo=$serie[1];
        $serie=$serie[0];

        if($factura->forma_pago_id==1){
            // Venta - contado
            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision($factura->created_at)
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado

            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02

            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;


            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);

            return $invoice;
        }else{
            // Venta - credito
            $cuotas=Cuotas_Credito::where('facturacion_id',$factura->id)->get();

            foreach ($cuotas as $key => $cuota) {
                # code...
                $cuotas_credito[$key]=(new Cuota())
                ->setMonto($cuota->monto)
                ->setFechaPago(new DateTime('+7days'));
            }

            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('01') // Factura - Catalog. 01  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision($factura->created_at)
            ->setFormaPago(new FormaPagoCredito()) // FormaPago: credito
            ->setCuotas(
                $cuotas_credito
            )
            ->setTipoMoneda($factura->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($factura->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            ->setMtoOperInafectas($factura->op_inafecta)
            ->setMtoOperExoneradas($factura->op_exonerada)
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);

            return $invoice;
        }

    }

    public static function boleta($boleta,$boletas_registros){
        
        $empresa=Empresa::first();
        $igv=Igv::first();

        if(strtolower($boleta->cliente->documento_identificacion) == "Dni" ){
            $tipo_doc = '01';
            $razon_social = $boleta->cliente->nombre;
        }else{
            $tipo_doc = '07';
            $razon_social = $boleta->cliente->empresa;
        }
        // Cliente
        $client = (new Client())
        ->setTipoDoc('01')   //pagina 42 del pdf sunat 2.1
        ->setNumDoc($tipo_doc) //ruc del receptor
        ->setRznSocial($razon_social); //nombre empresa

        // Emisor
        $address = new Address();
        $address->setUbigueo('150101')
        ->setDepartamento($empresa->region_provincia)
        ->setProvincia($empresa->region_provincia)
        ->setDistrito($empresa->ciudad)
        ->setUrbanizacion('-')
        ->setDireccion($empresa->calle);

        $company = (new Company())
        ->setRuc($empresa->ruc)
        ->setRazonSocial($empresa->razon_social)
        ->setNombreComercial($empresa->nombre)
        ->setAddress($address);

        $igv_f=0;
        $gravada=0;
        $precio=0;


        $igv_f=0;
        $gravada=0;
        $precio=0;

        foreach($boletas_registros as $cont => $boleta_registro){
            $sin_igv = ($boleta_registro->precio_unitario_comi - ($boleta_registro->precio*($igv->igv_total/100)));
            // return $sin_igv;
                if(isset($boleta_registro->producto->codigo_producto)){
                    $item_nombre = $boleta_registro->producto->codigo_producto;
                    $desc_nombre = $boleta_registro->producto->nombre;
                    $afec = $boleta_registro->producto->tipo_afec_i_producto->codigo;
                    $codigo_item = 'NIU';
                }else{
                    $item_nombre = $boleta_registro->servicio->codigo_servicio;
                    $desc_nombre = $boleta_registro->servicio->nombre;
                    $afec = $boleta_registro->servicio->tipo_afec_i_serv->codigo;
                    $codigo_item = 'ZZ';
                }
                if(in_array($afec, array("10","11","12","13","14","15","16","17"))){
                    $item[$cont] = (new SaleDetail())
                        ->setCodProducto($item_nombre)//codigo del producto
                        ->setUnidad($codigo_item) // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
                        ->setCantidad($boleta_registro->cantidad)
                        ->setMtoValorUnitario($boleta_registro->precio_unitario_comi)
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad)
                        ->setPorcentajeIgv($igv->igv_total) // 18%
                        ->setIgv($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad*(($igv->igv_total)/100))
                        ->setTipAfeIgv($afec) // Gravado Op. Onerosa - Catalog. 07
                        ->setTotalImpuestos($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
                        ->setMtoValorVenta($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad)
                        ->setMtoPrecioUnitario($boleta_registro->precio_unitario_comi+($boleta_registro->precio_unitario_comi*(($igv->igv_total)/100)))
                        ;
                        $igv_f=$boleta_registro->precio_unitario_comi*$boleta_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
                        $precio=$boleta_registro->precio_unitario_comi*$boleta_registro->cantidad+$precio;
                }else{
                    $item[$cont] = (new SaleDetail())
                        ->setCodProducto($item_nombre)//codigo del producto
                        ->setUnidad($codigo_item) // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
                        ->setCantidad($boleta_registro->cantidad)
                        ->setMtoValorUnitario($boleta_registro->precio_unitario_comi)
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad)
                        ->setPorcentajeIgv(0) // 18%
                        ->setIgv(0)
                        ->setTipAfeIgv($afec) // Gravado Op. Onerosa - Catalog. 07
                        ->setTotalImpuestos($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
                        ->setMtoValorVenta($boleta_registro->precio_unitario_comi*$boleta_registro->cantidad)
                        ->setMtoPrecioUnitario($boleta_registro->precio_unitario_comi+($boleta_registro->precio_unitario_comi*(($igv->igv_total)/100)))
                        ;
                        $precio=$boleta_registro->precio_unitario_comi*$boleta_registro->cantidad+$precio;
                }
                //gravada
                // if(in_array($afec, array("10","11","12","13","14","15","16","17"))){
                    // $item[$cont] = (new SaleDetail())
                    // ->setCodProducto($item_nombre)//codigo del producto
                    // ->setUnidad($codigo_item) // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
                    // ->setCantidad($boleta_registro->cantidad)
                    // ->setMtoValorUnitario($sin_igv)
                    // ->setDescripcion($desc_nombre)
                    // ->setMtoBaseIgv($sin_igv*$boleta_registro->cantidad)
                    // ->setPorcentajeIgv($igv->igv_total) // 18%
                    // ->setIgv($sin_igv*$boleta_registro->cantidad*(($igv->igv_total)/100))
                    // ->setTipAfeIgv($afec) // Gravado Op. Onerosa - Catalog. 07
                    // ->setTotalImpuestos($sin_igv*$boleta_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
                    // ->setMtoValorVenta($sin_igv*$boleta_registro->cantidad)
                    // ->setMtoPrecioUnitario($boleta_registro->precio_unitario_comi)
                    // ;
                    // $igv_f=$sin_igv*$boleta_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
                    // $precio=($sin_igv*$boleta_registro->cantidad)+$precio;
                // }else{
                //     $item[$cont] = (new SaleDetail())
                //     ->setCodProducto($item_nombre)//codigo del producto
                //     ->setUnidad($codigo_item) // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
                //     ->setCantidad($boleta_registro->cantidad)
                //     ->setMtoValorUnitario($boleta_registro->precio)
                //     ->setDescripcion($desc_nombre)
                //     ->setMtoBaseIgv($boleta_registro->precio*$boleta_registro->cantidad)
                //     ->setPorcentajeIgv($igv->igv_total) // 18%
                //     ->setIgv($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100))
                //     ->setTipAfeIgv($afec) // Gravado Op. Onerosa - Catalog. 07
                //     ->setTotalImpuestos($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
                //     ->setMtoValorVenta($boleta_registro->precio*$boleta_registro->cantidad)
                //     ->setMtoPrecioUnitario($boleta_registro->precio+($boleta_registro->precio*(($igv->igv_total)/100)))
                //     ;
                //     $precio=$boleta_registro->precio*$boleta_registro->cantidad+$precio;
                // }
            
            //sumatorias
            
            if($sin_igv*$boleta_registro->cantidad*(($igv->igv_total)/100)!=0){
                $gravada=$gravada+($sin_igv*$boleta_registro->cantidad);
            }

        }

        $total=$igv_f+$precio;
        
        // return $gravada;

        //codigo factura
        $codigo_boleta=$boleta->codigo_boleta;
        $serie=explode("-",$codigo_boleta);

        $correlativo=$serie[1];
        $serie=$serie[0];

        if($boleta->forma_pago_id==1){
            //contado
            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('03') // boleta - Catalog. 03  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision($boleta->created_at)
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado

            ->setTipoMoneda($boleta->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($boleta->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);

            return $invoice;
        }else{
            //credito
            $cuotas=Cuotas_Credito::where('boleta_id',$boleta->id)->get();

            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('03') // boleta - Catalog. 03  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision($boleta->created_at)
            ->setFormaPago(new FormaPagoCredito()) // FormaPago: credito
            ->setCuotas([
                // $cuotas_credito
                (new Cuota()) //->                   meterlo en un foreach exlusivo de array
                ->setMonto(59)
                ->setFechaPago(new DateTime('+7days'))
            ])
            ->setTipoMoneda($boleta->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($boleta->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);

            return $invoice;
        }
    }

    public static function boleta_servicio($boleta,$boletas_registros){
        $empresa=Empresa::first();
        $igv=Igv::first();

        // Cliente
        $client = (new Client())
        ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
        ->setNumDoc($boleta->cliente->numero_documento) //ruc del receptor
        ->setRznSocial($boleta->cliente->empresa); //nombre empresa

        // Emisor
        $address = new Address();
        $address->setUbigueo('150101')
        ->setDepartamento($empresa->region_provincia)
        ->setProvincia($empresa->region_provincia)
        ->setDistrito($empresa->ciudad)
        ->setUrbanizacion('-')
        ->setDireccion($empresa->calle);

        $company = (new Company())
        ->setRuc($empresa->ruc)
        ->setRazonSocial($empresa->razon_social)
        ->setNombreComercial($empresa->nombre)
        ->setAddress($address);

        $igv_f=0;
        $gravada=0;
        $precio=0;

        foreach($boletas_registros as $cont => $boleta_registro){
            $item[$cont] = (new SaleDetail())
            ->setCodProducto($boleta_registro->servicio->codigo_producto)//codigo del producto
            ->setUnidad('ZZ') // Unidad - Catalog. 03 -> expecificacion de la unidad de medida
            ->setCantidad($boleta_registro->cantidad)
            ->setMtoValorUnitario($boleta_registro->precio)
            ->setDescripcion($boleta_registro->servicio->nombre)
            ->setMtoBaseIgv($boleta_registro->precio*$boleta_registro->cantidad)
            ->setPorcentajeIgv($igv->igv_total) // 18%
            ->setIgv($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100))
            ->setTipAfeIgv('10') // Gravado Op. Onerosa - Catalog. 07
            ->setTotalImpuestos($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100)) // Suma de impuestos en el detalle
            ->setMtoValorVenta($boleta_registro->precio*$boleta_registro->cantidad)
            ->setMtoPrecioUnitario($boleta_registro->precio+($boleta_registro->precio*(($igv->igv_total)/100)))
            ;
            //sumatorias
            $igv_f=$boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100)+$igv_f;
            $precio=$boleta_registro->precio*$boleta_registro->cantidad+$precio;
            if($boleta_registro->precio*$boleta_registro->cantidad*(($igv->igv_total)/100)!=0){
                $gravada=$gravada+$boleta_registro->precio*$boleta_registro->cantidad;
            }
        }
        $total=$igv_f+$precio;
        // return $gravada;

        //codigo factura
        $codigo_boleta=$boleta->codigo_boleta;
        $serie=explode("-",$codigo_boleta);

        $correlativo=$serie[1];
        $serie=$serie[0];

        if($boleta->forma_pago_id==1){
            //contado
            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('03') // boleta - Catalog. 03  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision($boleta->created_at)
            ->setFormaPago(new FormaPagoContado()) // FormaPago: Contado

            ->setTipoMoneda($boleta->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);

            return $invoice;
        }else{
            //credito
            $cuotas=Cuotas_Credito::where('boleta_id',$boleta->id)->get();

            $invoice = (new Invoice())
            ->setUblVersion('2.1')
            ->setTipoOperacion('0101') // Venta - Catalog. 51 // pagina 51 del pdf sunat 2.1
            ->setTipoDoc('03') // boleta - Catalog. 03  // pagina 33 del pdf sunat 2.1
            ->setSerie($serie)// numero de serie
            ->setCorrelativo($correlativo) // y numero correlativo  // ejemplo en seccion 2.2 pagina 20 del pdf sunat 2.1 infomracion precisa pagina 30 pdf sunat 2.1
            ->setFechaEmision($boleta->created_at)
            ->setFormaPago(new FormaPagoCredito()) // FormaPago: credito
            ->setCuotas([
                // $cuotas_credito
                (new Cuota()) //->                   meterlo en un foreach exlusivo de array
                ->setMonto(59)
                ->setFechaPago(new DateTime('+7days'))
            ])
            ->setTipoMoneda($boleta->moneda->codigo) // Sol - Catalog. 02
            ->setCompany($company)
            ->setClient($client)
            //--------------------------estados de obtencion
            ->setMtoOperGravadas($boleta->op_gravada) //Este elemento es usado solo si al menos una línea de ítem está gravada con el IGV.
            //--------------------------
            //Contiene a la sumatoria de los valores de venta gravados por ítem - // pagina 45 del pdf sunat 2.1
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setValorVenta($precio)
            ->setSubTotal($total)
            ->setMtoImpVenta($total)
            ;

            $formatter = new NumeroALetras();
            $valor=$formatter->toInvoice($total, 2, 'soles');

            $legend = (new Legend())
            ->setCode('1000') // Monto en letras - Catalog. 52 // pagina 33 pdf sunat
            ->setValue($valor);

            $invoice->setDetails($item)
            ->setLegends([$legend]);

            return $invoice;
        }
    }

    public static function guia_remision($guia, $guias_registros,$tipo_transporte){

        if(isset($guia->sucursal_cliente)){
            $cli_postal = $guia->cod_postal_cliente;
            $cli_direc = $guia->sucursal_cliente;
        }else{
            $cli_postal = $guia->cliente->cod_postal;
            $cli_direc = $guia->cliente->direccion;
        }
        

        //$util = Util::getInstance();
        $empresa=Empresa::first();
        $motivo_tr = MotivoTraslado::mot_tras($guia->motivo_traslado);

        // //* Emisor beta
        // $company = (new Company())
        // ->setRuc('20161515648')
        // ->setRazonSocial('GREENTER S.A.C.');
        //* Emisor produccion
        $company = (new Company())
        ->setRuc($empresa->ruc)
        ->setRazonSocial($empresa->razon_social);

        
        //obtencion del peso total
        $peso_total=0;
        foreach($guias_registros as $guia_electronica){
            $peso_total=$peso_total + ($guia_electronica->peso * $guia_electronica->cantidad);
        }
        

        if($tipo_transporte==2){ //privado

            // TIPO DE VEHICULO  - 1M Y L 
            $vehiculo = Vehiculo::where('id', $guia->vehiculo_id)->first();
            if($vehiculo->tipo_vehiculo == "M1" || $vehiculo->tipo_vehiculo == "L"){
                $envio = new Shipment();
                $envio
                    ->setCodTraslado($motivo_tr) // Cat.20
                    ->setIndicadores(['SUNAT_Envio_IndicadorTrasladoVehiculoM1L'])
                    ->setModTraslado('02') // Cat.18 // PUBLICO O PRIVADO
                    ->setFecTraslado(new DateTime())
                    ->setPesoTotal($peso_total)
                    ->setUndPesoTotal('KGM')    //unidad de medida
                    ->setLlegada(new Direction($cli_postal, $cli_direc))   //arreglar el ubigeo de llegada  salida
                    ->setPartida(new Direction($guia->almacen->cod_postal, $guia->almacen->direccion));    //arreglar el ubigeo de llegada  salida    
            }else{
                //solo vehiculo privado 
                $vehiculoPrincipal = (new Vehicle())
                ->setPlaca($guia->vehiculo->placa);

                //CONDUCTOR DE PERSONAL - TABLA DE VEHICULO CON PERSONAL Y INPUT LICENCIA
                $chofer = (new Driver())
                    ->setTipo('Principal')
                    ->setTipoDoc('1')
                    ->setNroDoc($guia->personal->numero_documento) // 1 = dni // 7 = [pasaporte
                    ->setLicencia($guia->personal->licencia)
                    ->setNombres($guia->personal->nombres)
                    ->setApellidos($guia->personal->apellidos);

                $envio = new Shipment();
                $envio
                    ->setCodTraslado($motivo_tr) // Cat.20
                    ->setModTraslado('02') // Cat.18 // PUBLICO O PRIVADO
                    ->setFecTraslado(new DateTime())
                    ->setPesoTotal($peso_total)
                    ->setUndPesoTotal('KGM')    //unidad de medida
                ->setVehiculo($vehiculoPrincipal)
                ->setChoferes([$chofer])
                ->setLlegada(new Direction($cli_postal, $cli_direc))   //arreglar el ubigeo de llegada  salida
                ->setPartida(new Direction($guia->almacen->cod_postal, $guia->almacen->direccion));    //arreglar el ubigeo de llegada  salida
            }

        }else{ //* PUBLICO 

            $trans_publico = TransportePublico::where('id', $guia->vehiculo_publico)->first();
            $transp = new Transportist();
            $transp->setTipoDoc('6')
                ->setNumDoc($trans_publico->ruc)
                ->setRznSocial($trans_publico->nombre)
                ->setNroMtc($trans_publico->numero_mtc);

            $envio = new Shipment();
            $envio
                ->setCodTraslado($motivo_tr) // Cat.20
                ->setModTraslado('01') // Cat.18 // PUBLICO O PRIVADO
                ->setFecTraslado(new DateTime())
                ->setFecTraslado(new DateTime())
                ->setPesoTotal($peso_total)
                ->setUndPesoTotal('KGM')    //unidad de medida
                ->setLlegada(new Direction($cli_postal, $cli_direc))    //arreglar el ubigeo de llegada  salida
                ->setPartida(new Direction($guia->almacen->cod_postal, $guia->almacen->direccion))    //arreglar el ubigeo de llegada  salida
                ->setTransportista($transp);
        }

        //codigo correlativo
        $codigo_guia=$guia->cod_guia;
        $serie=explode("-",$codigo_guia);

        $correlativo=$serie[1];
        $serie_g=$serie[0];

        if ($guia->cliente->documento_identificacion == 'RUC') {
            $tipo_doc_cli = 6;
        }else if( $guia->cliente->documento_identificacion == 'DNI' ) {
            $tipo_doc_cli = 1;
        }else{
            $tipo_doc_cli = 7;
        }
        
        $despatch = new Despatch();
        $despatch->setVersion('2022')
        ->setTipoDoc('09')
        ->setSerie($serie_g)      //cambiar codigo de guia
        ->setCorrelativo($correlativo)
        ->setFechaEmision($guia->created_at)
        ->setCompany($company)
        ->setDestinatario((new Client())
            ->setTipoDoc($tipo_doc_cli)
            ->setNumDoc($guia->cliente->numero_documento)
            ->setRznSocial($guia->cliente->empresa))
        ->setEnvio($envio);

        foreach($guias_registros as $cont => $guia_registro){
        $detail[$cont] = new DespatchDetail();
        $detail[$cont]->setCantidad($guia_registro->cantidad)
            ->setUnidad('ZZ')
            ->setDescripcion($guia_registro->producto->nombre)
            ->setCodigo($guia_registro->producto->codigo_producto);
        }

        $despatch->setDetails($detail);

        return $despatch;



    }
    public static function guia_remision_baja($guia, $guias_registros,$tipo_transporte){

        if(isset($guia->sucursal_cliente)){
            $cli_postal = $guia->cod_postal_cliente;
            $cli_direc = $guia->sucursal_cliente;
        }else{
            $cli_postal = $guia->cliente->cod_postal;
            $cli_direc = $guia->cliente->direccion;
        }
        $baja = new Document();
        $baja->setTipoDoc('09')
            ->setNroDoc($guia->cod_guia);

        $empresa=Empresa::first();

        // Emisor
        $address = (new Address())
            ->setUbigueo('150101')
            ->setDepartamento($empresa->region_provincia)
            ->setProvincia($empresa->region_provincia)
            ->setDistrito($empresa->ciudad)
            ->setUrbanizacion('-')
            ->setDireccion($empresa->calle)
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
            ->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->razon_social)
            ->setNombreComercial($empresa->nombre)
            ->setAddress($address);

        if($tipo_transporte==1){ //TRASNPORTE PUBLICO
            $vehiculo_trasporte=TransportePublico::where('id',$guia->vehiculo_publico)->first();
            $transp = new Transportist();
            $transp->setTipoDoc('6')
                ->setNumDoc($vehiculo_trasporte->ruc)          //falta documentacion del conductor
                ->setRznSocial($vehiculo_trasporte->nombre); //nombre de la conduccion

        }elseif($tipo_transporte==2){   //TRASPORTE PRIVADO
            $empleado=Personal::where('id',$guia->conductor_id)->first();
            $transp = new Transportist();
            $transp->setTipoDoc('6')
                ->setNumDoc($empresa->ruc)          //falta documentacion del conductor
                ->setRznSocial($empresa->razon_social) //nombre de la conduccion
                ->setPlaca($guia->vehiculo->placa)
                ->setChoferTipoDoc('1')     //ayuda
                ->setChoferDoc($empleado->numero_documento);         //doc chofer
        }


        //obtencion del peso total
        $peso_total=0;
        foreach($guias_registros as $guia_electronica){
            $peso_total=$peso_total + $guia_electronica->peso;
        }

        if($tipo_transporte==0){
            $envio = new Shipment();
            $envio
                ->setCodTraslado('01') // Cat.20
                ->setDesTraslado('VENTA')
                ->setModTraslado('01') // Cat.18
                ->setFecTraslado(new DateTime())
                // ->setCodPuerto('123')
                ->setIndTransbordo(false)
                ->setPesoTotal($peso_total)
                ->setUndPesoTotal('KGM')    //unidad de medida
                // ->setNumContenedor('XD-2232')
                ->setLlegada(new Direction($cli_postal, $cli_direc))   //arreglar el ubigeo de llegada  salida
                ->setPartida(new Direction($guia->almacen->cod_postal, $guia->almacen->direccion));    //arreglar el ubigeo de llegada  salida
        }else{
            $envio = new Shipment();
            $envio
                ->setCodTraslado('01') // Cat.20
                ->setDesTraslado('VENTA')
                ->setModTraslado('01') // Cat.18
                ->setFecTraslado(new DateTime())
                // ->setCodPuerto('123')
                ->setIndTransbordo(false)
                ->setPesoTotal($peso_total)
                ->setUndPesoTotal('KGM')    //unidad de medida
                // ->setNumContenedor('XD-2232')
                ->setLlegada(new Direction($cli_postal, $cli_direc))    //arreglar el ubigeo de llegada  salida
                ->setPartida(new Direction($guia->almacen->cod_postal, $guia->almacen->direccion))    //arreglar el ubigeo de llegada  salida
                ->setTransportista($transp);
        }

        //codigo correlaativo
        $codigo_guia=$guia->cod_guia;
        $serie=explode("-",$codigo_guia);

        $correlativo=$serie[1];
        $serie_g=$serie[0];

        $despatch = new Despatch();
        $despatch->setTipoDoc('09')
            ->setSerie($serie_g)      //cambiar codigo de guia
            ->setCorrelativo($correlativo)
            ->setFechaEmision(new DateTime())
            ->setCompany($company)
            ->setDestinatario((new Client())
                ->setTipoDoc('6')
                ->setNumDoc($guia->cliente->numero_documento)
                ->setRznSocial($guia->cliente->empresa))
            ->setObservacion($guia->observacion)
            ->setDocBaja($baja)
            ->setEnvio($envio);

        foreach($guias_registros as $cont => $guia_registro){
            $detail[$cont] = new DespatchDetail();
            $detail[$cont]->setCantidad(2)
            ->setUnidad('ZZ')
            ->setDescripcion($guia_registro->producto->nombre)
            ->setCodigo($guia_registro->producto->codigo_producto)
            ->setCodProdSunat($guia_registro->producto->codigo_producto);
        }

        $despatch->setDetails($detail);

        return $despatch;
    }

    //NOTA DE CREDITO - FACTURA

    public static function nota_credito($factura, $factura_registro, $cantidad,$precio_credito,$notas_creditos_count,$nota_credito_code,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emision,$des_mot){
        // return $precio[0];
        $empresa=Empresa::first();
        $igv=Igv::first();

        // Cliente
        $client = (new Client())
            ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
            ->setNumDoc($factura->cliente->numero_documento) //ruc del receptor
            ->setRznSocial($factura->cliente->empresa); //nombre empresa

        // Emisor
        $address = (new Address())
            ->setUbigueo('150101')
            ->setDepartamento($empresa->region_provincia)
            ->setProvincia($empresa->region_provincia)
            ->setDistrito($empresa->ciudad)
            ->setUrbanizacion('-')
            ->setDireccion($empresa->calle)
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
            ->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->razon_social)
            ->setNombreComercial($empresa->nombre)
            ->setAddress($address);

        $contador=count($factura_registro);
            
        $cont=0;
        $igv_f=0;
        $precio=0;
        $op_g=0;

        // return $request;
        // return $contador;

        for($p=0;$p<$contador;$p++){
            $string=(string)$p;
            
            // $cantidad="input_cantidad_".$string;
            $input_precio="input_precio_".$string;
            $descripcion="input_descripcion_".$string;

            if(isset($factura_registro[$p]->producto->codigo_producto)){
                $item_nombre = $factura_registro[$p]->producto->codigo_producto;
                $desc_nombre = $factura_registro[$p]->producto->nombre;
                $afec = $factura_registro[$p]->producto->tipo_afec_i_producto->codigo;
                $codigo_item = 'NIU';
            }else{
                $item_nombre = $factura_registro[$p]->servicio->codigo_servicio;
                $desc_nombre = $factura_registro[$p]->servicio->nombre;
                $afec = $factura_registro[$p]->servicio->tipo_afec_i_serv->codigo;
                $codigo_item = 'ZZ';
            }

            if($cantidad[$p]==NULL){
            }else{
                if( in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
                    $item[$cont]=new SaleDetail();
                    $item[$cont]
                        ->setCodProducto($item_nombre)
                        ->setUnidad($codigo_item)
                        ->setCantidad($cantidad[$p])
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($precio_credito[$p]*$cantidad[$p])
                        ->setPorcentajeIgv($igv->igv_total)
                        ->setIgv($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
                        ->setTipAfeIgv($afec)
                        ->setTotalImpuestos($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
                        ->setMtoValorVenta($precio_credito[$p]*$cantidad[$p])
                        ->setMtoValorUnitario($precio_credito[$p])
                        ->setMtoPrecioUnitario($precio_credito[$p]+($precio_credito[$p]*(($igv->igv_total)/100)));

                    $igv_f=$precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100)+$igv_f;
                    $precio=$precio_credito[$p]*$cantidad[$p]+$precio;

                    $cont++;
                }else{
                    $item[$cont]=new SaleDetail();
                    // return $precio_credito[$p];
                    $item[$cont]
                        ->setCodProducto($item_nombre)
                        ->setUnidad($codigo_item)
                        ->setCantidad($cantidad[$p])
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($precio_credito[$p]*$cantidad[$p])
                        ->setPorcentajeIgv(0)
                        ->setIgv(0)
                        ->setTipAfeIgv($afec)
                        ->setTotalImpuestos($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
                        ->setMtoValorVenta($precio_credito[$p]*$cantidad[$p])
                        ->setMtoValorUnitario($precio_credito[$p])
                        ->setMtoPrecioUnitario($precio_credito[$p]+($precio_credito[$p]*(($igv->igv_total)/100)));

                    $precio=$precio_credito[$p]*$cantidad[$p]+$precio;

                    $cont++;
                }

                
            }
        }


        $total=$igv_f+$precio;

        //CODIGO NOTA
        $codigo_nota=$nota_credito_code;
        $serie=explode("-",$codigo_nota);

        $correlativo=$serie[1];
        $serie=$serie[0];
        // $serie;
        // $date = date_create($fecha_emision);
        // $fecha_conv = date_format($date, 'yyyy-MM-dd HH:mm:ss');
        // return $fecha_conv;

        $note = new Note();
        $note->setUblVersion('2.1')
            ->setTipoDoc('07')
            ->setSerie($serie)
            ->setCorrelativo($correlativo)
            ->setFechaEmision($fecha_emision)
            ->setTipDocAfectado('01') // Tipo Doc: Factura
            ->setNumDocfectado($factura->codigo_fac) // Factura: Serie-Correlativo
            ->setCodMotivo($motivo) // Catalogo. 09
            ->setDesMotivo($des_mot)
            ->setTipoMoneda($factura->moneda->codigo)
            ->setCompany($company)
            ->setClient($client)
            ->setMtoOperGravadas($gravada) 
            ->setMtoOperInafectas($inafecta)
            ->setMtoOperExoneradas($exonerada)
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setMtoImpVenta($total);

        $formatter = new NumeroALetras();
        $valor=$formatter->toInvoice($total, 2, 'soles');
        
        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue($valor);
            
        $note->setDetails($item)
        ->setLegends([$legend]);
    
        
        return $note;
    }

    // public static function nota_credito_servicio($factura, $factura_registro, $cantidad,$precio_credito,$notas_creditos_count,$nota_credito_code,$gravada,$exonerada,$inafecta,$motivo,$fecha_emision){

    //     $empresa=Empresa::first();
    //     $igv=Igv::first();

    //     // Cliente
    //     $client = (new Client())
    //         ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
    //         ->setNumDoc($factura->cliente->numero_documento) //ruc del receptor
    //         ->setRznSocial($factura->cliente->empresa); //nombre empresa

    //     // Emisor
    //     $address = (new Address())
    //         ->setUbigueo('150101')
    //         ->setDepartamento($empresa->region_provincia)
    //         ->setProvincia($empresa->region_provincia)
    //         ->setDistrito($empresa->ciudad)
    //         ->setUrbanizacion('-')
    //         ->setDireccion($empresa->calle)
    //         ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

    //     $company = (new Company())
    //         ->setRuc($empresa->ruc)
    //         ->setRazonSocial($empresa->razon_social)
    //         ->setNombreComercial($empresa->nombre)
    //         ->setAddress($address);

    //     $contador=count($factura_registro);
            
    //     $cont=0;
    //     $igv_f=0;
    //     $precio=0;
    //     $op_g=0;

        
    //     for($p=0;$p<$contador;$p++){
    //         $string=(string)$p;
            
    //         $nombre="input_disabled_".$string;
            
    //         if($cantidad[$p]==NULL){
    //         }else{


    //             if( in_array($factura_registro[$p]->servicio->tipo_afec_i_serv->codigo, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($factura_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($cantidad[$p])
    //                 ->setDescripcion($factura_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($precio_credito[$p]*$cantidad[$p])
    //                 ->setPorcentajeIgv($igv->igv_total)
    //                 ->setIgv($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
    //                 ->setTipAfeIgv($factura_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($precio_credito[$p]*$cantidad[$p])
    //                 ->setMtoValorUnitario($precio_credito[$p])
    //                 ->setMtoPrecioUnitario($precio_credito[$p]+($precio_credito[$p]*(($igv->igv_total)/100)));

    //                 $igv_f=$precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100)+$igv_f;
    //                 $precio=$precio_credito[$p]*$cantidad[$p]+$precio;

    //                 $cont++;
    //             }else{
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($factura_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($cantidad[$p])
    //                 ->setDescripcion($factura_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($precio_credito[$p]*$cantidad[$p])
    //                 ->setPorcentajeIgv(0)
    //                 ->setIgv(0)
    //                 ->setTipAfeIgv($factura_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($precio_credito[$p]*$cantidad[$p])
    //                 ->setMtoValorUnitario($precio_credito[$p])
    //                 ->setMtoPrecioUnitario($precio_credito[$p]+($precio_credito[$p]*(($igv->igv_total)/100)));

    //                 $precio=$precio_credito[$p]*$cantidad[$p]+$precio;

    //                 $cont++;
    //             }


                
    //         }
    //     }

    //     $total=$igv_f+$precio;

    //     //CODIGO NOTA
    //     $codigo_nota=$nota_credito_code;
    //     $serie=explode("-",$codigo_nota);

    //     $correlativo=$serie[1];
    //     $serie=$serie[0];

    //     $note = new Note();
    //     $note
    //         ->setUblVersion('2.1')
    //         ->setTipoDoc('07')
    //         ->setSerie($serie)
    //         ->setCorrelativo($correlativo)
    //         ->setFechaEmision($fecha_emision)
    //         ->setTipDocAfectado('01') // Tipo Doc: Factura
    //         ->setNumDocfectado($factura->codigo_fac) // Factura: Serie-Correlativo
    //         ->setCodMotivo('07') // Catalogo. 09
    //         ->setDesMotivo($motivo)
    //         ->setTipoMoneda($factura->moneda->codigo)
    //         ->setCompany($company)
    //         ->setClient($client)
    //         ->setMtoOperGravadas($gravada) 
    //         ->setMtoOperInafectas($inafecta)
    //         ->setMtoOperExoneradas($exonerada)
    //         ->setMtoIGV($igv_f)
    //         ->setTotalImpuestos($igv_f)
    //         ->setMtoImpVenta($total)
    //         ;

    //     $formatter = new NumeroALetras();
    //     $valor=$formatter->toInvoice($total, 2, 'soles');
        
    //     $legend = new Legend();
    //     $legend->setCode('1000')
    //         ->setValue($valor);

    //     $note->setDetails($item)
    //         ->setLegends([$legend]);
        
    //     return $note;
    // }

    //NOTA DE CREDITO - BOLETA

    public static function nota_credito_boleta($boleta,$boleta_registro,$precio_credito,$cantidad,$notas_creditos_count,$nota_credito_code,$gravada,$exonerada,$inafecta,$motivo,$sustento,$fecha_emision){
        // return $boleta;
        
        $empresa=Empresa::first();
        $igv=Igv::first();

        // Cliente
        $client = (new Client())
            ->setTipoDoc('1')   //pagina 42 del pdf sunat 2.1
            ->setNumDoc($boleta->cliente->numero_documento) //ruc del receptor
            ->setRznSocial($boleta->cliente->empresa); //nombre empresa

        // Emisor
        $address = (new Address())
            ->setUbigueo('150101')
            ->setDepartamento($empresa->region_provincia)
            ->setProvincia($empresa->region_provincia)
            ->setDistrito($empresa->ciudad)
            ->setUrbanizacion('-')
            ->setDireccion($empresa->calle)
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
            ->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->razon_social)
            ->setNombreComercial($empresa->nombre)
            ->setAddress($address);

        $contador=count($boleta_registro);
            
        $cont=0;
        $igv_f=0;
        $precio=0;
        $op_g=0;

        for($p=0;$p<$contador;$p++){
            $string=(string)$p;
            
            // $cantidad="input_cantidad_".$string;
            // $input_precio="input_precio_".$string;
            // $descripcion="input_descripcion_".$string;

            if(isset($boleta_registro[$p]->producto->codigo_producto)){
                $item_nombre = $boleta_registro[$p]->producto->codigo_producto;
                $desc_nombre = $boleta_registro[$p]->producto->nombre;
                $afec = $boleta_registro[$p]->producto->tipo_afec_i_producto->codigo;
                $codigo_item = 'NIU';
            }else{
                $item_nombre = $boleta_registro[$p]->servicio->codigo_servicio;
                $desc_nombre = $boleta_registro[$p]->servicio->nombre;
                $afec = $boleta_registro[$p]->servicio->tipo_afec_i_serv->codigo;
                $codigo_item = 'ZZ';
            }
            
            if($cantidad[$p]==NULL){
            }else{

                if( in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
                    $item[$cont]=new SaleDetail();
                    $item[$cont]
                        ->setCodProducto($item_nombre)
                        ->setUnidad($codigo_item)
                        ->setCantidad($cantidad[$p])
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($precio_credito[$p]*$cantidad[$p])
                        ->setPorcentajeIgv($igv->igv_total)
                        ->setIgv($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
                        ->setTipAfeIgv($afec)
                        ->setTotalImpuestos($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
                        ->setMtoValorVenta($precio_credito[$p]*$cantidad[$p])
                        ->setMtoValorUnitario($precio_credito[$p])
                        ->setMtoPrecioUnitario($precio_credito[$p]+($precio_credito[$p]*(($igv->igv_total)/100)));

                    $igv_f=$precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100)+$igv_f;
                    $precio=$precio_credito[$p]*$cantidad[$p]+$precio;

                    $cont++;
                }else{
                    $item[$cont]=new SaleDetail();
                    $item[$cont]
                        ->setCodProducto($item_nombre)
                        ->setUnidad($codigo_item)
                        ->setCantidad($cantidad[$p])
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($precio_credito[$p]*$cantidad[$p])
                        ->setPorcentajeIgv($igv->igv_total)
                        ->setIgv($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
                        ->setTipAfeIgv($afec)
                        ->setTotalImpuestos($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100))
                        ->setMtoValorVenta($precio_credito[$p]*$cantidad[$p])
                        ->setMtoValorUnitario($precio_credito[$p])
                        ->setMtoPrecioUnitario($precio_credito[$p]+($precio_credito[$p]*(($igv->igv_total)/100)));

                    $precio=$precio_credito[$p]*$cantidad[$p]+$precio;

                    $cont++;
                }

                if($precio_credito[$p]*$cantidad[$p]*(($igv->igv_total)/100) != 0){ //IGV
                    $op_g=$op_g+($precio_credito[$p]*$cantidad[$p]);
                }
                // $sol = ($precio_credito[$p]*$cantidad[$p]);
            }
        }
        
        
        $total=$igv_f+$precio;
        // die($sol);

        //CODIGO NOTA
        $codigo_nota=$nota_credito_code;
        $serie=explode("-",$codigo_nota);

        $correlativo=$serie[1];
        $serie=$serie[0];
       
        $note = new Note();
        $note
            ->setUblVersion('2.1')
            ->setTipoDoc('07')
            ->setSerie($serie)
            ->setCorrelativo($correlativo)
            ->setFechaEmision($fecha_emision)
            ->setTipDocAfectado('03') // Tipo Doc: boleta
            ->setNumDocfectado($boleta->codigo_boleta) // boleta: Serie-Correlativo
            ->setCodMotivo('07') // Catalogo. 09
            ->setDesMotivo($motivo)
            ->setTipoMoneda($boleta->moneda->codigo)
            ->setCompany($company)
            ->setClient($client)
            ->setMtoOperGravadas($gravada) 
            ->setMtoOperInafectas($inafecta)
            ->setMtoOperExoneradas($exonerada)
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setMtoImpVenta($total)
            ;

        $formatter = new NumeroALetras();
        $valor=$formatter->toInvoice($total, 2, 'soles');
        
        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue($valor);

        $note->setDetails($item)
            ->setLegends([$legend]);
        
        return $note;

    }

    // public static function nota_credito_boleta_servicio($boleta,$boleta_registro,$request,$notas_creditos_count,$nota_credito_code,$gravada,$exonerada,$inafecta,$motivo){
    //     $empresa=Empresa::first();
    //     $igv=Igv::first();

    //     // Cliente
    //     $client = (new Client())
    //         ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
    //         ->setNumDoc($boleta->cliente->numero_documento) //ruc del receptor
    //         ->setRznSocial($boleta->cliente->empresa); //nombre empresa

    //     // Emisor
    //     $address = (new Address())
    //         ->setUbigueo('150101')
    //         ->setDepartamento($empresa->region_provincia)
    //         ->setProvincia($empresa->region_provincia)
    //         ->setDistrito($empresa->ciudad)
    //         ->setUrbanizacion('-')
    //         ->setDireccion($empresa->calle)
    //         ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

    //     $company = (new Company())
    //         ->setRuc($empresa->ruc)
    //         ->setRazonSocial($empresa->razon_social)
    //         ->setNombreComercial($empresa->nombre)
    //         ->setAddress($address);

    //     $contador=count($boleta_registro);
            
    //     $cont=0;
    //     $igv_f=0;
    //     $precio=0;
    //     $op_g=0;

    //     for($p=0;$p<$contador;$p++){
    //         $string=(string)$p;
            
    //         $nombre="input_disabled_".$string;
            
    //         if($request->$nombre==NULL){
    //         }else{

    //             if( in_array($boleta_registro[$p]->servicio->tipo_afec_i_serv->codigo, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($boleta_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($request->$nombre)
    //                 ->setDescripcion($boleta_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($boleta_registro[$p]->precio*$request->$nombre)
    //                 ->setPorcentajeIgv($igv->igv_total)
    //                 ->setIgv($boleta_registro[$p]->precio*$request->$nombre*(($igv->igv_total)/100))
    //                 ->setTipAfeIgv($boleta_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($boleta_registro[$p]->precio*$request->$nombre*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($boleta_registro[$p]->precio*$request->$nombre)
    //                 ->setMtoValorUnitario($boleta_registro[$p]->precio)
    //                 ->setMtoPrecioUnitario($boleta_registro[$p]->precio+($boleta_registro[$p]->precio*(($igv->igv_total)/100)));

    //                 $igv_f=$boleta_registro[$p]->precio*$request->$nombre*(($igv->igv_total)/100)+$igv_f;
    //                 $precio=$boleta_registro[$p]->precio*$request->$nombre+$precio;

    //                 $cont++;
    //             }else{
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($boleta_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($request->$nombre)
    //                 ->setDescripcion($boleta_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($boleta_registro[$p]->precio*$request->$nombre)
    //                 ->setPorcentajeIgv(0)
    //                 ->setIgv(0)
    //                 ->setTipAfeIgv($boleta_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($boleta_registro[$p]->precio*$request->$nombre*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($boleta_registro[$p]->precio*$request->$nombre)
    //                 ->setMtoValorUnitario($boleta_registro[$p]->precio)
    //                 ->setMtoPrecioUnitario($boleta_registro[$p]->precio+($boleta_registro[$p]->precio*(($igv->igv_total)/100)));

    //                 $precio=$boleta_registro[$p]->precio*$request->$nombre+$precio;

    //                 $cont++;
    //             }

                
    //         }
    //     }

    //     $total=$igv_f+$precio;

    //     //CODIGO NOTA
    //     $codigo_nota=$nota_credito_code;
    //     $serie=explode("-",$codigo_nota);

    //     $correlativo=$serie[1];
    //     $serie=$serie[0];

    //     $note = new Note();
    //     $note
    //         ->setUblVersion('2.1')
    //         ->setTipoDoc('07')
    //         ->setSerie($serie)
    //         ->setCorrelativo($correlativo)
    //         ->setFechaEmision($boleta->created_at)
    //         ->setTipDocAfectado('03') // Tipo Doc: boleta
    //         ->setNumDocfectado($boleta->codigo_boleta) // boleta: Serie-Correlativo
    //         ->setCodMotivo('07') // Catalogo. 09
    //         ->setDesMotivo($motivo)
    //         ->setTipoMoneda($boleta->moneda->codigo)
    //         ->setCompany($company)
    //         ->setClient($client)
    //         ->setMtoOperGravadas($gravada) 
    //         ->setMtoOperInafectas($inafecta)
    //         ->setMtoOperExoneradas($exonerada)
    //         ->setMtoIGV($igv_f)
    //         ->setTotalImpuestos($igv_f)
    //         ->setMtoImpVenta($total)
    //         ;

    //     $formatter = new NumeroALetras();
    //     $valor=$formatter->toInvoice($total, 2, 'soles');
        
    //     $legend = new Legend();
    //     $legend->setCode('1000')
    //         ->setValue($valor);

    //     $note->setDetails($item)
    //         ->setLegends([$legend]);
        
    //     return $note;
    // }



    //nota debito - factura

    public static function nota_debito($factura, $factura_registro, $request,$nota_debito_code,$gravada,$exonerada,$inafecta,$tipo,$motivo,$nb_registros,$fecha_emi){

        $empresa=Empresa::first();
        $igv=Igv::first();

        // Cliente
        $client = (new Client())
            ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
            ->setNumDoc($factura->cliente->numero_documento) //ruc del receptor
            ->setRznSocial($factura->cliente->empresa); //nombre empresa

        // Emisor
        $address = (new Address())
            ->setUbigueo('150101')
            ->setDepartamento($empresa->region_provincia)
            ->setProvincia($empresa->region_provincia)
            ->setDistrito($empresa->ciudad)
            ->setUrbanizacion('-')
            ->setDireccion($empresa->calle)
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
            ->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->razon_social)
            ->setNombreComercial($empresa->nombre)
            ->setAddress($address);

        $contador=count($nb_registros);
            
        $cont=0;
        $igv_f=0;
        $precio=0;
        $op_g=0;

        // dd($nb_registros);

        for($p=0;$p<$contador;$p++){
            // $/=(string)$p;
            if(isset($nb_registros[$p]->producto->codigo_producto)){
                $item_nombre = $nb_registros[$p]->producto->codigo_producto;
                $desc_nombre = $nb_registros[$p]->producto->nombre;
                $afec = $nb_registros[$p]->producto->tipo_afec_i_producto->codigo;
                $codigo_item = 'NIU';
            }else{
                $item_nombre = $nb_registros[$p]->servicio->codigo_servicio;
                $desc_nombre = $nb_registros[$p]->servicio->nombre;
                $afec = $nb_registros[$p]->servicio->tipo_afec_i_serv->codigo;
                $codigo_item = 'ZZ';
            }
            // $nombre="input _disabled_".$string;
            $nombre_precio=$nb_registros[$p]->precio;
            // dd($nombre_precio);
            if($nombre_precio==NULL){
            }else{

                if( in_array($afec, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
                    $item[$cont]=new SaleDetail();
                    $item[$cont]
                        ->setCodProducto($item_nombre)
                        ->setUnidad($codigo_item)
                        ->setCantidad($nb_registros[$p]->cantidad)
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setPorcentajeIgv($igv->igv_total)
                        ->setIgv($nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100))
                        ->setTipAfeIgv($afec)
                        ->setTotalImpuestos($nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100))
                        ->setMtoValorVenta($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setMtoValorUnitario($nombre_precio)
                        ->setMtoPrecioUnitario($nombre_precio+($nombre_precio*(($igv->igv_total)/100)));

                    $igv_f=$nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100)+$igv_f;
                    $precio=$nombre_precio*$nb_registros[$p]->cantidad+$precio;

                    $cont++;
                }else{
                    $item[$cont]=new SaleDetail();
                    $item[$cont]
                        ->setCodProducto($item_nombre)
                        ->setUnidad($codigo_item)
                        ->setCantidad($nb_registros[$p]->cantidad)
                        ->setDescripcion($desc_nombre)
                        ->setMtoBaseIgv($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setPorcentajeIgv(0)
                        ->setIgv(0)
                        ->setTipAfeIgv($afec)
                        ->setTotalImpuestos($nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100))
                        ->setMtoValorVenta($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setMtoValorUnitario($nombre_precio)
                        ->setMtoPrecioUnitario($nombre_precio+($nombre_precio*(($igv->igv_total)/100)));

                    $precio=$nombre_precio*$nb_registros[$p]->cantidad+$precio;

                    $cont++;
                }
                
            }
        }
        // dd($factura_registro);
        // dd($factura_registro[0]);
        $total=$igv_f+$precio;

        //CODIGO NOTA
        $codigo_nota=$nota_debito_code;
        $serie=explode("-",$codigo_nota);

        $correlativo=$serie[1];
        $serie=$serie[0];
        // $serie;
        $note = new Note();
        $note
            ->setUblVersion('2.1')
            ->setTipoDoc('08') // nota debito 
            ->setSerie($serie)
            ->setCorrelativo($correlativo)
            ->setFechaEmision($fecha_emi)
            ->setTipDocAfectado('01') // Tipo Doc: Factura
            ->setNumDocfectado($factura->codigo_fac) // Factura: Serie-Correlativo
            ->setCodMotivo($tipo) // Catalogo. 09 https://www.sunat.gob.pe/legislacion/superin/2014/anexo8-300-2014.pdf pagina5
            ->setDesMotivo($motivo)
            ->setTipoMoneda($factura->moneda->codigo)
            ->setCompany($company)
            ->setClient($client)
            ->setMtoOperGravadas($gravada) 
            ->setMtoOperInafectas($inafecta)
            ->setMtoOperExoneradas($exonerada)
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setMtoImpVenta($total)
            ;

        $formatter = new NumeroALetras();
        $valor=$formatter->toInvoice($total, 2, 'soles');
        
        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue($valor);
        
        $note->setDetails($item)  
            ->setLegends([$legend]);
        
        return $note;
    }


    // public static function nota_debito_servicio($factura, $factura_registro, $request,$notas_debitos_count,$nota_debito_code,$gravada,$exonerada,$inafecta,$motivo){

    //     $empresa=Empresa::first();
    //     $igv=Igv::first();

    //     // Cliente
    //     $client = (new Client())
    //         ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
    //         ->setNumDoc($factura->cliente->numero_documento) //ruc del receptor
    //         ->setRznSocial($factura->cliente->empresa); //nombre empresa

    //     // Emisor
    //     $address = (new Address())
    //         ->setUbigueo('150101')
    //         ->setDepartamento($empresa->region_provincia)
    //         ->setProvincia($empresa->region_provincia)
    //         ->setDistrito($empresa->ciudad)
    //         ->setUrbanizacion('-')
    //         ->setDireccion($empresa->calle)
    //         ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

    //     $company = (new Company())
    //         ->setRuc($empresa->ruc)
    //         ->setRazonSocial($empresa->razon_social)
    //         ->setNombreComercial($empresa->nombre)
    //         ->setAddress($address);

    //     $contador=count($factura_registro);
            
    //     $cont=0;
    //     $igv_f=0;
    //     $precio=0;
    //     $op_g=0;

        
    //     for($p=0;$p<$contador;$p++){
    //         $string=(string)$p;
            
    //         $nombre="input_disabled_".$string;
    //         $nombre_precio="input_disabled_precio_".$string;
    //         if($request->$nombre_precio==NULL){
    //         }else{


    //             if( in_array($factura_registro[$p]->servicio->tipo_afec_i_serv->codigo, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($factura_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($factura_registro[$p]->cantidad)
    //                 ->setDescripcion($factura_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($request->$nombre_precio*$factura_registro[$p]->cantidad)
    //                 ->setPorcentajeIgv($igv->igv_total)
    //                 ->setIgv($request->$nombre_precio*$factura_registro[$p]->cantidad*(($igv->igv_total)/100))
    //                 ->setTipAfeIgv($factura_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($request->$nombre_precio*$factura_registro[$p]->cantidad*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($request->$nombre_precio*$factura_registro[$p]->cantidad)
    //                 ->setMtoValorUnitario($request->$nombre_precio)
    //                 ->setMtoPrecioUnitario($request->$nombre_precio+($request->$nombre_precio*(($igv->igv_total)/100)));

    //                 $igv_f=$request->$nombre_precio*$factura_registro[$p]->cantidad*(($igv->igv_total)/100)+$igv_f;
    //                 $precio=$request->$nombre_precio*$factura_registro[$p]->cantidad+$precio;

    //                 $cont++;
    //             }else{
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($factura_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($factura_registro[$p]->cantidad)
    //                 ->setDescripcion($factura_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($request->$nombre_precio*$factura_registro[$p]->cantidad)
    //                 ->setPorcentajeIgv(0)
    //                 ->setIgv(0)
    //                 ->setTipAfeIgv($factura_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($request->$nombre_precio*$factura_registro[$p]->cantidad*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($request->$nombre_precio*$factura_registro[$p]->cantidad)
    //                 ->setMtoValorUnitario($request->$nombre_precio)
    //                 ->setMtoPrecioUnitario($request->$nombre_precio+($request->$nombre_precio*(($igv->igv_total)/100)));

    //                 $precio=$request->$nombre_precio*$factura_registro[$p]->cantidad+$precio;

    //                 $cont++;
    //             }


                
    //         }
    //     }

    //     $total=$igv_f+$precio;

    //     //CODIGO NOTA
    //     $codigo_nota=$nota_debito_code;
    //     $serie=explode("-",$codigo_nota);

    //     $correlativo=$serie[1];
    //     $serie=$serie[0];

    //     $note = new Note();
    //     $note
    //         ->setUblVersion('2.1')
    //         ->setTipoDoc('07')
    //         ->setSerie($serie)
    //         ->setCorrelativo($correlativo)
    //         ->setFechaEmision($factura->created_at)
    //         ->setTipDocAfectado('01') // Tipo Doc: Factura
    //         ->setNumDocfectado($factura->codigo_fac) // Factura: Serie-Correlativo
    //         ->setCodMotivo('02') // Catalogo. 09
    //         ->setDesMotivo($motivo)
    //         ->setTipoMoneda($factura->moneda->codigo)
    //         ->setCompany($company)
    //         ->setClient($client)
    //         ->setMtoOperGravadas($gravada) 
    //         ->setMtoOperInafectas($inafecta)
    //         ->setMtoOperExoneradas($exonerada)
    //         ->setMtoIGV($igv_f)
    //         ->setTotalImpuestos($igv_f)
    //         ->setMtoImpVenta($total)
    //         ;

    //     $formatter = new NumeroALetras();
    //     $valor=$formatter->toInvoice($total, 2, 'soles');
        
    //     $legend = new Legend();
    //     $legend->setCode('1000')
    //         ->setValue($valor);

    //     $note->setDetails($item)
    //         ->setLegends([$legend]);
        
    //     return $note;
    // }


    //NOTA DE DEBITO - BOLETA

    public static function nota_debito_boleta($boleta,$boleta_registro,$request,$nota_debito_code,$gravada,$exonerada,$inafecta,$tipo,$motivo,$nb_registros,$fecha_emi){
        // return $motivo;
        
        $empresa=Empresa::first();
        $igv=Igv::first();

        // Cliente
        $client = (new Client())
            ->setTipoDoc('1')   //pagina 42 del pdf sunat 2.1
            ->setNumDoc($boleta->cliente->numero_documento) //ruc del receptor
            ->setRznSocial($boleta->cliente->empresa); //nombre empresa

        // Emisor
        $address = (new Address())
            ->setUbigueo('150101')
            ->setDepartamento($empresa->region_provincia)
            ->setProvincia($empresa->region_provincia)
            ->setDistrito($empresa->ciudad)
            ->setUrbanizacion('-')
            ->setDireccion($empresa->calle)
            ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

        $company = (new Company())
            ->setRuc($empresa->ruc)
            ->setRazonSocial($empresa->razon_social)
            ->setNombreComercial($empresa->nombre)
            ->setAddress($address);

            // dd($nb_registros);
        $contador=count($nb_registros);
            
        $cont=0;
        $igv_f=0;
        $precio=0;
        $op_g=0;

        for($p=0;$p<$contador;$p++){
            $string=(string)$p;
            
            $nombre="input_disabled_".$string;
            $nombre_precio=$nb_registros[$p]->precio;
            if($nombre_precio==NULL){
            }else{

                if( in_array($nb_registros[$p]->producto->tipo_afec_i_producto->codigo, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
                    $item[$cont]=new SaleDetail();
                    $item[$cont]
                        ->setCodProducto($nb_registros[$p]->producto->codigo_producto)
                        ->setUnidad('NIU')
                        ->setCantidad($nb_registros[$p]->cantidad)
                        ->setDescripcion($nb_registros[$p]->producto->nombre)
                        ->setMtoBaseIgv($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setPorcentajeIgv($igv->igv_total)
                        ->setIgv($nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100))
                        ->setTipAfeIgv($nb_registros[$p]->producto->tipo_afec_i_producto->codigo)
                        ->setTotalImpuestos($nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100))
                        ->setMtoValorVenta($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setMtoValorUnitario($nombre_precio)
                        ->setMtoPrecioUnitario($nombre_precio+($nombre_precio*(($igv->igv_total)/100)));

                    $igv_f=$nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100)+$igv_f;                                                                                                              
                    $precio=$nombre_precio*$nb_registros[$p]->cantidad+$precio;

                    $cont++;
                }else{
                    $item[$cont]=new SaleDetail();
                    $item[$cont]
                        ->setCodProducto($nb_registros[$p]->producto->codigo_producto)
                        ->setUnidad('NIU')
                        ->setCantidad($nb_registros[$p]->cantidad)
                        ->setDescripcion($nb_registros[$p]->producto->nombre)
                        ->setMtoBaseIgv($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setPorcentajeIgv(0)
                        ->setIgv(0)
                        ->setTipAfeIgv($nb_registros[$p]->producto->tipo_afec_i_producto->codigo)
                        ->setTotalImpuestos($nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100))
                        ->setMtoValorVenta($nombre_precio*$nb_registros[$p]->cantidad)
                        ->setMtoValorUnitario($nombre_precio)
                        ->setMtoPrecioUnitario($nombre_precio+($nombre_precio*(($igv->igv_total)/100)));

                    $igv_f=$nombre_precio*$nb_registros[$p]->cantidad*(($igv->igv_total)/100)+$igv_f;
                    $precio=$nombre_precio*$nb_registros[$p]->cantidad+$precio;

                    $cont++;
                }


                
            }
        }

        $total=$igv_f+$precio;

        //CODIGO NOTA
        $codigo_nota=$nota_debito_code;
        $serie=explode("-",$codigo_nota);

        $correlativo=$serie[1];
        $serie=$serie[0];

        $note = new Note();
        $note
            ->setUblVersion('2.1')
            ->setTipoDoc('08')
            ->setSerie($serie)
            ->setCorrelativo($correlativo)
            ->setFechaEmision($fecha_emi)
            ->setTipDocAfectado('03') // Tipo Doc: boleta
            ->setNumDocfectado($boleta->codigo_boleta) // boleta: Serie-Correlativo
            ->setCodMotivo($tipo) // Catalogo. 09
            ->setDesMotivo($motivo)
            ->setTipoMoneda($boleta->moneda->codigo)
            ->setCompany($company)
            ->setClient($client)
            ->setMtoOperGravadas($gravada) 
            ->setMtoOperInafectas($inafecta)
            ->setMtoOperExoneradas($exonerada)
            ->setMtoIGV($igv_f)
            ->setTotalImpuestos($igv_f)
            ->setMtoImpVenta($total)
            ;

        $formatter = new NumeroALetras();
        $valor=$formatter->toInvoice($total, 2, 'soles');
        
        $legend = new Legend();
        $legend->setCode('1000')
            ->setValue($valor);

        $note->setDetails($item)
            ->setLegends([$legend]);
        
        return $note;

    }

    // public static function nota_debito_boleta_servicio($boleta,$boleta_registro,$request,$notas_debitos_count,$nota_debito_code,$gravada,$exonerada,$inafecta,,%$motivo){
    //     $empresa=Empresa::first();
    //     $igv=Igv::first();

    //     // Cliente
    //     $client = (new Client())
    //         ->setTipoDoc('6')   //pagina 42 del pdf sunat 2.1
    //         ->setNumDoc($boleta->cliente->numero_documento) //ruc del receptor
    //         ->setRznSocial($boleta->cliente->empresa); //nombre empresa

    //     // Emisor
    //     $address = (new Address())
    //         ->setUbigueo('150101')
    //         ->setDepartamento($empresa->region_provincia)
    //         ->setProvincia($empresa->region_provincia)
    //         ->setDistrito($empresa->ciudad)
    //         ->setUrbanizacion('-')
    //         ->setDireccion($empresa->calle)
    //         ->setCodLocal('0000'); // Codigo de establecimiento asignado por SUNAT, 0000 por defecto.

    //     $company = (new Company())
    //         ->setRuc($empresa->ruc)
    //         ->setRazonSocial($empresa->razon_social)
    //         ->setNombreComercial($empresa->nombre)
    //         ->setAddress($address);

    //     $contador=count($boleta_registro);
            
    //     $cont=0;
    //     $igv_f=0;
    //     $precio=0;
    //     $op_g=0;

    //     for($p=0;$p<$contador;$p++){
    //         $string=(string)$p;
            
    //         $nombre="input_disabled_".$string;
    //         $nombre_precio="input_disabled_precio_".$string;
    //         if($request->$nombre_precio==NULL){
    //         }else{

    //             if( in_array($boleta_registro[$p]->servicio->tipo_afec_i_serv->codigo, array("10", "11", "12", "13", "14", "15", "16", "17")) ){
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($boleta_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($boleta_registro[$p]->cantidad)
    //                 ->setDescripcion($boleta_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($request->$nombre_precio*$boleta_registro[$p]->cantidad)
    //                 ->setPorcentajeIgv($igv->igv_total)
    //                 ->setIgv($request->$nombre_precio*$boleta_registro[$p]->cantidad*(($igv->igv_total)/100))
    //                 ->setTipAfeIgv($boleta_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($request->$nombre_precio*$boleta_registro[$p]->cantidad*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($request->$nombre_precio*$boleta_registro[$p]->cantidad)
    //                 ->setMtoValorUnitario($request->$nombre_precio)
    //                 ->setMtoPrecioUnitario($request->$nombre_precio+($request->$nombre_precio*(($igv->igv_total)/100)));

    //                 $igv_f=$request->$nombre_precio*$boleta_registro[$p]->cantidad*(($igv->igv_total)/100)+$igv_f;
    //                 $precio=$request->$nombre_precio*$boleta_registro[$p]->cantidad+$precio;

    //                 $cont++;
    //             }else{
    //                 $item[$cont]=new SaleDetail();
    //                 $item[$cont]
    //                 ->setCodProducto($boleta_registro[$p]->servicio->codigo_servicio)
    //                 ->setUnidad('ZZ')
    //                 ->setCantidad($boleta_registro[$p]->cantidad)
    //                 ->setDescripcion($boleta_registro[$p]->servicio->nombre)
    //                 ->setMtoBaseIgv($request->$nombre_precio*$boleta_registro[$p]->cantidad)
    //                 ->setPorcentajeIgv(0)
    //                 ->setIgv(0)
    //                 ->setTipAfeIgv($boleta_registro[$p]->servicio->tipo_afec_i_serv->codigo)
    //                 ->setTotalImpuestos($request->$nombre_precio*$boleta_registro[$p]->cantidad*(($igv->igv_total)/100))
    //                 ->setMtoValorVenta($request->$nombre_precio*$boleta_registro[$p]->cantidad)
    //                 ->setMtoValorUnitario($request->$nombre_precio)
    //                 ->setMtoPrecioUnitario($request->$nombre_precio+($request->$nombre_precio*(($igv->igv_total)/100)));

    //                 $precio=$request->$nombre_precio*$boleta_registro[$p]->cantidad+$precio;

    //                 $cont++;
    //             }

                
    //         }
    //     }

    //     $total=$igv_f+$precio;

    //     //CODIGO NOTA
    //     $codigo_nota=$nota_debito_code;
    //     $serie=explode("-",$codigo_nota);

    //     $correlativo=$serie[1];
    //     $serie=$serie[0];

    //     $note = new Note();
    //     $note
    //         ->setUblVersion('2.1')
    //         ->setTipoDoc('08')
    //         ->setSerie($serie)
    //         ->setCorrelativo($correlativo)
    //         ->setFechaEmision($fecha_emi)
    //         ->setTipDocAfectado('03') // Tipo Doc: boleta
    //         ->setNumDocfectado($boleta->codigo_boleta) // boleta: Serie-Correlativo
    //         ->setCodMotivo($tipo) // Catalogo. 09
    //         ->setDesMotivo($motivo)
    //         ->setTipoMoneda($boleta->moneda->codigo)
    //         ->setCompany($company)
    //         ->setClient($client)
    //         ->setMtoOperGravadas($gravada) 
    //         ->setMtoOperInafectas($inafecta)
    //         ->setMtoOperExoneradas($exonerada)
    //         ->setMtoIGV($igv_f)
    //         ->setTotalImpuestos($igv_f)
    //         ->setMtoImpVenta($total)
    //         ;

    //     $formatter = new NumeroALetras();
    //     $valor=$formatter->toInvoice($total, 2, 'soles');
        
    //     $legend = new Legend();
    //     $legend->setCode('1000')
    //         ->setValue($valor);

    //     $note->setDetails($item)
    //         ->setLegends([$legend]);
        
    //     return $note;
    // }

    
}

