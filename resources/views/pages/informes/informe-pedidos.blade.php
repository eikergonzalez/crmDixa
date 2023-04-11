@extends('layouts.backend')

@section('content')
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Informe de Pedidos
            </h3>
        </div>
        <div class="block-content">
            <h5>Criterios de Busqueda </h5>
            <div class="col-lg-8 col-xl-6">
                <div class="mb-4">
                    <div class="input-daterange input-group" data-date-format="mm/dd/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        <input type="text" class="form-control" id="date1" name="date1" placeholder="Fecha Desde" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        <span class="input-group-text fw-semibold">
                            <i class="fa fa-fw fa-arrow-right"></i>
                        </span>
                        <input type="text" class="form-control" id="date2" name="date2" placeholder="Fecha Hasta" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                    </div>
                </div>
                <!-- <div class="btn-group"> -->
                <button type="button" class="btn btn-sm btn-alt-secondary" title="Buscar" onclick="buscar()">
                    <i class="fa fa-search"> Buscar</i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary" title="Limpiar Criterio de Busqueda" onclick="limpiar()">
                    <i class="fa fa-trash"> Limpiar</i>
                </button>
                <!-- </div> -->
            </div>

            <div class="table-responsive" id="row_table_comercial">
                <br>
                <br>
                <br>
                <a class="btn btn-sm btn-alt-secondary" href="{{ route('export.excel', ['param1' => $param1, 'param2' => $param2]) }}" title="Exportar Excel">
                    <i class="nav-main-link-icon far fa fa-file-excel"> Exportar Excel</i>
                </a>
                <br>
                <br>
                <table class="table table-hover table-vcenter" id="table_comercial">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">N&deg Ofertas</th>
                            <th class="text-center">Comentarios</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pedido as $ped)
                        <tr>
                            <th class="text-center" scope="row">{{$ped->idvisita}}</th>
                                <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$ped->fecha_visita}} </a>
                                </td>
                                <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$ped->observacion}}</a>
                                </td>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>

    $(document).ready(function() {
        let date1 = $('#date1').val();
        let date2 = $('#date2').val();
        
        $('#exportarexcel').attr('href',"/informe-inmueble/exportexcel?date1="+date1+"&date2="+date2);

    });

    function limpiar(){
        $('#date1').val('');
        $('#date2').val('');
        $('#form_inmueble').submit();
    }
</script>
@endsection