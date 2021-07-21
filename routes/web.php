<?php

use App\Http\Controllers\Educacion\CuadroAsigPersonalController;
use App\Http\Controllers\Educacion\ImportacionController;
use App\Http\Controllers\Educacion\EceController;
use App\Http\Controllers\Educacion\PadronWebController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/PadronWeb/Importar',[PadronWebController::class, 'importar'])->name('PadronWeb.importar');
Route::post('/PadronWeb/Importar',[PadronWebController::class, 'guardar'])->name('PadronWeb.guardar');
Route::get('/PadronWeb/ListaImportada/{importacion_id}',[PadronWebController::class, 'ListaImportada'])->name('PadronWeb.PadronWeb_Lista');
Route::get('/PadronWeb/ListaImportada_DataTable/{importacion_id}',[PadronWebController::class, 'ListaImportada_DataTable'])->name('PadronWeb.ListaImportada_DataTable');
Route::get('/PadronWeb/Aprobar/{importacion_id}',[PadronWebController::class, 'aprobar'])->name('PadronWeb.aprobar');
Route::post('/PadronWeb/Aprobar/procesar/{importacion_id}',[PadronWebController::class, 'procesar'])->name('PadronWeb.procesar');

Route::get('/CuadroAsigPersonal/Importar',[CuadroAsigPersonalController::class, 'importar'])->name('CuadroAsigPersonal.importar');
Route::post('/CuadroAsigPersonal/Importar',[CuadroAsigPersonalController::class, 'guardar'])->name('CuadroAsigPersonal.guardar');

Route::get('/Importacion',[ImportacionController::class, 'inicio'])->name('importacion.inicio');
Route::get('/Importacion/importaciones_DataTable/',[ImportacionController::class, 'importacionesLista_DataTable'])->name('importacion.importacionesLista_DataTable');
Route::get('/Importacion/Eliminar/{id}',[ImportacionController::class, 'eliminar'])->name('importacion.Eliminar');

Route::get('/ECE/Importar',[EceController::class, 'importar'])->name('ece.importar');
Route::get('/ECE/Importar/Menu',[EceController::class, 'importarMenu'])->name('ece.importar.menu');
Route::get('/ECE/Importar/Aprobar/{importacion_id}',[EceController::class, 'importarAprobar'])->name('ece.importar.aprobar');
Route::get('/ECE/Importar/Aprobar/Guardar/{importacion}',[EceController::class, 'importarAprobarGuardar'])
->name('ece.importar.aprobar.guardar');
Route::post('/ECE/ImportarGuardar',[EceController::class, 'importarGuardar'])->name('ece.importar.store');
Route::get('/ECE/Indicador1',[EceController::class, 'indicador1'])->name('ece.indicador.1');
Route::get('/ECE/Indicador4',[EceController::class, 'indicador4'])->name('ece.indicador.4');
Route::get('/ECE/Indicador5',[EceController::class, 'indicador5'])->name('ece.indicador.5');
Route::get('/ECE/Indicador6',[EceController::class, 'indicador6'])->name('ece.indicador.6');
Route::get('/ECE/Indicador7',[EceController::class, 'indicador7'])->name('ece.indicador.7');
Route::post('/ECE/IndicadorVista',[EceController::class, 'indicadorLOGROS'])->name('ece.indicador.vista');
Route::post('/ECE/IndicadorDistritos/{provincia}',[EceController::class, 'cargardistritos'])
->name('ece.indicador.cargardistritos');
Route::post('/ECE/IndicadorGrados',[EceController::class, 'cargargrados'])->name('ece.indicador.cargargrados');