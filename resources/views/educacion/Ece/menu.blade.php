@extends('layouts.main',['titlePage'=>'RELACIÓN DE INDICADORES DE EDUCACIÓN'])

@section('content')

<div class="content">
 
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-border">
                <div class="card-header bg-transparent pb-0">
                    <h3 class="card-title ">Lista de Indicadores</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table class="table table-bordered mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>CATEGORIA</th>
                                            <th>INDICADORES</th>
                                            <th>FUENTE</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td rowspan="3">CULMINACIÓN DE LA EDUCACIÓN BÁSICA Y SUPERIOR</td>
                                            <td><a href="#">Tasa de conclusión, primaria, grupo de edades 12-13 años (% del total)</a></td>
                                            <td rowspan="3">Bases de datos de la Encuesta Nacional de Hogares del Instituto Nacional 
                                                de Estadística e Informática - INEI</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td><a href="#">Tasa de conclusión, secundaria, grupo de edades 17-18 años (% del total)</a></td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td><a href="#">Tasa de conclusión, educación superior, grupo de edades 22-24 años (% del total)</a></td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td rowspan="4">LOGROS DE APRENDIZAJE</td>
                                            <td><a href="{{route('ece.indicador.4')}}">Alumnos que logran los aprendizajes del grado (% de alumnos de 2° grado de primaria participantes en evaluaciones censal)</a></td>
                                            <td rowspan="4">Base de datos de la Evaluación Censal De Estudiantes (ECE) del Ministerio 
                                                de Educación-Oficina de Medición de Calidad de los Aprendizajes</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td><a href="{{route('ece.indicador.5')}}">Alumnos que logran los aprendizajes del grado (% de alumnos de 2° grado de secundaria participantes en evaluación censal)</a></td>
                                        </tr>
                                        <tr>
                                            <td>6</td>
                                            <td><a href="{{route('ece.indicador.6')}}">Alumnos que logran los aprendizajes del grado (% de alumnos de 4° grado de primaria participantes en evaluación censal)</a></td>
                                        </tr>
                                        <tr>
                                            <td>7</td>
                                            <td><a href="{{route('ece.indicador.7')}}">Alumnos de EIB que logran los aprendizajes del 4° grado en lengua materna y en castellano como segunda lengua.</a></td>
                                        </tr>
                                        <tr>
                                            <td>8</td>
                                            <td rowspan="3">ACCESO A LA EDUCACIÓN</td>
                                            <td><a href="#">Tasa neta de matrícula, educación inicial (% de población con edades de 3-5 años)</a></td>
                                            <td rowspan="3">Base de datos del Sistema de Información de Apoyo a la Gestión de la 
                                                Institución Educativa (SIAGIE).</td>
                                        </tr>
                                        <tr>
                                            <td>9</td>
                                            <td><a href="#">Tasa neta de matrícula, educación primaria (% de población con edades de 6-11 años)</a></td>
                                        </tr>
                                        <tr>
                                            <td>10</td>
                                            <td><a href="#">Tasa neta de matrícula, educación secundaria (% de población con edades de 12-16 años)</a></td>
                                        </tr>
                                        <tr>
                                            <td>11</td>
                                            <td rowspan="3">PROFESORES Y PROMOTORAS EDUCATIVAS</td>
                                            <td><a href="#">Profesores titulados, inicial (% del total)</a></td>
                                            <td rowspan="3">Nexus</td>
                                        </tr>
                                        <tr>
                                            <td>12</td>
                                            <td><a href="#">Profesores titulados, primaria (% del total)</a></td>
                                        </tr>
                                        <tr>
                                            <td>13</td>
                                            <td><a href="#">Profesores titulados, secundaria (% del total)</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
      <!-- col -->
  </div>
  <!-- End row -->

</div>

@endsection

@section('js')
      <script src="{{ asset('/') }}assets/libs/jquery-validation/jquery.validate.min.js"></script>
      <!-- Validation init js-->
      <script src="{{ asset('/') }}assets/js/pages/form-validation.init.js"></script>

@endsection