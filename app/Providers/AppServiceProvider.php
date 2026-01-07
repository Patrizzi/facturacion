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
use App\Boleta;
use App\Boleta_m;
use App\Cuotas_credito;
use App\EventosUsers;
use App\Facturacion;
use App\Facturacion_m;
use App\Guia_remision;
use App\GuiaRemisionManual;
use App\kardex_entrada_registro;
use App\Nota_Credito;
use App\Nota_Debito;
use App\Observers\CuotasCreditosObserver;
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
        setlocale(LC_ALL, 'spanish');
        TipoCambio::observe(TipoCambioObserver::class);
        Stock_producto::observe(StockProductosObserver::class);
        Cuotas_credito::observe(CuotasCreditosObserver::class);

        // kardex_entrada_registro::observe(KardexEntradaRegistroObserver::class);
        // TipoCambio::observe(new TipoCambioObserver());
        View::composer('layout', function ($view) {
            $view->with('tipo_cambio', TipoCambio::where('fecha', Carbon::now()->format('Y-m-d'))->first());
            $view->with('empresa', Empresa::first());
            $view->with('inventario_inicial', Kardex_entrada::first());
            $view->with('almacen', Almacen::all());
            $view->with('conteo_almacen', Almacen::count());
            $view->with('almacen_primero', Almacen::first());
            $view->with('fact_view_count', Facturacion::where('f_electronica', 0)->count());
            $view->with('fact_m_view_count', Facturacion_m::where('f_electronica', 0)->count());
            $view->with('bol_view_count', Boleta::where('b_electronica', 0)->count());
            $view->with('bol_m_view_count', Boleta_m::where('b_electronica', 0)->count());
            $view->with('guia_view_count', Guia_remision::where('g_electronica', 0)->count());
            $view->with('guia_m_view_count', GuiaRemisionManual::where('g_electronica', 0)->count());
            $view->with('n_credito_view_count', Nota_Credito::where('n_electronica', 0)->count());
            $view->with('n_debito_view_count', Nota_Debito::where('n_electronica', 0)->count());
            $view->with('count_eventos', EventosUsers::get_user_events());
        });
        // return auth()->user()->id;
        Schema::defaultStringLength(191);
    }
}
