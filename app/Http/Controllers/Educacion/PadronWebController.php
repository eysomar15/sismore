<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;

use App\Models\Educacion\NivelModalidad;
use App\Models\Educacion\Forma;
use App\Models\Educacion\Caracteristica;
use App\Models\Educacion\Genero;
use App\Models\Educacion\TipoGestion;
use App\Models\Educacion\TipoPrograma;
use App\Models\Ubigeo;
use App\Models\Educacion\CentroPoblado;
use App\Models\Educacion\EstadoInsEdu;
use App\Models\Educacion\Ugel;
use App\Models\Educacion\Area;
use App\Models\Educacion\Importacion;
use App\Models\Educacion\Turno;
use App\Models\Educacion\PadronWeb;
use App\Models\Educacion\InstitucionEducativa;
use App\Repositories\Educacion\PadronWebRepositorio;
use App\Utilities\Utilitario;
use Carbon\Carbon;
use App\Repositories\Educacion\ImportacionRepositorio;

use Illuminate\Http\Request;

class PadronWebController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {  
        return view('Educacion.PadronWeb.Importar');
    }  

    // public function guardar(Request $request)
    // { 
    //     $file = $request->file('file');        
    //     $lines = file($file);
    //     $utf8_lines = array_map('utf8_encode',$lines);            
    //     $array = array_map('str_getcsv',$utf8_lines);
    //     return redirect()->route('PadronWeb.PadronWeb_Lista',55);
    // }
  
    public function guardar(Request $request)
    {      
        $this->validate($request,['file' => 'required|mimes:csv']);
      
        $file = $request->file('file');        
        $lines = file($file);
        $utf8_lines = array_map('utf8_encode',$lines);            
        $array = array_map('str_getcsv',$utf8_lines);

        $importacion = Importacion::Create([
            'fuenteImportacion_id'=>1, // valor predeterminado
            'usuarioId_Crea'=> auth()->user()->id,
            'usuarioId_Aprueba'=>null,
            'fechaActualizacion'=>$request['fechaActualizacion'],
            'comentario'=>$request['comentario'],
            'estado'=>'PE'
        ]);   

        for($i=1; $i<sizeof($array); ++$i)
        {           
            $padronWeb = PadronWeb::Create([
                'importacion_id'=>$importacion->id,
                'cod_Mod'=>$array[$i][0],
                'anexo'=>$array[$i][1],
                'cod_Local'=>$array[$i][2],
                'cen_Edu'=>$array[$i][3],
                'niv_Mod'=>$array[$i][4],
                'd_Niv_Mod'=>$array[$i][5],
                'd_Forma'=>$array[$i][6],
                'cod_Car'=>$array[$i][7],
                'd_Cod_Car'=>$array[$i][8],
                'TipsSexo'=>$array[$i][9],
                'd_TipsSexo'=>$array[$i][10],
                'gestion'=>$array[$i][11],
                'd_Gestion'=>$array[$i][12],
                'ges_Dep'=>$array[$i][13],
                'd_Ges_Dep'=>$array[$i][14],
                'director'=>$array[$i][15],
                'telefono'=>$array[$i][16],
                'email'=>$array[$i][17],
                'pagWeb'=>$array[$i][18],
                'dir_Cen'=>$array[$i][19],
                'referencia'=>$array[$i][20],
                'localidad'=>$array[$i][21],
                'codcp_Inei'=>$array[$i][22],
                'codccpp'=>$array[$i][23],
                'cen_Pob'=>$array[$i][24],
                'area_Censo'=>$array[$i][25],
                'd_areaCenso'=>$array[$i][26],
                'codGeo'=>$array[$i][27],
                'd_Dpto'=>$array[$i][28],
                'd_Prov'=>$array[$i][29],
                'd_Dist'=>$array[$i][30],
                'd_Region'=>$array[$i][31],
                'codOOII'=>$array[$i][32],
                'd_DreUgel'=>$array[$i][33],
                'nLat_IE'=>1,
                'nLong_IE'=>2,
                'tipoProg'=>$array[$i][36],
                'd_TipoProg'=>$array[$i][37],
                'cod_Tur'=>$array[$i][38],
                'D_Cod_Tur'=>$array[$i][39],
                'estado'=>$array[$i][40],
                'd_Estado'=>$array[$i][41],
                'd_Fte_Dato'=>$array[$i][42],
                'tAlum_Hom'=>$array[$i][43],
                'tAlum_Muj'=>$array[$i][44],
                'tAlumno'=>$array[$i][45],
                'tDocente'=>$array[$i][46],
                'tSeccion'=>$array[$i][47],
                'fechaReg'=>null,
                'fecha_Act'=>Utilitario::Fecha_ConFormato_DMY($array[$i][49]),
            ]);    
        }

        return redirect()->route('PadronWeb.PadronWeb_Lista',$importacion->id);
        //$importacion_id = $importacion->id;
        //return view('ImportarEducacion.PadronWebLista_importada',compact('importacion_id'));  
    }

    public function ListaImportada($importacion_id)
    {
        //$padronWebLista = PadronWeb::all();                
        //return view('ImportarEducacion.PadronWebList',compact('padronWebLista'));

        return view('Educacion.PadronWeb.ListaImportada',compact('importacion_id'));
    }

    public function ListaImportada_DataTable($importacion_id)
    {
        $padronWebLista = PadronWebRepositorio::Listar_Por_Importacion_id($importacion_id);
                
        return  datatables()->of($padronWebLista)->toJson();;
    }

    public function aprobar($importacion_id)
    {
        $importacion = ImportacionRepositorio::ImportacionPor_Id($importacion_id);
        //Importacion::where('id',$importacion_id)->first();  

        return view('educacion.PadronWeb.Aprobar',compact('importacion_id','importacion'));
    }  

    public function procesar($importacion_id)
    {
        $ListaPadronWeb = PadronWebRepositorio::Listar_Por_Importacion_id($importacion_id);  
        $dato=0;
   
        foreach ($ListaPadronWeb as $padronWeb)
        {            
            $nivelModalidad = NivelModalidad::where('codigo',$padronWeb->niv_Mod)->first();
            if($nivelModalidad==null){
                $nivelModalidad = NivelModalidad::firstOrCreate([
                    'codigo'=>$padronWeb->niv_Mod,
                    'nombre'=>$padronWeb->d_Niv_Mod
                ]);            
            } 
            else
            {
                $nivelModalidad->nombre = $padronWeb->d_Niv_Mod;
                $nivelModalidad->updated_at = Carbon::now();
                $nivelModalidad->save();
            }   
            
            $forma = Forma::where('nombre',$padronWeb->d_Forma)->first();
            if($forma==null){
                $forma = Forma::firstOrCreate([
                    'nombre'=>$padronWeb->d_Forma
                ]);            
            } 
            else
            {
                $forma->nombre = $padronWeb->d_Forma;
                $forma->updated_at = Carbon::now();
                $forma->save();
            }

            $caracteristica = Caracteristica::where('codigo',$padronWeb->cod_Car)->first();
            if($caracteristica==null){
                $caracteristica = Caracteristica::firstOrCreate([
                    'codigo'=>$padronWeb->cod_Car,
                    'nombre'=>$padronWeb->d_Cod_Car
                ]);            
            } 
            else
            {
                $caracteristica->nombre = $padronWeb->d_Cod_Car;
                $caracteristica->updated_at = Carbon::now();
                $caracteristica->save();
            }

            $genero = Genero::where('codigo',$padronWeb->TipsSexo)->first();
            if($genero==null){
                $genero = Genero::firstOrCreate([
                    'codigo'=>$padronWeb->TipsSexo,
                    'nombre'=>$padronWeb->d_TipsSexo
                ]);            
            } 
            else
            {
                $genero->nombre = $padronWeb->d_TipsSexo;
                $genero->updated_at = Carbon::now();
                $genero->save();
            }

            //cabecera tipo gestion
            $tipoGestion = TipoGestion::where('codigo',$padronWeb->gestion)->first();
            if($tipoGestion==null){
                $tipoGestion = TipoGestion::firstOrCreate([
                    'codigo'=>$padronWeb->gestion,
                    'nombre'=>$padronWeb->d_Gestion
                ]);            
            } 
            else
            {
                $tipoGestion->nombre = $padronWeb->d_Gestion;
                $tipoGestion->updated_at = Carbon::now();
                $tipoGestion->save();
            }

            //detalle tipo gestion
            $tipoGestionDet = TipoGestion::where('codigo',$padronWeb->ges_Dep)->first();
            if($tipoGestionDet==null){
                $tipoGestionDet = TipoGestion::firstOrCreate([
                    'codigo'=>$padronWeb->ges_Dep,
                    'nombre'=>$padronWeb->d_Ges_Dep,
                    'dependencia'=> $tipoGestion->id
                ]);            
            } 
            else
            {
                $tipoGestionDet->nombre = $padronWeb->d_Ges_Dep;
                $tipoGestionDet->updated_at = Carbon::now();
                $tipoGestionDet->dependencia = $tipoGestion->id;
                $tipoGestionDet->save();
            }

            $tipoPrograma = TipoPrograma::where('codigo',$padronWeb->tipoPro)->first();
            if($tipoPrograma==null){
                $tipoPrograma = TipoPrograma::firstOrCreate([
                    'codigo'=>$padronWeb->tipoPro,
                    'nombre'=>$padronWeb->d_TipoProg
                ]);            
            } 
            else
            {
                $tipoPrograma->nombre = $padronWeb->d_TipoProg;
                $tipoPrograma->updated_at = Carbon::now();
                $tipoPrograma->save();
            }

            //primer nivel Ubigeo
            $ubigeo = Ubigeo::where('codigo',substr($padronWeb->codGeo,0,2))->first();
            if($ubigeo==null){
                $ubigeo = Ubigeo::firstOrCreate([
                    'codigo'=>substr($padronWeb->codGeo,0,2),
                    'nombre'=>$padronWeb->d_Dpto
                ]);            
            } 
            else
            {
                $ubigeo->nombre = $padronWeb->d_Dpto;
                $ubigeo->updated_at = Carbon::now();
                $ubigeo->save();
            }

            //segundo nivel ubigeo
            $ubigeoB = Ubigeo::where('codigo',substr($padronWeb->codGeo,0,4))->first();
            if($ubigeoB==null){
                $ubigeoB = Ubigeo::firstOrCreate([
                    'codigo'=>substr($padronWeb->codGeo,0,4),
                    'nombre'=>$padronWeb->d_Prov,
                    'dependencia'=> $ubigeo->id
                ]);            
            } 
            else
            {
                $ubigeoB->nombre = $padronWeb->d_Prov;
                $ubigeoB->updated_at = Carbon::now();
                $ubigeoB->dependencia = $ubigeo->id;
                $ubigeoB->save();
            }

            //tercer nivel ubigeo
            $ubigeoC = Ubigeo::where('codigo',substr($padronWeb->codGeo,0,6))->first();
            if($ubigeoC==null){
                $ubigeoC = Ubigeo::firstOrCreate([
                    'codigo'=>substr($padronWeb->codGeo,0,6),
                    'nombre'=>$padronWeb->d_Dist,
                    'dependencia'=> $ubigeoB->id
                ]);            
            } 
            else
            {
                $ubigeoC->nombre = $padronWeb->d_Dist;
                $ubigeoC->updated_at = Carbon::now();
                $ubigeoC->dependencia = $ubigeoB->id;
                $ubigeoC->save();
            }

            $centroPoblado = CentroPoblado::where('nombre',$padronWeb->cen_Pob)->first();
            if($centroPoblado==null){
                $centroPoblado = CentroPoblado::firstOrCreate([  
                    'codINEI'=>$padronWeb->codcp_Inei,
                    'codUEMinedu'=>$padronWeb->codccpp,                       
                    'nombre'=>$padronWeb->cen_Pob,
                    'Ubigeo_id'=> $ubigeoC->id
                ]);            
            } 
            else
            {
                $centroPoblado->codINEI = $padronWeb->codcp_Inei;
                $centroPoblado->codUEMinedu = $padronWeb->codccpp;
                $centroPoblado->nombre = $padronWeb->cen_Pob;
                $centroPoblado->updated_at = Carbon::now();
                $centroPoblado->Ubigeo_id = $ubigeoC->id;
                $centroPoblado->save();
            }

            $estadoInsEdu = EstadoInsEdu::where('codigo',$padronWeb->estado)->first();
            if($estadoInsEdu==null){
                $estadoInsEdu = EstadoInsEdu::firstOrCreate([
                    'codigo'=>$padronWeb->estado,
                    'nombre'=>$padronWeb->d_Estado
                ]);            
            } 
            else
            {
                $estadoInsEdu->nombre = $padronWeb->d_Estado;
                $estadoInsEdu->updated_at = Carbon::now();
                $estadoInsEdu->save();
            }                

            $ugel = Ugel::where('codigo',$padronWeb->codOOII)->first();
            if($ugel==null){
                $ugel = Ugel::firstOrCreate([
                    'codigo'=>$padronWeb->codOOII,
                    'nombre'=>$padronWeb->d_DreUgel
                ]);            
            } 
            else
            {
                $ugel->nombre = $padronWeb->d_DreUgel;
                $ugel->updated_at = Carbon::now();
                $ugel->save();
            }

            $area = Area::where('codigo',$padronWeb->area_Censo)->first();
            if($area==null){
                $area = Area::firstOrCreate([
                    'codigo'=>$padronWeb->area_Censo,
                    'nombre'=>$padronWeb->d_areaCenso
                ]);            
            } 
            else
            {
                $area->nombre = $padronWeb->d_areaCenso;
                $area->updated_at = Carbon::now();
                $area->save();
            }

            $turno = Turno::where('codigo',$padronWeb->cod_Tur)->first();
            if($turno==null){
                $turno = Turno::firstOrCreate([
                    'codigo'=>$padronWeb->cod_Tur,
                    'nombre'=>$padronWeb->D_Cod_Tur
                ]);            
            } 
            else
            {
                $turno->nombre = $padronWeb->D_Cod_Tur;
                $turno->updated_at = Carbon::now();
                $turno->save();
            }

            $institucionEducativa = InstitucionEducativa::
                where(
                    [
                    ['codModular',$padronWeb->cod_Mod],
                    ['anexo',$padronWeb->anexo]
                    ]
                )->first();               

                if($institucionEducativa==null){
                    $institucionEducativa = InstitucionEducativa::firstOrCreate([
                        'NivelModalidad_id'=>$nivelModalidad->id,
                        'Forma_id'=>$forma->id,
                        'Caracteristica_id'=>$caracteristica->id,
                        'Genero_id'=>$genero->id,
                        'TipoGestion_id'=>$tipoGestion->id,
                        'TipoPrograma_id'=>$tipoPrograma->id,
                        'Ugel_id'=>$ugel->id,
                        'Area_id'=>$area->id,
                        'EstadoInsEdu_id'=>$estadoInsEdu->id,
                        'Turno_id'=>$turno->id,
                        'CentroPoblado_id'=>$centroPoblado->id,
                        'codModular'=>$padronWeb->cod_Mod,
                        'anexo'=>$padronWeb->anexo,
                        'codLocal'=>$padronWeb->cod_Local,
                        'nombreInstEduc'=>$padronWeb->cen_Edu,
                        'nombreDirector'=>$padronWeb->director,
                        'telefono'=>$padronWeb->telefono,
                        'email'=>$padronWeb->email,
                        'paginaWeb'=>$padronWeb->pagWeb,
                        'direccion'=>$padronWeb->dir_Cen,
                        'referencia'=>$padronWeb->referencia,
                        'coorGeoLatitud'=>1,//$padronWeb->[34],
                        'coordGeoLongitud'=>2,//$padronWeb->[35],
                        'fechaReg'=>Carbon::now(),//$padronWeb->[48],
                        'fechaAct'=>Carbon::now(),//$padronWeb->[49],                        
                    ]);            
                } 
                else
                {    
                    $institucionEducativa->NivelModalidad_id = $nivelModalidad->id;
                    $institucionEducativa->Forma_id = $forma->id;
                    $institucionEducativa->Caracteristica_id = $caracteristica->id;
                    $institucionEducativa->Genero_id = $genero->id;
                    $institucionEducativa->TipoGestion_id = $tipoGestion->id;
                    $institucionEducativa->TipoPrograma_id = $tipoPrograma->id;
                    $institucionEducativa->Ugel_id = $ugel->id;
                    $institucionEducativa->Area_id = $area->id;
                    $institucionEducativa->EstadoInsEdu_id = $estadoInsEdu->id;
                    $institucionEducativa->Turno_id = $turno->id;
                    $institucionEducativa->CentroPoblado_id = $centroPoblado->id;
                                                        
                    //$institucionEducativa->codModular = $padronWeb->[0];
                    $institucionEducativa->anexo = $padronWeb->anexo;
                    $institucionEducativa->codLocal = $padronWeb->cod_Local;
                    $institucionEducativa->nombreInstEduc = $padronWeb->cen_Edu;
                    $institucionEducativa->nombreDirector = $padronWeb->director;
                    $institucionEducativa->telefono = $padronWeb->telefono;
                    $institucionEducativa->email = $padronWeb->email;
                    $institucionEducativa->paginaWeb = $padronWeb->pagWeb;
                    $institucionEducativa->direccion = $padronWeb->dir_Cen;
                    $institucionEducativa->referencia = $padronWeb->referencia;
                    $institucionEducativa->coorGeoLatitud = 1;// $padronWeb->[34];
                    $institucionEducativa->coordGeoLongitud = 2;//$padronWeb->[35];
                    $institucionEducativa->fechaReg =Carbon::now();// $padronWeb->[48];
                    $institucionEducativa->fechaAct =Carbon::now();// $padronWeb->[49];

                    $institucionEducativa->updated_at = Carbon::now();
                    $institucionEducativa->save();
                }

        }      

        return  $dato;
    }  

    public function importarPadronWeb_ProcesarB(Request $request)
    {      
        $this->validate($request,['file' => 'required|mimes:csv']);
      
        $file = $request->file('file');        
        $lines = file($file);
        $utf8_lines = array_map('utf8_encode',$lines);
        
        $ids = ",";
        $array = array_map('str_getcsv',$utf8_lines);

        for($i=1; $i<sizeof($array); ++$i)
        {
            // if($array[$i][32]!='250000')//para que no registre INSTITUOS de la dreu ucayali
            // {
                $nivelModalidad = NivelModalidad::where('codigo',$array[$i][4])->first();
                if($nivelModalidad==null){
                    $nivelModalidad = NivelModalidad::firstOrCreate([
                        'codigo'=>$array[$i][4],
                        'nombre'=>$array[$i][5]
                    ]);            
                } 
                else
                {
                    $nivelModalidad->nombre = $array[$i][5];
                    $nivelModalidad->updated_at = Carbon::now();
                    $nivelModalidad->save();
                }   
                
                $forma = Forma::where('nombre',$array[$i][6])->first();
                if($forma==null){
                    $forma = Forma::firstOrCreate([
                        'nombre'=>$array[$i][6]
                    ]);            
                } 
                else
                {
                    $forma->nombre = $array[$i][6];
                    $forma->updated_at = Carbon::now();
                    $forma->save();
                }

                $caracteristica = Caracteristica::where('codigo',$array[$i][7])->first();
                if($caracteristica==null){
                    $caracteristica = Caracteristica::firstOrCreate([
                        'codigo'=>$array[$i][7],
                        'nombre'=>$array[$i][8]
                    ]);            
                } 
                else
                {
                    $caracteristica->nombre = $array[$i][8];
                    $caracteristica->updated_at = Carbon::now();
                    $caracteristica->save();
                }

                $genero = Genero::where('codigo',$array[$i][9])->first();
                if($genero==null){
                    $genero = Genero::firstOrCreate([
                        'codigo'=>$array[$i][9],
                        'nombre'=>$array[$i][10]
                    ]);            
                } 
                else
                {
                    $genero->nombre = $array[$i][10];
                    $genero->updated_at = Carbon::now();
                    $genero->save();
                }

                //cabecera tipo gestion
                $tipoGestion = TipoGestion::where('codigo',$array[$i][11])->first();
                if($tipoGestion==null){
                    $tipoGestion = TipoGestion::firstOrCreate([
                        'codigo'=>$array[$i][11],
                        'nombre'=>$array[$i][12]
                    ]);            
                } 
                else
                {
                    $tipoGestion->nombre = $array[$i][12];
                    $tipoGestion->updated_at = Carbon::now();
                    $tipoGestion->save();
                }

                //detalle tipo gestion
                $tipoGestionDet = TipoGestion::where('codigo',$array[$i][13])->first();
                if($tipoGestionDet==null){
                    $tipoGestionDet = TipoGestion::firstOrCreate([
                        'codigo'=>$array[$i][13],
                        'nombre'=>$array[$i][14],
                        'dependencia'=> $tipoGestion->id
                    ]);            
                } 
                else
                {
                    $tipoGestionDet->nombre = $array[$i][14];
                    $tipoGestionDet->updated_at = Carbon::now();
                    $tipoGestionDet->dependencia = $tipoGestion->id;
                    $tipoGestionDet->save();
                }

                $tipoPrograma = TipoPrograma::where('codigo',$array[$i][36])->first();
                if($tipoPrograma==null){
                    $tipoPrograma = TipoPrograma::firstOrCreate([
                        'codigo'=>$array[$i][36],
                        'nombre'=>$array[$i][37]
                    ]);            
                } 
                else
                {
                    $tipoPrograma->nombre = $array[$i][37];
                    $tipoPrograma->updated_at = Carbon::now();
                    $tipoPrograma->save();
                }

                //primer nivel Ubigeo
                $ubigeo = Ubigeo::where('codigo',substr($array[$i][27],0,2))->first();
                if($ubigeo==null){
                    $ubigeo = Ubigeo::firstOrCreate([
                        'codigo'=>substr($array[$i][27],0,2),
                        'nombre'=>$array[$i][28]
                    ]);            
                } 
                else
                {
                    $ubigeo->nombre = $array[$i][28];
                    $ubigeo->updated_at = Carbon::now();
                    $ubigeo->save();
                }

                //segundo nivel ubigeo
                $ubigeoB = Ubigeo::where('codigo',substr($array[$i][27],0,4))->first();
                if($ubigeoB==null){
                    $ubigeoB = Ubigeo::firstOrCreate([
                        'codigo'=>substr($array[$i][27],0,4),
                        'nombre'=>$array[$i][29],
                        'dependencia'=> $ubigeo->id
                    ]);            
                } 
                else
                {
                    $ubigeoB->nombre = $array[$i][29];
                    $ubigeoB->updated_at = Carbon::now();
                    $ubigeoB->dependencia = $ubigeo->id;
                    $ubigeoB->save();
                }

                //tercer nivel ubigeo
                $ubigeoC = Ubigeo::where('codigo',substr($array[$i][27],0,6))->first();
                if($ubigeoC==null){
                    $ubigeoC = Ubigeo::firstOrCreate([
                        'codigo'=>substr($array[$i][27],0,6),
                        'nombre'=>$array[$i][30],
                        'dependencia'=> $ubigeoB->id
                    ]);            
                } 
                else
                {
                    $ubigeoC->nombre = $array[$i][30];
                    $ubigeoC->updated_at = Carbon::now();
                    $ubigeoC->dependencia = $ubigeoB->id;
                    $ubigeoC->save();
                }

                $centroPoblado = CentroPoblado::where('nombre',$array[$i][24])->first();
                if($centroPoblado==null){
                    $centroPoblado = CentroPoblado::firstOrCreate([  
                        'codINEI'=>$array[$i][22],
                        'codUEMinedu'=>$array[$i][23],                       
                        'nombre'=>$array[$i][24],
                        'Ubigeo_id'=> $ubigeoC->id
                    ]);            
                } 
                else
                {
                    $centroPoblado->codINEI = $array[$i][22];
                    $centroPoblado->codUEMinedu = $array[$i][23];
                    $centroPoblado->nombre = $array[$i][24];
                    $centroPoblado->updated_at = Carbon::now();
                    $centroPoblado->Ubigeo_id = $ubigeoC->id;
                    $centroPoblado->save();
                }

                $estadoInsEdu = EstadoInsEdu::where('codigo',$array[$i][40])->first();
                if($estadoInsEdu==null){
                    $estadoInsEdu = EstadoInsEdu::firstOrCreate([
                        'codigo'=>$array[$i][40],
                        'nombre'=>$array[$i][41]
                    ]);            
                } 
                else
                {
                    $estadoInsEdu->nombre = $array[$i][41];
                    $estadoInsEdu->updated_at = Carbon::now();
                    $estadoInsEdu->save();
                }                

                $ugel = Ugel::where('codigo',$array[$i][32])->first();
                if($ugel==null){
                    $ugel = Ugel::firstOrCreate([
                        'codigo'=>$array[$i][32],
                        'nombre'=>$array[$i][33]
                    ]);            
                } 
                else
                {
                    $ugel->nombre = $array[$i][33];
                    $ugel->updated_at = Carbon::now();
                    $ugel->save();
                }

                $area = Area::where('codigo',$array[$i][25])->first();
                if($area==null){
                    $area = Area::firstOrCreate([
                        'codigo'=>$array[$i][25],
                        'nombre'=>$array[$i][26]
                    ]);            
                } 
                else
                {
                    $area->nombre = $array[$i][26];
                    $area->updated_at = Carbon::now();
                    $area->save();
                }

                $turno = Turno::where('codigo',$array[$i][38])->first();
                if($turno==null){
                    $turno = Turno::firstOrCreate([
                        'codigo'=>$array[$i][38],
                        'nombre'=>$array[$i][39]
                    ]);            
                } 
                else
                {
                    $turno->nombre = $array[$i][39];
                    $turno->updated_at = Carbon::now();
                    $turno->save();
                }

                $institucionEducativa = InstitucionEducativa::
                where(
                    [
                    ['codModular',$array[$i][0]],
                    ['anexo',$array[$i][1]]
                    ]
                )->first();               

                if($institucionEducativa==null){
                    $institucionEducativa = InstitucionEducativa::firstOrCreate([
                        'NivelModalidad_id'=>$nivelModalidad->id,
                        'Forma_id'=>$forma->id,
                        'Caracteristica_id'=>$caracteristica->id,
                        'Genero_id'=>$genero->id,
                        'TipoGestion_id'=>$tipoGestion->id,
                        'TipoPrograma_id'=>$tipoPrograma->id,
                        'Ugel_id'=>$ugel->id,
                        'Area_id'=>$area->id,
                        'EstadoInsEdu_id'=>$estadoInsEdu->id,
                        'Turno_id'=>$turno->id,
                        'CentroPoblado_id'=>$centroPoblado->id,

                        'codModular'=>$array[$i][0],
                        'anexo'=>$array[$i][1],
                        'codLocal'=>$array[$i][2],
                        'nombreInstEduc'=>$array[$i][3],
                        'nombreDirector'=>$array[$i][15],
                        'telefono'=>$array[$i][16],
                        'email'=>$array[$i][17],
                        'paginaWeb'=>$array[$i][18],
                        'direccion'=>$array[$i][19],
                        'referencia'=>$array[$i][20],
                        'coorGeoLatitud'=>1,//$array[$i][34],
                        'coordGeoLongitud'=>2,//$array[$i][35],
                        'fechaReg'=>Carbon::now(),//$array[$i][48],
                        'fechaAct'=>Carbon::now(),//$array[$i][49],                        
                    ]);            
                } 
                else
                {    
                    $institucionEducativa->NivelModalidad_id = $nivelModalidad->id;
                    $institucionEducativa->Forma_id = $forma->id;
                    $institucionEducativa->Caracteristica_id = $caracteristica->id;
                    $institucionEducativa->Genero_id = $genero->id;
                    $institucionEducativa->TipoGestion_id = $tipoGestion->id;
                    $institucionEducativa->TipoPrograma_id = $tipoPrograma->id;
                    $institucionEducativa->Ugel_id = $ugel->id;
                    $institucionEducativa->Area_id = $area->id;
                    $institucionEducativa->EstadoInsEdu_id = $estadoInsEdu->id;
                    $institucionEducativa->Turno_id = $turno->id;
                    $institucionEducativa->CentroPoblado_id = $centroPoblado->id;
                                                        
                    //$institucionEducativa->codModular = $array[$i][0];
                    $institucionEducativa->anexo = $array[$i][1];
                    $institucionEducativa->codLocal = $array[$i][2];
                    $institucionEducativa->nombreInstEduc = $array[$i][3];
                    $institucionEducativa->nombreDirector = $array[$i][15];
                    $institucionEducativa->telefono = $array[$i][16];
                    $institucionEducativa->email = $array[$i][17];
                    $institucionEducativa->paginaWeb = $array[$i][18];
                    $institucionEducativa->direccion = $array[$i][19];
                    $institucionEducativa->referencia = $array[$i][20];
                    $institucionEducativa->coorGeoLatitud = 1;// $array[$i][34];
                    $institucionEducativa->coordGeoLongitud = 2;//$array[$i][35];
                    $institucionEducativa->fechaReg =Carbon::now();// $array[$i][48];
                    $institucionEducativa->fechaAct =Carbon::now();// $array[$i][49];

                    $institucionEducativa->updated_at = Carbon::now();
                    $institucionEducativa->save();
                }
                //$ids =  (string)$nivelModalidad->id;
            //}
        }
       
        return  $array;//$ids;//view('ImportarEducacion.frmPadronWeb');
    }
}
