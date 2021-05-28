<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController AS home;
use App\Http\Controllers\Development\catalogos AS catalogos;
use App\Http\Controllers\Development\consultaCatalogos AS consultaCatalogos;
use App\Http\Controllers\Development\incidencias AS incidencias;
use App\Http\Controllers\Development\consultaIncidencias AS consultaIncidencias;
use App\Http\Controllers\Development\reportesHershey AS reportesHershey;

use App\Http\Controllers\Auth\logoutController AS logout;

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

// Auth::routes();

Auth::routes([
    'login'    => true,
    'logout'   => true,
    'register' => true,
    'reset'    => false,   // for resetting passwords
    'confirm'  => false,  // for additional password confirmations
    'verify'   => true,  // for email verification
]);

Route::group(['middleware'=>['auth']],function(){

    Route::get('/', [home::class, 'index'])->name('home');

    Route::get('/home/index', [home::class, 'index'])->name('home');

    Route::get('mainPage/index', function () {
        return view('Development/main/index');
    });

    // Rutas para acciones con catalogos
    Route::get('Catalogos/registros', [catalogos::class, 'index']);
    Route::get('Catalogos/modificar', [catalogos::class, 'modificar']);
    Route::get('Catalogos/modificar/getData', [catalogos::class, 'get_elements_modificar']);
    Route::get('Catalogos/consultas', [consultaCatalogos::class, 'index']);

    // Rutas para acciones con incidencias
    Route::get('TroubleShooting/registros', [incidencias::class, 'index']);
    Route::get('TroubleShooting/consultas', [consultaIncidencias::class, 'index']);

    /* Obtener informacion segun el elemento seleccionado */
    Route::post('Catalogos/getDataElement', [catalogos::class, 'getElements']);

    /* Guardar informacion sobre los catalogos */
    Route::post('Catalogos/storeCatalogos', [catalogos::class, 'store']);

    /* Guardar informacion a actualizar sobre los catalogos */
    Route::post('TroubleShooting/upadateCatalogos', [catalogos::class, 'update']);

    /* Obtener informacion de los catalogos para registra incidencias */
    Route::post('TroubleShooting/getDataSelects', [incidencias::class, 'getElements']);

    /* Guardar informacion sobre los catalogos */
    Route::post('TroubleShooting/storeIncidencias', [incidencias::class, 'store']);

    /** * Rutas Reportes Proyecto */
    Route::get('Reporte/reporte_general', [reportesHershey::class, 'reporte_general']);

    Route::post('Reporte/getDataReport/', [reportesHershey::class, 'get_data_reporte']);
    Route::post('Reporte/getDataTable/', [reportesHershey::class, 'get_DataTable']);

    /** Logout */
    Route::post('logout', [logout::class, 'logout']);
});
