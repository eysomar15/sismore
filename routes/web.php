<?php

use App\Http\Controllers\Educacion\CensoController;
use App\Http\Controllers\Educacion\CuadroAsigPersonalController;
use App\Http\Controllers\Educacion\ImportacionController;
use App\Http\Controllers\Educacion\EceController;
use App\Http\Controllers\Educacion\IndicadorController;
use App\Http\Controllers\Educacion\MatriculaController;
use App\Http\Controllers\Educacion\PadronWebController;
use App\Http\Controllers\Educacion\TabletaController;
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

Route::get('/CuadroAsigPersonal/Docentes', [CuadroAsigPersonalController::class, 'Principal'])->name('CuadroAsigPersonal.principal');
Route::post('/CuadroAsigPersonal/ReporteUgel', [CuadroAsigPersonalController::class, 'ReporteUgel'])->name('CuadroAsigPersonal.ReporteUgel');
Route::post('/CuadroAsigPersonal/ReporteDistrito', [CuadroAsigPersonalController::class, 'ReporteDistrito'])->name('CuadroAsigPersonal.ReporteDistrito');
Route::get('/CuadroAsigPersonal/ReportePedagogico', [CuadroAsigPersonalController::class, 'ReportePedagogico'])->name('CuadroAsigPersonal.ReportePedagogico');
Route::get('/CuadroAsigPersonal/ReporteBilingues', [CuadroAsigPersonalController::class, 'ReporteBilingues'])->name('CuadroAsigPersonal.Bilingues');

Route::get('/Censo/Importar', [CensoController::class, 'importar'])->name('Censo.importar');
Route::post('/Censo/Importar', [CensoController::class, 'guardar'])->name('Censo.guardar');
Route::get('/Censo/ListaImportada/{importacion_id}', [CensoController::class, 'ListaImportada'])->name('Censo.Censo_Lista');
Route::get('/Censo/ListaImportada_DataTable/{importacion_id}', [CensoController::class, 'ListaImportada_DataTable'])->name('Censo.ListaImportada_DataTable');
Route::get('/Censo/Aprobar/{importacion_id}', [CensoController::class, 'aprobar'])->name('Censo.aprobar');
Route::post('/Censo/Aprobar/procesar/{importacion_id}', [CensoController::class, 'procesar'])->name('Censo.procesar');

Route::get('/Matricula/Importar', [MatriculaController::class, 'importar'])->name('Matricula.importar');
Route::post('/Matricula/Importar', [MatriculaController::class, 'guardar'])->name('Matricula.guardar');
Route::get('/Matricula/ListaImportada/{importacion_id}', [MatriculaController::class, 'ListaImportada'])->name('Matricula.Matricula_Lista');
Route::get('/Matricula/Aprobar/{importacion_id}', [MatriculaController::class, 'aprobar'])->name('Matricula.aprobar');
Route::post('/Matricula/Aprobar/procesar/{importacion_id}', [MatriculaController::class, 'procesar'])->name('Matricula.procesar');

Route::get('/Matricula/Principal', [MatriculaController::class, 'principal'])->name('Matricula.principal');
Route::post('/Matricula/ReporteUgel/{anio_id}/{matricula_id}', [MatriculaController::class, 'ReporteUgel'])->name('Matricula.ReporteUgel');
Route::post('/Matricula/ReporteDistrito/{anio_id}/{matricula_id}', [MatriculaController::class, 'ReporteDistrito'])->name('Matricula.ReporteDistrito');

Route::post('/Matricula/Fechas/{anio_id}', [MatriculaController::class, 'Fechas'])->name('Matricula.Fechas');


Route::get('/Tableta/Importar', [TabletaController::class, 'importar'])->name('Tableta.importar');
Route::post('/Tableta/Importar',[TabletaController::class, 'guardar'])->name('Tableta.guardar');
Route::get('/Tableta/Aprobar/{importacion_id}', [TabletaController::class, 'aprobar'])->name('Tableta.aprobar');
Route::post('/Tableta/Aprobar/procesar/{importacion_id}', [TabletaController::class, 'procesar'])->name('Tableta.procesar');

Route::get('/Tableta/Principal',[TabletaController::class, 'principal'])->name('Tableta.principal');
Route::post('/Tableta/Fechas/{anio_id}', [TabletaController::class, 'Fechas'])->name('Tableta.Fechas');
Route::post('/Tableta/ReporteUgel/{anio_id}/{tableta_id}', [TabletaController::class, 'ReporteUgel'])->name('Tableta.ReporteUgel');


Route::get('/Importacion', [ImportacionController::class, 'inicio'])->name('importacion.inicio');
Route::get('/Importacion/importaciones_DataTable/', [ImportacionController::class, 'importacionesLista_DataTable'])->name('importacion.importacionesLista_DataTable');
Route::get('/Importacion/Eliminar/{id}', [ImportacionController::class, 'eliminar'])->name('importacion.Eliminar');

