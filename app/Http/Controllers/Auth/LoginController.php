<?php

namespace App\Http\Controllers\Auth;
use App\Empresa;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    $hora=date('H:m:s');
    // $hora='03:03:04';
    if ($hora > '12:00:01' and $hora < '18:00:00'){$buenas='Buenas Tardes'; }
    elseif ($hora > '18:00:01') {$buenas='Buenas Noches';}
    else{ $buenas='Buen Día'; }
    $mi_empresa=Empresa::first();
    $url=$mi_empresa->background;
    return view('auth.login',compact('url','mi_empresa','buenas'));
}

}
