<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use App\TipoCambio;
use App\Empresa;
use App\Stock_producto;
use App\Kardex_entrada;
use App\Almacen;
use App\kardex_entrada_registro;
use Illuminate\Support\Carbon;
// use View;
use App\Observers\TipoCambioObserver;
use App\Observers\StockProductosObserver;
use App\Observers\KardexEntradaRegistroObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        TipoCambio::observe(TipoCambioObserver::class);
        Stock_producto::observe(StockProductosObserver::class);
        
        // kardex_entrada_registro::observe(KardexEntradaRegistroObserver::class);
        // TipoCambio::observe(new TipoCambioObserver());
        View::composer('layout', function ($view) {
            $view->with('tipo_cambio', TipoCambio::where('fecha',Carbon::now()->format('Y-m-d'))->first());
            $view->with('empresa', Empresa::first());
            $view->with('inventario_inicial', Kardex_entrada::first());
            $view->with('almacen', Almacen::all());
            $view->with('conteo_almacen', Almacen::count());
            $view->with('almacen_primero', Almacen::first());
        });
        Schema::defaultStringLength(191);

    }
}
