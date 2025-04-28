<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

use App\Http\Livewire\Compras\ComprasShow;
use App\Http\Livewire\Ventas\VentaCreate;
use App\Http\Livewire\Ventas\VentaIndex;
use App\Http\Livewire\Ventas\VentasShow;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    /*
    |--------------------------------------------------------------------------
    | Ventas
    |--------------------------------------------------------------------------
    */

    // Visualizar ventas
    Route::get('/ventas', VentaIndex::class)->name('ventas.index');

    // Registrar venta
    Route::get('/ventas/pos', VentaCreate::class)->name('ventas.create');

    //Editar venta
    Route::get('/ventas/{id}/editar', VentaCreate::class)->name('ventas.edit');

    // Factura ventas
    Route::get('/ventas/facturas/{venta}', VentasShow::class)->name('ventas.facturas');

    // Agregar voucher pago a ventas
    Route::put('/ventas/voucher/{venta}', 'App\Http\Controllers\VentaClienteController@voucher')->name('ventas.voucher');
    Route::get('ventas/voucher/{id}/imprimir/', 'App\Http\Controllers\VentaClienteController@voucher_print')->name('ventas.voucher_print');

    // Cierre de caja diario Venta / Compra
    Route::get('/generar-factura', 'App\Http\Controllers\VentaClienteController@generarFacturaPorFecha')->name('ventas.generar-factura');
    Route::get('/generar-factura-compras', 'App\Http\Controllers\CompraClienteController@generarFacturaPorFecha')->name('compras.generar-factura-compras');

    // Cierre de caja mensual Venta / Compra
    Route::get('/generar-factura-mes-actual', 'App\Http\Controllers\VentaClienteController@generarFacturaMesActual')->name('ventas.generar-factura-mes-actual');
    Route::get('/generar-factura-mes-actual-compras', 'App\Http\Controllers\CompraClienteController@generarFacturaMesActual')->name('compras.generar-factura-mes-actual-compras');

    /*
    |--------------------------------------------------------------------------
    |   R O U T E S
    |--------------------------------------------------------------------------
    */

    /* Purchases registration */
    Route::resource('/compras', 'App\Http\Controllers\CompraClienteController')->names('compras');
    Route::post('/compras/update_list', 'App\Http\Controllers\CompraClienteController@newItemOrQuantity')->name('compras.update_list');
    Route::delete('/compras/remove_item/{id}', 'App\Http\Controllers\CompraClienteController@removeItem')->name('compras.remove_item');

    Route::post('/compras/guardar', 'App\Http\Controllers\CompraClienteController@compra_guardar')->name('compras.guardar_compra');

    // Sales invoices
    Route::get('/compras/comprobante/{compra}', ComprasShow::class)->name('compras.facturas'); //app/Http/Livewire/Compras/ComprasShow.php

    /* Providers registration */
    Route::resource('/proveedor', 'App\Http\Controllers\ProveedorController')->names('proveedor');
    Route::delete('/proveedor/{id}', 'App\Http\Controllers\ProveedorController@destroy')
        ->name('proveedor.destroy')->where('id', '[0-9]+');

    /* Products registration */
    Route::resource('/productos', 'App\Http\Controllers\ProductoController')->names('productos');
    Route::delete('/productos/{id}', 'App\Http\Controllers\ProductoController@destroy')
        ->name('productos.destroy')->where('id', '[0-9]+');

    /* Users registration */
    Route::group(['middleware' => ['permission:sidebar_users']], function () {
        Route::resource('/usuarios', App\Http\Controllers\UserController::class)->names('usuarios');

        // Explicitly define the route for destroy with the middleware
        Route::delete('/usuarios/{id}', [App\Http\Controllers\UserController::class, 'destroy'])
            ->name('usuarios.destroy')
            ->middleware('permission:sidebar_users'); // Apply middleware to this specific route
    });

    /* Clients Booking */
    Route::resource('/clients_booking', 'App\Http\Controllers\ClientBookingController')->names('clients_booking');
    Route::post('/clients_booking/{id}', 'App\Http\Controllers\ClientBookingController@cancel_booking')->name('clients_booking.cancel_booking');

    /* Cashoutflow categories */
    Route::resource('/cashoutflow_categories', 'App\Http\Controllers\CashOutflowCategoriesController')->names('cashoutflow_categories');

    /* Cashoutflow types */
    Route::resource('/cashoutflow_types', 'App\Http\Controllers\CashOutflowTypesController')->names('cashoutflow_types');

    /* Cashoutflow */
    Route::resource('/cashoutflows', 'App\Http\Controllers\CashOutflowsController')->names('cashoutflows');
    Route::get('/cashoutflows-monthly-report', 'App\Http\Controllers\CashOutflowsController@cashoutflow_monthly_report')->name('cashoutflows.cashoutflow_monthly_report');

    /* Clients */
    Route::resource('/clients', 'App\Http\Controllers\ClientsController')->names('clients');

    /* Clients treatments */
    Route::resource('/clients/treatments', 'App\Http\Controllers\ClientTreatmentsController')->names('clients_treatments');

    /* Settings */
    Route::resource('/settings', App\Http\Controllers\SettingsController::class)->names('settings');
});
