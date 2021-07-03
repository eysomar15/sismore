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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/PadronWeb/Importar',[App\Http\Controllers\Educacion\PadronWebController::class, 'importar'])->name('PadronWeb.importar');
Route::post('/PadronWeb/Importar',[App\Http\Controllers\Educacion\PadronWebController::class, 'guardar'])->name('PadronWeb.guardar');