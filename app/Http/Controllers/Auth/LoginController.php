<?php

namespace App\Http\Controllers\Auth;
use App\Empresa;
use App\Http\Controllers\Controller;
use App\Producto;
use App\User;
use Exception;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');

    }

    protected function credentials(Request $request)
    {
        $request['estado'] = 1;

        return $request->only($this->username(), 'password', 'estado');
    }

    public function showLoginForm()
    {
        $hora = date('H:m:s');
        // $hora='03:03:04';
        if ($hora > '12:00:01' and $hora < '18:00:00') {
            $buenas = 'Buenas Tardes';
        } elseif ($hora > '18:00:01') {
            $buenas = 'Buenas Noches';
        } else {
            $buenas = 'Buen Día';
        }
        $mi_empresa = Empresa::first();
        $url = $mi_empresa->background ?? 'https://images4.alphacoders.com/113/thumb-1920-1133047.jpg';
        return view('auth.login', compact('url', 'mi_empresa', 'buenas'));
    }


    public function login(Request $request)
    {
        if (! Auth::attempt($request->only('email', 'password'))) {
            if($request->expectsJson()) {
                return response()->json(["message" => "Unauthorized"], 401);
            }

            return back()->withErrors([
                'email' => 'Credenciales incorrectas',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();
        return redirect('/');

        // return response()->json([
        //     'AccessToken' => $token,
        //     'TokenType' => 'Bearer',
        //     'user' => $user
        // ], 200);
    }

    public function regenerateSession(Request $request, $email, $password){

        $newRequest = $request->duplicate();
        $newRequest->merge([
            'email' => $email,
            'password' => $password
        ]);

        if (! Auth::attempt($newRequest->only('email', 'password'))) {
            return response()->json(["message" => "Unauthorized"], 401);
        }

        $newRequest->session()->regenerate();
        return redirect('/');

    }

    public function verifyCredentials(Request $request, $email, $password){
        try{
            $access = true;
            $newRequest = $request->duplicate();
            $newRequest->merge([
                'email' => $email,
                'password' => $password
            ]);
            if (! Auth::validate($newRequest->only('email', 'password'))) {
                $access = false;
            }
            return response()->json(["status" => 200,"access" => $access]);
        } catch(Exception $e){
            return response()->json(["status" => 500, "message" => "ocurrió un error.", "error" => $e, "errorMessage" => $e->getMessage()]);
        }
    }

}
