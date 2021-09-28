@extends('layouts.main',['activePage'=>'InstEducativa','titlePage'=>'DIRECCIÓN REGIONAL DE EDUCACIÓN DE UCAYALI'])

@section('css')

@endsection 



@section('content') 

<div class="content">    
    <div class="row">
       <div class="col-md-12">           
           <div class="card">
               
               <div class="card-body">

                    <div id="datos01" class="form-group row">                        
                     Cargando datos.....                        
                    </div>
                    
               </div>
            </div>
        </div>
     </div>
  </div>


@endsection 



@section('js')

<script type="text/javascript"> 


      $(document).ready(function() {                  

       cargar_porDistrito();

      });

      function cargar_porDistrito() {
           
            $.ajax({  
                headers: {
                     'X-CSRF-TOKEN': $('input[name=_token]').val()
                },                           
                url: "{{ url('/') }}/InstEducativa/ReporteDistrito",
                type: 'post',
            }).done(function (data) {               
                $('#datos01').html(data);
            }).fail(function () {
                alert("Lo sentimos a ocurrido un error");
            });
        }

</script>

@endsection
