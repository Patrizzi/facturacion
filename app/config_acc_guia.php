<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Greenter\Model\Client\Client;
use Greenter\Model\Company\Company;
use Greenter\Model\Company\Address;
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
use Greenter\Model\Response\CdrResponse;
use Greenter\Model\Response\Error;
use DateTime;
use Illuminate\Support\Facades\Storage;

use Greenter\Ws\Services\SunatEndpoints;
use Greenter\See;
use Greenter\Api;

use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

use Luecano\NumeroALetras\NumeroALetras;

class config_acc_guia extends Model
{
    //* GUIA DE REMISION PRUEBA 2 *//

    public static function getSeeApi()
    {
        $pfx = file_get_contents(public_path('certificado/certificado.p12'));
        $password = 'Ndalmaten81';

        $certificate = new X509Certificate($pfx, $password);
        
        $api = new \Greenter\Api([
            'auth' => 'https://gre-test.nubefact.com/v1',
            'cpe' => 'https://gre-test.nubefact.com/v1',
        ]);
        // $certificate = file_get_contents(__DIR__ . '/../resources/cert.pem');
        if ($certificate === false) {
            throw new Exception('No se pudo cargar el certificado');
        }
        return $api->setBuilderOptions([
                'strict_variables' => true,
                'optimizations' => 0,
                'debug' => true,
                'cache' => false,
            ])
            ->setApiCredentials('test-85e5b0ae-255c-4891-a595-0b98c65c9854', 'test-Hty/M6QshYvPgItX2P0+Kw==')
            ->setClaveSOL('20161515648', 'MODDATOS', 'MODDATOS')
            // ->setClaveSOL('20545122520', 'JYPSACFA', 'P@@@W0RDs')
            ->setCertificate($certificate->export(X509ContentType::PEM));
            return  $api;

    }
    public static function send_guia($see, $invoice){
        
        $result = $see->send($invoice);
        Storage::disk('facturas_electronicas')->put($invoice->getName().'.xml',$see->getLastXml());
        // Guardar XML firmado digitalmente.

        // /**@var $res SummaryResult*/
        $ticket = $result->getTicket();
        echo 'Ticket :<strong>' . $ticket .'</strong><br>';

        if (!$result->isSuccess()) {
            echo 'Codigo Error '.$result->getError()->getCode().'<br>';
            echo 'mensaje error '.$result->getError()->getMessage().'<br>';
            exit();
            // return;
        }
        

        $res = $see->getStatus($ticket);
        if (!$res->isSuccess()) {
            // echo "error";
            echo 'Codigo Error: '.$res->getError()->getCode().'<br>';
            echo 'Mensaje Error: '.$res->getError()->getMessage().'<br>';
            //  echo 'Mensaje Error: '.$result->getError()->getMessage();
            exit();  
            // return;
        }

        
        // $cdr->writeCdr($invoice, $res->getCdrZip());
        Storage::disk('facturas_electronicas')->put('R-'.$invoice->getName().'.zip', $res->getCdrZip());

        return $res;
        // return $cdr->getDescription().PHP_EOL;
    }
    public static function lectura_cdr_guia2($cdr){
        
        // $cdr = $res->getCdrResponse();
        $code = (int)$cdr->getCode();
        
        if ($code === 0) {
            echo 'ESTADO: ACEPTADA'.PHP_EOL;
            if (count($cdr->getNotes()) > 0) {
                echo 'OBSERVACIONES:'.PHP_EOL;
            // Corregir estas observaciones en siguientes emisiones.
                var_dump($cdr->getNotes());
            }
        }else if ($code >= 2000 && $code <= 3999) {
            echo 'ESTADO: RECHAZADA'.PHP_EOL;
        }else{
            /* Esto no debería darse, pero si ocurre, es un CDR inválido que debería tratarse como un error-excepción. */
            /*code: 0100 a 1999 */
            echo 'Excepción';
        }

        return $cdr->getDescription().PHP_EOL;
    }


    //* FIN DE GUIA DE REMISION PRUEBA 2 *//

}