<?php
// namespace App\Http\Middleware;

// use Closure;

// class Cors
// {
//     public function handle($request, Closure $next)
//     {
//         if ($request->isMethod('OPTIONS')) {
//             return response()->json(['status' => 'success'], 200)
//                 ->header('Access-Control-Allow-Origin', '*')
//                 ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
//                 ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
//         }

//         return $next($request)
//             ->header('Access-Control-Allow-Origin', '*')
//             ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
//             ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
//     }

// }

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class Cors
{
    public function handle($request, Closure $next)
    {
        if ($request->isMethod('OPTIONS')) {
            return response()->json(['status' => 'success'], 200)
                ->header('Access-Control-Allow-Origin', '*')
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        $response = $next($request);

        // Verificar el tipo de respuesta antes de agregar headers
        if ($response instanceof BinaryFileResponse || $response instanceof StreamedResponse) {
            // Para descargas de archivos, usar headers de manera diferente
            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        } else {
            // Para respuestas normales
            $response->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        }

        return $response;
    }
}
