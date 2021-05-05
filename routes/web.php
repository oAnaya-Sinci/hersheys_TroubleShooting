<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testing;
use App\Http\Controllers\testingIncidencias;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

/* Auth::routes([
    'login'    => true,
    'logout'   => true,
    'register' => true,
    'reset'    => true,   // for resetting passwords
    'confirm'  => false,  // for additional password confirmations
    'verify'   => false,  // for email verification
]); */

Route::group(['middleware'=>['auth']],function(){

    Route::get('/', function () {
        return view('auth/login');
    });

    Route::get('/home/index', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('mainPage/index', function () {
        return view('Development/main/index');
    });

    // Rutas para acciones con catalogos
    Route::get('Catalogos/registros', [App\Http\Controllers\Development\catalogos::class, 'index']);
    Route::get('Catalogos/modificar', [App\Http\Controllers\Development\catalogos::class, 'modificar']);
    Route::get('Catalogos/modificar/getData', [App\Http\Controllers\Development\catalogos::class, 'get_elements_modificar']);
    Route::get('Catalogos/consultas', [App\Http\Controllers\Development\consultaCatalogos::class, 'index']);

    // Rutas para acciones con incidencias
    Route::get('TroubleShooting/registros', [App\Http\Controllers\Development\incidencias::class, 'index']);
    Route::get('TroubleShooting/consultas', [App\Http\Controllers\Development\consultaIncidencias::class, 'index']);

    /* Obtener informacion segun el elemento seleccionado */
    Route::post('Catalogos/getDataElement', [App\Http\Controllers\Development\catalogos::class, 'getElements']);

    /* Guardar informacion sobre los catalogos */
    Route::post('Catalogos/storeCatalogos', [\App\Http\Controllers\Development\catalogos::class, 'store']);

    /* Guardar informacion a actualizar sobre los catalogos */
    Route::post('TroubleShooting/upadateCatalogos', [\App\Http\Controllers\Development\catalogos::class, 'update']);

    /* Obtener informacion de los catalogos para registra incidencias */
    Route::post('TroubleShooting/getDataSelects', [\App\Http\Controllers\Development\incidencias::class, 'getElements']);

    /* Guardar informacion sobre los catalogos */
    Route::post('TroubleShooting/storeIncidencias', [\App\Http\Controllers\Development\incidencias::class, 'store']);

    /** * Rutas Reportes Proyecto */
    Route::get('Reporte/reporte_general', [App\Http\Controllers\Development\reportesHershey::class, 'reporte_general']);
    // Route::get('Reporte/reporte_fallas', [App\Http\Controllers\Development\reportesHershey::class, 'reporte_general_2']);

    Route::post('Reporte/getDataReport/', [App\Http\Controllers\Development\reportesHershey::class, 'get_data_reporte']);
    Route::post('Reporte/getDataTable/', [App\Http\Controllers\Development\reportesHershey::class, 'get_DataTable']);
});
