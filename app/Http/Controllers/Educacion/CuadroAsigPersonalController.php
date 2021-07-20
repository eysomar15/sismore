<?php

namespace App\Http\Controllers\Educacion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\tablaXImport;
use App\Models\Educacion\Importacion;
use Exception;

class CuadroAsigPersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importar()
    {  
        $mensaje = "";
        return view('Educacion.CuadroAsigPersonal.Importar',compact('mensaje'));
    } 
         
    public function guardar(Request $request)
    {      
        $this->validate($request,['file' => 'required|mimes:xls,xlsx']);      
        $archivo = $request->file('file');
        $array = (new tablaXImport )-> toArray($archivo);

        try{
            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    // echo $row['cen_edu'].'<br>';
                    $cadena = $row['region'].$row['unidad_ejecutora'].$row['organo_intermedio'].$row['provincia'].$row['distrito'].$row['tipo_ie'].
                              $row['gestion'].$row['zona'].$row['codmod_ie'].$row['codigo_local'].$row['clave8'].$row['nivel_educativo'].
                              $row['institucion_educativa'].$row['codigo_plaza'].$row['tipo_trabajador'].$row['sub_tipo_trabajador'].$row['cargo'].
                              $row['situacion_laboral'].$row['motivo_vacante'].$row['documento_identidad'].$row['codigo_modular'].$row['apellido_paterno'].
                              $row['apellido_materno'].$row['nombres'].$row['fecha_ingreso'].$row['categoria_remunerativa'].$row['jornada_laboral'].
                              $row['estado'].$row['fecha_nacimiento'].$row['fecha_inicio'].$row['fecha_termino'].$row['tipo_registro'].$row['ley'].
                              $row['preventiva'].$row['referencia_preventiva'].$row['especialidad'].$row['tipo_estudios'].$row['estado_estudios'].
                              $row['grado'].$row['mencion'].$row['especialidad_profesional'].$row['fecha_resolucion'].$row['numero_resolucion'].
                              $row['centro_estudios'].$row['celular'].$row['email'];               
                            }
            }
        }catch (Exception $e) {
            $mensaje = "Formato de archivo no reconocido, porfavor verifique si el formato es el correcto";           
            return view('Educacion.CuadroAsigPersonal.Importar',compact('mensaje'));            
        }
               
        try{
            $importacion = Importacion::Create([
                'fuenteImportacion_id'=>2, // valor predeterminado
                'usuarioId_Crea'=> auth()->user()->id,
                'usuarioId_Aprueba'=>null,
                'fechaActualizacion'=>$request['fechaActualizacion'],
                'comentario'=>$request['comentario'],
                'estado'=>'PE'
            ]); 

            foreach ($array as $key => $value) {
                foreach ($value as $row) {
                    // echo $row['cen_edu'].'<br>';
                    $padronWeb = PadronWeb::Create([
                        'importacion_id'=>$importacion->id,
                        'cod_Mod'=>$row['cod_mod'],
                        'anexo'=>$row['anexo'],
                        'cod_Local'=>$row['codlocal'],
                        'cen_Edu'=>$row['cen_edu'],
                        'niv_Mod'=>$row['niv_mod'],
                        'd_Niv_Mod'=>$row['d_niv_mod'],
                        'd_Forma'=>$row['d_forma'],
                        'cod_Car'=>$row['cod_car'],
                        'd_Cod_Car'=>$row['d_cod_car'],
                        'TipsSexo'=>$row['tipssexo'],
                        'd_TipsSexo'=>$row['d_tipssexo'],
                        'gestion'=>$row['gestion'],
                        'd_Gestion'=>$row['d_gestion'],
                        'ges_Dep'=>$row['ges_dep'],
                        'd_Ges_Dep'=>$row['d_ges_dep'],
                        'director'=>$row['director'],
                        'telefono'=>$row['telefono'],
                        'email'=>$row['email'],
                        'pagWeb'=>$row['pagweb'],
                        'dir_Cen'=>$row['dir_cen'],
                        'referencia'=>$row['referencia'],
                        'localidad'=>$row['localidad'],
                        'codcp_Inei'=>$row['codcp_inei'],
                        'codccpp'=>$row['codccpp'],
                        'cen_Pob'=>$row['cen_pob'],
                        'area_Censo'=>$row['area_censo'],
                        'd_areaCenso'=>$row['dareacenso'],
                        'codGeo'=>$row['codgeo'],
                        'd_Dpto'=>$row['d_dpto'],
                        'd_Prov'=>$row['d_prov'],
                        'd_Dist'=>$row['d_dist'],
                        'd_Region'=>$row['d_region'],
                        'codOOII'=>$row['codooii'],
                        'd_DreUgel'=>$row['d_dreugel'],
                        'nLat_IE'=>1,
                        'nLong_IE'=>2,
                        'tipoProg'=>is_null($row['tipoprog'])? '':$row['tipoprog'],
                        'd_TipoProg'=>is_null($row['d_tipoprog'])? '':$row['d_tipoprog'],
                        'cod_Tur'=>$row['cod_tur'],
                        'D_Cod_Tur'=>$row['d_cod_tur'],
                        'estado'=>$row['estado'],
                        'd_Estado'=>$row['d_estado'],
                        'd_Fte_Dato'=>$row['d_fte_dato'],
                        'tAlum_Hom'=>$row['talum_hom'],
                        'tAlum_Muj'=>$row['talum_muj'],
                        'tAlumno'=>$row['talumno'],
                        'tDocente'=>$row['tdocente'],
                        'tSeccion'=>$row['tseccion'],
                        'fechaReg'=>null,//$row['fechareg']
                        'fecha_Act'=>Utilitario::Fecha_ConFormato_DMY($row['fecha_act']),
                    ]);
                }
            }
        }catch (Exception $e) {
            $mensaje = "Error en la carga de datos, comuniquese con el administrador del sistema";           
            return view('Educacion.PadronWeb.Importar',compact('mensaje'));            
        }

        return redirect()->route('PadronWeb.PadronWeb_Lista',$importacion->id);
       
    }
}
