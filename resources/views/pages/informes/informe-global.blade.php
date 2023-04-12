@extends('layouts.backend')

@section('content')
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Informe Global
            </h3>
        </div>
        <div class="block-content">
            <h5>Criterios de Busqueda </h5>
            <form action="/informe-global" method="get" id="form_global">
                <div class="col-lg-8 col-xl-6">
                    <div class="mb-4">
                        <div class="input-daterange input-group" data-date-format="dd/mm/yyyy" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <input type="text" class="form-control" id="date1" name="date1" value="{{$desde}}" placeholder="Fecha Desde" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                            <span class="input-group-text fw-semibold">
                                <i class="fa fa-fw fa-arrow-right"></i>
                            </span>
                            <input type="text" class="form-control" id="date2" name="date2" value="{{$hasta}}" placeholder="Fecha Hasta" data-week-start="1" data-autoclose="true" data-today-highlight="true">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-sm btn-alt-secondary" title="Buscar" onclick="buscar()">
                        <i class="fa fa-search"> Buscar</i>
                    </button>
                    <a type="button" class="btn btn-sm btn-alt-secondary" title="Limpiar Criterio de Busqueda" onclick="limpiar()">
                        <i class="fa fa-trash"> Limpiar</i>
                    </a>
                </div>
            </form>
            <div class="table-responsive" id="row_table_global">
                <br>
                <br>
                <br>
                <a class="btn btn-sm btn-alt-secondary" title="Exportar Excel" id="exportarexcel">
                    <i class="nav-main-link-icon far fa fa-file-excel"> Exportar Excel</i>
                </a>
                <br>
                <br>
                <table class="table table-hover table-vcenter" id="table_global">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;"></th>
                            <th class="text-left">Num. Pedido</th>
                            <th class="text-left">Num. Encargo</th>
                            <th class="text-left">Num. Rebaja</th>
                            <th class="text-left">Num. Valoracion</th>
                        </tr>
                    </thead>
                    <tbody id="table_global">
                        <tr>
                            <th class="text-center" scope="row"></th>
                            <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$pedidos}}</a>
                                </td>
                                <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$encargo}}</a>
                                </td>
                                <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$rebaja}} </a>
                                </td>
                                <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$valoracion}} </a>
                                </td>
                            </td>
                        </tr>
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
        
        $('#exportarexcel').attr('href',"/informe-global/exportexcel?date1="+date1+"&date2="+date2);

    });

    function limpiar(){
        $('#date1').val('');
        $('#date2').val('');
        $('#form_global').submit();
    }
</script>
@endsection