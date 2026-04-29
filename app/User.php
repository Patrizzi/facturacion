<?php

namespace App;

use App\Almacen;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'almacen_id',
        'estado',
        'check_kardex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function personal()
    {
        return $this->belongsTo(Personal::class, 'personal_id');
    }
    public function config()
    {
        return $this->belongsTo(Config::class, 'confi_id');
    }
    public function almacen()
    {
        return $this->belongsTo(Almacen::class, 'almacen_id');
    }

    public function servicioGuia()
    {
        return $this->hasMany(ServicioGuia::class, 'user_id', 'id');
    }

    public static function codigo_mensaje()
    {
        $numero_validacion = rand(600000000, 900000000);
        $codigo_1 = substr($numero_validacion, 0, 3);
        $codigo_2 = substr($numero_validacion, 3, 3);
        $codigo_3 = substr($numero_validacion, 6, 3);
        $codigo_final = $codigo_1 . '-' . $codigo_2 . '-' . $codigo_3;
        return $codigo_final;
    }

    public static function send_mail_register($user,$correo) {

        $personal = $user->personal;
        $codigo = $user->numero_validacion;
        $empresa= Empresa::first();
        $usuario_hora=Carbon::now()->format('Y-m-d');

        $mensaje = view('email_html.email_cod_confirmacion',compact('codigo','personal','usuario_hora','empresa'));

        $smtpAddress = env('MAIL_HOST');
        $port = env('MAIL_PORT');
        $encryption = env('MAIL_ENCRYPTION');
        $yourEmail = env('MAIL_USERNAME');
        $yourPassword = env('MAIL_PASSWORD');
        $sendto = $correo;
        $titulo = 'Sistema-Codigo Confirmacion';

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);
        $message = (new \Swift_Message($titulo)) ->setFrom([ $yourEmail => $empresa->nombre ])->setTo([$sendto])->setBody($mensaje, 'text/html');
        if($mailer->send($message)){
            return "200";
        }else{
            return "500";
        }
    }

    public static function send_mail_change_password($user,$correo) {

        $personal = $user->personal;
        $codigo = User::codigo_mensaje();
        $empresa= Empresa::first();
        $usuario_hora=Carbon::now()->format('Y-m-d');

        $mensaje = view('email_html.email_send_new_password',compact('codigo','personal','usuario_hora','empresa'));

        $smtpAddress = env('MAIL_HOST');
        $port = env('MAIL_PORT');
        $encryption = env('MAIL_ENCRYPTION');
        $yourEmail = env('MAIL_USERNAME');
        $yourPassword = env('MAIL_PASSWORD');
        $sendto = $correo;
        $titulo = 'Sistema-Cambio de Contraseña';

        $transport = (new \Swift_SmtpTransport($smtpAddress, $port, $encryption)) -> setUsername($yourEmail) -> setPassword($yourPassword);
        $mailer =new \Swift_Mailer($transport);
        $message = (new \Swift_Message($titulo)) ->setFrom([ $yourEmail => $empresa->nombre ])->setTo([$sendto])->setBody($mensaje, 'text/html');
        if($mailer->send($message)){
            return "200";
        }else{
            return "500";
        }
    }

    public static function updated_personal($personal_id){
        $personal = Personal::find($personal_id);
        $personal->usuario_registrado = 1;
        $personal->save();
    }
}
