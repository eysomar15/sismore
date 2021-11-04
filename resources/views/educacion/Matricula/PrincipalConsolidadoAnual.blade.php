@extends('layouts.main',['activePage'=>'importacion','titlePage'=>'MATRICULAS CONSOLIDADAS POR AÑO'])

@section('css')
    
    <link href="{{ asset('/') }}assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />

@endsection 

@section('content') 

<input type="hidden" id="hoja" value="0">

<div class="content">    
    <div class="row">
        <div class="col-md-12">           
            <div class="card">
                
                <div class="card-body">

                    <div class="form-group row">
                        <label class="col-md-1 col-form-label">Año:</label>
                        <div class="col-md-2">
                            <select id="anio" name="anio" class="form-control" onchange="cargar_fechas_matricula();">                               
                                @foreach ($anios as $item)
                                    <option value="{{ $item->id }}"> {{ $item->anio }} </option>
                                @endforeach
                            </select>
                        </div>
                       
                        <label class="col-md-1 col-form-label"></label>
                        <div class="col-md-2">                          
                        </div>

                        <div class="col-md-3">
                        </div>

                        <label class="col-md-1 col-form-label">Gestión:</label>
                        <div class="col-md-2">
                            <select id="gestion" name="gestion" class="form-control" onchange="cambia_gestion();" >                              
                                    <option value="1"> Públicas y privadas</option>
                                    <option value="2"> Pública</option>
                                    <option value="3"> Privada</option>                              
                            </select>
                        </div>
                        
                    </div>                    
                           
                    <div class="progress progress-sm m-0">
                        <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                    <br>
                    <div class="col-md-12">                       
                        <div class="portfolioFilter">
                            <a href="#" onClick="cargar_inicio();" class="current waves-effect waves-light">INICIO</a>
                            <a href="#" onClick="cargar_resumen_porUgel();"       class="waves-effect waves-light">UGELES</a>
                            <a href="#" onClick="cargar_matricula_porDistrito();" class="waves-effect waves-light" > DISTRITOS </a>    
                            <a href="#" onClick="cargar_matricula_porInstitucion();" class="waves-effect waves-light" > INSTITUCIONES </a>  
                            <a href="#" onClick="cargar_Grafico();" class="waves-effect waves-light" > GRAFICA </a>                  
                        </div>                        
                    </div>

                    
                    <div class="content" >
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">      
                                        <div id="barra1" class="form-group row">       
                                           
                                        </div> 
                                    </div> 
                                </div> 
                            </div> 
                        </div> 
                    </div> 

                </div>               
                <!-- card-body -->

            </div>
              
        </div> <!-- End col -->
    </div> <!-- End row -->  
</div>

@endsection 




@section('js')


@endsection