Route::get('/ECE/Importar', [EceController::class, 'importar'])->name('ece.importar');
Route::get('/ECE/Importar/Aprobar/{importacion_id}', [EceController::class, 'importarAprobar'])->name('ece.importar.aprobar');
Route::get('/ECE/Importar/Aprobar/Guardar/{importacion}', [EceController::class, 'importarAprobarGuardar'])->name('ece.importar.aprobar.guardar');
Route::post('/ECE/ImportarGuardar', [EceController::class, 'importarGuardar'])->name('ece.importar.store');
Route::get('/ECE/Listar/ImportarDT', [EceController::class, 'ListarEceImportadosDT'])->name('ece.listar.importados');
Route::get('/ECE/Eliminar/ImportarDT/{id}', [EceController::class, 'EliminarImportados']);
Route::post('/ECE/CargarGrados', [EceController::class, 'cargargrados'])->name('ece.ajax.cargargrados');
Route::get('/INDICADOR/Menu/{clasificador}', [IndicadorController::class, 'indicadorEducacionMenu'])->name('indicador.menu');
Route::get('/Clasificador/{clase_codigo}', [ClasificadorController::class, 'menu_porClase'])->name('Clasificador.menu');

Route::get('/INDICADOR/ece/{indicador}', [IndicadorController::class, 'indicadorEducacion'])->name('indicador.01');
Route::get('/INDICADOR/drvcs/{indicador}', [IndicadorController::class, 'indicadorDRVCS'])->name('indicador.02');
Route::get('/INDICADOR/pdrc/{indicador}', [IndicadorController::class, 'indicadorPDRC'])->name('indicador.04');
Route::get('/INDICADOR/obj/{indicador}', [IndicadorController::class, 'indicadorOEI'])->name('indicador.05');

Route::get('/INDICADOR/dece/{indicador_id}/{grado}/{tipo}/{materia}', [IndicadorController::class, 'indDetEdu'])->name('ind.det.edu');
Route::get('/INDICADOR/rece/{indicador_id}/{grado}/{tipo}/{materia}', [IndicadorController::class, 'indResEdu'])->name('ind.res.edu');

Route::post('/INDICADOR/Satisfactorio', [IndicadorController::class, 'reporteSatisfactorioMateria'])->name('ind.ajax.satisfactorio');
Route::post('/INDICADOR/Ugel', [IndicadorController::class, 'indicadorUgelMateria'])->name('ind.ajax.ugel');
Route::post('/INDICADOR/Materia', [IndicadorController::class, 'indicadorMateria'])->name('ind.ajax.materia');
Route::post('/INDICADOR/ReporteUbigeoAjax', [IndicadorController::class, 'reporteUbigeoAjax'])->name('ind.ajax.reporteubigeo');
Route::get('/INDICADOR/ReporteGestionAreaDT/{anio}/{grado}/{tipo}/{materia}/{gestion}/{area}', [IndicadorController::class, 'reporteGestionAreaDT']);
Route::post('/INDICADOR/Provincia', [IndicadorController::class, 'indicadorProvincia'])->name('ind.ajax.provincia');
Route::post('/INDICADOR/Distritos/{provincia}', [IndicadorController::class, 'cargardistritos'])->name('ind.ajax.cargardistritos');
Route::post('/INDICADOR/PNSR1/{provincia}/{distrito}/{indicador_id}/{fecha}', [IndicadorController::class, 'indicadorvivpnsrcab'])->name('ind.ajax.pnsr1');
Route::post('/INDICADOR/ece5/{provincia}/{distrito}/{indicador_id}/{anio_id}', [IndicadorController::class, 'ajaxEdu5v1'])->name('ind.ajax.edu5.1');
Route::post('/INDICADOR/ece6/{provincia}/{distrito}/{indicador_id}/{anio_id}', [IndicadorController::class, 'ajaxEdu6v1'])->name('ind.ajax.edu6.1');


Route::get('/INDICADOR/SINRUTA', function () {
    return 'Ruta no definida';
})->name('indicador.sinruta');
/**************************************** FIN EDUCACION ************************************************/

/**************************************** VIVIENDA ************************************************/
Route::get('/Datass/Importar', [DatassController::class, 'importar'])->name('Datass.importar');
Route::post('/Datass/Importar', [DatassController::class, 'guardar'])->name('Datass.guardar');
Route::get('/Datass/ListaImportada/{importacion_id}', [DatassController::class, 'ListaImportada'])->name('Datass.Datass_Lista');
Route::get('/Datass/ListaImportada_DataTable/{importacion_id}', [DatassController::class, 'ListaImportada_DataTable'])->name('Datass.ListaImportada_DataTable');
Route::get('/Datass/Aprobar/{importacion_id}', [DatassController::class, 'aprobar'])->name('Datass.aprobar');
Route::post('/Datass/Aprobar/procesar/{importacion_id}', [DatassController::class, 'procesar'])->name('Datass.procesar');

/**************************************** FIN VIVIENDA ************************************************/