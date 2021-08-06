<?php

use App\Http\Controllers\Educacion\CensoController;
use App\Http\Controllers\Educacion\CuadroAsigPersonalController;
use App\Http\Controllers\Educacion\ImportacionController;
use App\Http\Controllers\Educacion\EceController;
use App\Http\Controllers\Educacion\IndicadorController;
use App\Http\Controllers\Educacion\PadronWebController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Parametro\ClasificadorController;
use App\Http\Controllers\Vivienda\DatassController;
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
Route::get('/home/{sistemas_id}', [HomeController::class, 'sistema_acceder'])->name('sistema_acceder');

Route::get('/AEI', [HomeController::class, 'AEI_tempo'])->name('AEI_tempo');

/**************************************** EDUCACION ************************************************/
Route::get('/PadronWeb/Importar', [PadronWebController::class, 'importar'])->name('PadronWeb.importar');
Route::post('/PadronWeb/Importar', [PadronWebController::class, 'guardar'])->name('PadronWeb.guardar');
Route::get('/PadronWeb/ListaImportada/{importacion_id}', [PadronWebController::class, 'ListaImportada'])->name('PadronWeb.PadronWeb_Lista');
Route::get('/PadronWeb/ListaImportada_DataTable/{importacion_id}', [PadronWebController::class, 'ListaImportada_DataTable'])->name('PadronWeb.ListaImportada_DataTable');
Route::get('/PadronWeb/Aprobar/{importacion_id}', [PadronWebController::class, 'aprobar'])->name('PadronWeb.aprobar');
Route::post('/PadronWeb/Aprobar/procesar/{importacion_id}', [PadronWebController::class, 'procesar'])->name('PadronWeb.procesar');

Route::get('/CuadroAsigPersonal/Importar', [CuadroAsigPersonalController::class, 'importar'])->name('CuadroAsigPersonal.importar');
Route::post('/CuadroAsigPersonal/Importar', [CuadroAsigPersonalController::class, 'guardar'])->name('CuadroAsigPersonal.guardar');
Route::get('/CuadroAsigPersonal/ListaImportada/{importacion_id}', [CuadroAsigPersonalController::class, 'ListaImportada'])->name('CuadroAsigPersonal.CuadroAsigPersonal_Lista');
Route::get('/CuadroAsigPersonal/ListaImportada_DataTable/{importacion_id}', [CuadroAsigPersonalController::class, 'ListaImportada_DataTable'])->name('CuadroAsigPersonal.ListaImportada_DataTable');
Route::get('/CuadroAsigPersonal/Aprobar/{importacion_id}', [CuadroAsigPersonalController::class, 'aprobar'])->name('CuadroAsigPersonal.aprobar');
Route::post('/CuadroAsigPersonal/Aprobar/procesar/{importacion_id}', [CuadroAsigPersonalController::class, 'procesar'])->name('CuadroAsigPersonal.procesar');

Route::get('/Censo/Importar', [CensoController::class, 'importar'])->name('Censo.importar');
Route::post('/Censo/Importar', [CensoController::class, 'guardar'])->name('Censo.guardar');
Route::get('/Censo/ListaImportada/{importacion_id}', [CensoController::class, 'ListaImportada'])->name('Censo.Censo_Lista');
Route::get('/Censo/ListaImportada_DataTable/{importacion_id}', [CensoController::class, 'ListaImportada_DataTable'])->name('Censo.ListaImportada_DataTable');
Route::get('/Censo/Aprobar/{importacion_id}', [CensoController::class, 'aprobar'])->name('Censo.aprobar');
Route::post('/Censo/Aprobar/procesar/{importacion_id}', [CensoController::class, 'procesar'])->name('Censo.procesar');


Route::get('/Importacion', [ImportacionController::class, 'inicio'])->name('importacion.inicio');
Route::get('/Importacion/importaciones_DataTable/', [ImportacionController::class, 'importacionesLista_DataTable'])->name('importacion.importacionesLista_DataTable');
Route::get('/Importacion/Eliminar/{id}', [ImportacionController::class, 'eliminar'])->name('importacion.Eliminar');

Route::get('/ECE/Importar', [EceController::class, 'importar'])->name('ece.importar');
Route::get('/ECE/Importar/Aprobar/{importacion_id}', [EceController::class, 'importarAprobar'])->name('ece.importar.aprobar');
Route::get('/ECE/Importar/Aprobar/Guardar/{importacion}', [EceController::class, 'importarAprobarGuardar'])->name('ece.importar.aprobar.guardar');
Route::post('/ECE/ImportarGuardar', [EceController::class, 'importarGuardar'])->name('ece.importar.store');
Route::post('/ECE/CargarGrados', [EceController::class, 'cargargrados'])->name('ece.ajax.cargargrados');


