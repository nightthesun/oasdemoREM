@extends('layouts.app')

@section('content')
@include('layouts.sidebar', ['hide'=>'0']) 
<div class="container-fluid">
    <div class="row justify-content-center mt-4">
        <div class="col-md-12">
            <table id="example" class="cell-border compact hover"></table>    
        </div>
    </div>
</div>
@endsection

@section('mis_scripts')
<script>
var json_data = {!! json_encode($test) !!};
$(document).ready(function() 
{  
    var height = screen.height-430+'px';
    $('#example').DataTable( 
    {
        data: json_data,
        columns: [
            { data: 'categoria', title: 'Categoria' },
            { data: 'codigo', title: 'Codigo' },
            { data: 'descripcion', title: 'Descripcion'},
            { data: 'umprod', title: 'U.M. Producto'},
            { data: 'precio_orig', title: 'Precio Orig'},
            { data: 'moneda_preco', title: 'M.'},
            { data: 'costultcomp', title: 'Costo Ult. C/I'},
            { data: 'monedacostultcomp', title: 'M.'},
            { data: 'tipo_compra', title: 'Tipo Compra'},
            { data: 'pvp', title: 'PVP'},
            { data: 'fecha_ult', title: 'Fecha Ult C/I'},
            { data: 'cantultcomp', title: 'Cantidad Ult.'},
            { data: 'um_ultcomp', title: 'U.M.'},
            { data: 'codtransini', title: 'Transaccion Ini.'},
            { data: 'prov', title: 'Proveedor'},
            { data: 'stockTotal', title: 'Total'},
            { data: 'stockAC2', title: 'AC2'},
            { data: 'stockAC1', title: 'AC1'},
            { data: 'stockAlto', title: 'Planta'},
            { data: 'stockHAN', title: 'Han'},
            { data: 'stockBALL', title: 'Ball'},
            { data: 'stockMARIS', title: 'Maris'},
            { data: 'stockCALA', title: 'Calac'},
            { data: 'stockSanM', title: 'SanM'},
            { data: 'stockSCZ', title: 'SCZ'},  
            { data: 'stockARGen', title: 'AlmResGenerales'},   
            { data: 'stockAlmMay1', title: 'AlmMayorista1'}, 
            { data: 'stockAlmMay2', title: 'AlmMayorista2'},                      
            { data: 'stockAlmMay3', title: 'AlmMayorista3'}, 
            { data: 'stockAlmMay4', title: 'AlmMayorista4'}, 
            { data: 'stockAlmMay5', title: 'AlmMayorista5'}, 
            { data: 'stockAlmDistri1', title: 'AlmDistribuidor1'},         
            { data: 'fechaultventa', title: 'Fecha Ult. Venta'},
        ],   
        "columnDefs": [
            { "width": "300px", "targets": 2 },
            { className: "dt-right", "targets":[4,6,9,11,15,16,17,18,19,20,21,22,23,24]}
        ],     
        "language":             
        {
            "emptyTable":     "Tabla Vacia",
            "info":           "Se muestran del _START_ al _END_ de _TOTAL_ registros",
            "infoEmpty":      "Se muestran del 0 al 0 de 0 Registros",
            "infoFiltered":   "(Filtrado de un total de _MAX_ registros)",
            "lengthMenu":     "Se muestran _MENU_ registros",
            "loadingRecords": "Cargando...",
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "zeroRecords":    "No se encontro ningun registro",
            "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            }
        },
        "scrollX": true,
        "scrollY": height,
        "scrollCollapse": true, 
    } );
    setTimeout(function(){
    $(".page-wrapper").removeClass("toggled"); 
 }, 500);
} );
</script>
@endsection
