<?php

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
Route::get('/xxx', [App\Http\Controllers\HomeController::class, 'index'])->name('xxx');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/PadronWeb/Importar',[App\Http\Controllers\Educacion\PadronWebController::class, 'importar'])->name('PadronWeb.importar');
Route::post('/PadronWeb/Importar',[App\Http\Controllers\Educacion\PadronWebController::class, 'guardar'])->name('PadronWeb.guardar');

Route::get('/PadronWeb/ListaImportada/{importacion_id}',[App\Http\Controllers\Educacion\PadronWebController::class, 'ListaImportada'])->name('PadronWeb.PadronWeb_Lista');
Route::get('/PadronWeb/ListaImportada_DataTable/{importacion_id}',[App\Http\Controllers\Educacion\PadronWebController::class, 'ListaImportada_DataTable'])->name('PadronWeb.ListaImportada_DataTable');
Route::get('/PadronWeb/Aprobar/{importacion_id}',[App\Http\Controllers\Educacion\PadronWebController::class, 'aprobar'])->name('PadronWeb.aprobar');
Route::post('/PadronWeb/Aprobar/procesar/{importacion_id}',[App\Http\Controllers\Educacion\PadronWebController::class, 'procesar'])->name('PadronWeb.procesar');


Route::get('/Importacion',[App\Http\Controllers\Educacion\ImportacionController::class, 'inicio'])->name('importacion.inicio');
Route::get('/Importacion/importaciones_DataTable/',[App\Http\Controllers\Educacion\ImportacionController::class, 'importacionesLista_DataTable'])->name('importacion.importacionesLista_DataTable');
Route::get('/Importacion/Eliminar/{id}',[App\Http\Controllers\Educacion\ImportacionController::class, 'eliminar'])->name('importacion.Eliminar');