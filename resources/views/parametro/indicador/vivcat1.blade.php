@extends('layouts.main',['titlePage'=>'INDICADOR'])

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-fill bg-success">
                    <div class="card-header bg-transparent">
                        <h3 class="card-title text-white">{{$title}}</h3>
                    </div>
                </div>
            </div>
        </div>
       
    </div>
@endsection

@section('js')

    <!-- flot chart -->
    <!--script src="{{ asset('/') }}assets/libs/flot-charts/jquery.flot.js"></script-->
    <script src="{{ asset('/') }}assets/libs/chart-js/Chart.bundle.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
        });
    </script>

@endsection
