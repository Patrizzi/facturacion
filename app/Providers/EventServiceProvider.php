<?php

namespace App\Providers;

use App\Cuotas_credito;
use App\Listeners\CreatePermissionsOnLogin;
use App\Observers\CuotasCreditosObserver;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
// use App\TipoCambio;
// use App\Observers\TipoCambioObserver;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Authenticated::class => [
            CreatePermissionsOnLogin::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        // Users::observe(new UserObserver());
        Cuotas_credito::observe(CuotasCreditosObserver::class);


    }
}
