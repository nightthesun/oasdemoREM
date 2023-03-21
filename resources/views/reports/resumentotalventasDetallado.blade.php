@extends('layouts.app')
@section('static', 'statick-side')
@section('estilo')
 <style>
     #divV{
        border-top: 2px dotted #bbb;
     }
 .multi-select
 {
    display: block;
    width: 100%;
    font-weight: 400;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    height: auto;
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.7875rem;
    line-height: 1.5;
    overflow: hidden;
    white-space: nowrap;
    border-radius: 0.2rem;
    text-align: left; 
 }

 .multi-select-op
 {
    clear: both;
    display: inline-block;
    overflow: hidden;
    white-space: nowrap;
    width: 100%;
    padding: 0.375rem 0.75rem;
    font-size: 0.8rem;
    font-weight: 400;
    line-height: 1.6;
    color: #495057;
    background-color: #fff;

    height: auto;
    height: calc(1.5em + 0.5rem + 2px);
    padding: 0.25rem 0.5rem;
    font-size: 0.7875rem;
    line-height: 1.5;
 }
 .scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: scroll;
}
 </style>
@endsection
@section('content')
@include('layouts.sidebar', ['hide'=>'1']) 


<div class="container" >
    <div class="row justify-content-center mt-4" >
        <div class="col-md-8 col-lg-6 col-sm-12 border" >
        
                <form method="GET"  action="{{ route('restotvendetallado.store') }}">
           
                    <div class=" row d-flex justify-content-center my-3">
                    <div class="d-flex align-items-center justify-content-center">
                        <h3 class="text-primary">RESUMEN TOTAL DE VENTAS DETALLADO</h3>
                    </div>
                </div>
                <div class="row d-flex justify-content-center"><div class="col-12">
                  <div class="form-group row d-flex justify-content-center">
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Desde:</label>
                    <div class="col-sm-4">
                    <input id="fini" type="date" class="form-control form-control-sm " name="fini" value ="{{date('Y-m-d')}}">
                    </div>
                    <label for="colFormLabelSm" class="col-sm-2 col-form-label col-form-label-sm text-right">Hasta:</label>
                    <div class="col-sm-4">
                    <input id="ffin" type="date" class="form-control form-control-sm " name="ffin" value ="{{date('Y-m-d')}}">
                    </div>
                </div>
                <br>
                  
                    <!-- en esta parte es para los filtros para ser portados en pdf y excel-->
                </div>
            </div>
            <br>
            <div class="mb-3 row">
                <div class="col-md-12 d-flex justify-content-center">

           
                  <button type="submit" class="btn btn-primary mx-2" name="gen" value="ver">
                    Ver <i class="fas fa-bullseye"></i>
                  </button>
       
                    <button type="submit" class="btn btn-primary mx-2" name="gen" value="export" disabled>
                        PDF <i class="fas fa-file-pdf"></i>
                    </button>
                     <button type="submit" class="btn btn-primary mx-2" name="gen" value="excel" disabled>
                        Excel <i class="far fa-file-excel"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('mis_scripts')
<script>
$( ".dropdown-menu" ).click(function() {
    $('.dropdown-menu').parent().is(".open") && e.stopPropagation();
});



///////////////////////////////////////



</script>
@endsection
