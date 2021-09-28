@section('css')
     <!-- Table datatable css -->
     <link href="{{ asset('/') }}assets/libs/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
@endsection

<div class="col-md-12">
   <div class="card-header bg-primary py-3 text-white">
       <h5  class="card-title mb-0 text-white"> Reporte de Matrícula de Estudiantes - Nivel Inicial al {{$fecha_Matricula_texto}} </h5>
   </div>

 


   <div >
       <div  class="col-md-6">
           Fuente: SIAGIE- MINEDU          
       </div>
   </div>

</div>

<div class="table-responsive">
 <table id="grid" class="table table-striped table-bordered" >
     <thead > 

         <tr >
             <th class="titulo_tabla" >UGEL </th>
             {{-- <th class="titulo_tabla" >DEPARTAMENTO </th>
             <th class="titulo_tabla" >PROVINCIA </th>                   --}}
         </tr>

     </thead>
 </table>
</div>

@section('js')
  
    <script src="{{ asset('/') }}assets/libs/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}assets/libs/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}assets/libs/datatables/dataTables.responsive.min.js"></script>
    <script src="{{ asset('/') }}assets/libs/datatables/responsive.bootstrap4.min.js"></script>

    <script>
        $('#grid').DataTable({
            "ajax": "{{route('Matricula.Institucion_DataTable',$matricula_id)}}",
            "columns":[             
                {data:'ugel'},                
            ],
            // responsive:true,
            autoWidth:true,
            "language": {
            "lengthMenu": "Mostrar "+
            `<select class="custom-select custom-select-sm form-control form-control-sm">
                <option value = '10'> 10</option>
                <option value = '25'> 25</option>
                <option value = '50'> 50</option>
                <option value = '100'>100</option>
                <option value = '-1'>Todos</option>
                </select>` + " registros por página",          
            "info": "Mostrando la página _PAGE_ de _PAGES_" ,
            "infoEmpty": "No records available",
            "infoFiltered": "(Filtrado de _MAX_ registros totales)",  
            "emptyTable":			"No hay datos disponibles en la tabla.",
            "info":		   			"Del _START_ al _END_ de _TOTAL_ registros ",
            "infoEmpty":			"Mostrando 0 registros de un total de 0. registros",
            "infoFiltered":			"(filtrados de un total de _MAX_ )",
            "infoPostFix":			"",           
            "loadingRecords":		"Cargando...",
            "processing":			"Procesando...",
            "search":				"Buscar:",
            "searchPlaceholder":	"Dato para buscar",
            "zeroRecords":			"No se han encontrado coincidencias.",
            
            "paginate":{
                "next":"siguiente",
                "previous":"anterior"
                }
            }
        }

        );
    </script>
@endsection