Route::get('/INDICADOR/Menu/{clasificador}', [IndicadorController::class, 'indicadorEducacionMenu'])->name('indicador.menu');
Route::get('/INDICADOR/ece1', [IndicadorController::class, 'indicadorEducacion1'])->name('indicador.1');
Route::get('/INDICADOR/ece2', [IndicadorController::class, 'indicadorEducacion2'])->name('indicador.2');
Route::get('/INDICADOR/ece3', [IndicadorController::class, 'indicadorEducacion3'])->name('indicador.3');
Route::get('/INDICADOR/ece4', [IndicadorController::class, 'indicadorEducacion4'])->name('ece.indicador.4');
Route::get('/INDICADOR/ece5', [IndicadorController::class, 'indicadorEducacion5'])->name('ece.indicador.5');
Route::get('/INDICADOR/ece6', [IndicadorController::class, 'indicadorEducacion6'])->name('ece.indicador.6');
Route::get('/INDICADOR/ece7', [IndicadorController::class, 'indicadorEducacion7'])->name('ece.indicador.7');
Route::get('/INDICADOR/ece8', [IndicadorController::class, 'indicadorEducacion8'])->name('indicador.8');
Route::get('/INDICADOR/ece9', [IndicadorController::class, 'indicadorEducacion9'])->name('indicador.9');
Route::get('/INDICADOR/ece10', [IndicadorController::class, 'indicadorEducacion10'])->name('indicador.10');
Route::get('/INDICADOR/ece11', [IndicadorController::class, 'indicadorEducacion11'])->name('indicador.11');
Route::get('/INDICADOR/ece12', [IndicadorController::class, 'indicadorEducacion12'])->name('indicador.12');
Route::get('/INDICADOR/ece13', [IndicadorController::class, 'indicadorEducacion13'])->name('indicador.13');
Route::get('/INDICADOR/pdrc1', [IndicadorController::class, 'indicadorPDRC1'])->name('pdrc.indicador.1');
Route::get('/INDICADOR/pdrc2', [IndicadorController::class, 'indicadorPDRC2'])->name('pdrc.indicador.2');
Route::get('/INDICADOR/pdrc3', [IndicadorController::class, 'indicadorPDRC3'])->name('pdrc.indicador.3');
Route::get('/INDICADOR/pdrc4', [IndicadorController::class, 'indicadorPDRC4'])->name('pdrc.indicador.4');
Route::get('/INDICADOR/obj1', [IndicadorController::class, 'indicadorOEI1'])->name('oei.indicador.1');
Route::get('/INDICADOR/obj2', [IndicadorController::class, 'indicadorOEI2'])->name('oei.indicador.2');
//Route::post('/ECE/Vista', [EceController::class, 'indicadorLOGROS'])->name('ece.indicador.vista');
Route::post('/INDICADOR/Satisfactorio', [IndicadorController::class, 'indicadorSatisfactorio'])->name('ind.ajax.satisfactorio');
Route::post('/INDICADOR/Materia', [IndicadorController::class, 'indicadorMateria'])->name('ind.ajax.materia');
Route::post('/INDICADOR/Ugel', [IndicadorController::class, 'indicadorUgel'])->name('ind.ajax.ugel');
Route::post('/INDICADOR/Derivados', [IndicadorController::class, 'indicadorDerivados'])->name('ind.ajax.derivados');
Route::post('/INDICADOR/Provincia', [IndicadorController::class, 'indicadorProvincia'])->name('ind.ajax.provincia');
Route::post('/INDICADOR/Distritos/{provincia}', [EceController::class, 'ind.ajax.cargardistritos'])
    ->name('indicador.cargardistritos');

Route::get('/INDICADOR/SINRUTA', function () {
    return 'Ruta no definida';
})->name('indicador.sinruta');

Route::get('/Clasificador/{clase_codigo}', [ClasificadorController::class, 'menu_porClase'])->name('Clasificador.menu');

/**************************************** FIN EDUCACION ************************************************/

/**************************************** VIVIENDA ************************************************/
Route::get('/Datass/Importar', [DatassController::class, 'importar'])->name('Datass.importar');
Route::post('/Datass/Importar', [DatassController::class, 'guardar'])->name('Datass.guardar');
Route::get('/Datass/ListaImportada/{importacion_id}', [DatassController::class, 'ListaImportada'])->name('Datass.Datass_Lista');
Route::get('/Datass/ListaImportada_DataTable/{importacion_id}', [DatassController::class, 'ListaImportada_DataTable'])->name('Datass.ListaImportada_DataTable');
Route::get('/Datass/Aprobar/{importacion_id}', [DatassController::class, 'aprobar'])->name('Datass.aprobar');
Route::post('/Datass/Aprobar/procesar/{importacion_id}', [DatassController::class, 'procesar'])->name('Datass.procesar');

/**************************************** FIN VIVIENDA ************************************************/