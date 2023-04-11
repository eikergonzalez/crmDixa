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
                <button type="button" class="btn btn-sm btn-alt-secondary" title="Buscar" onclick="buscar()">
                    <i class="fa fa-search"> Buscar</i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary" title="Limpiar Criterio de Busqueda" onclick="limpiar()">
                    <i class="fa fa-trash"> Limpiar</i>
                </button>
            </div>

            <div class="table-responsive" id="row_table_comercial">
                <br>
                <br>
                <br>
                <a class="btn btn-sm btn-alt-secondary" href="/informe-inmueble/exportexcel" title="Exportar Excel">
                    <i class="nav-main-link-icon far fa fa-file-excel"> Exportar Excel</i>
                </a>
                <br>
                <br>
                <table class="table table-hover table-vcenter" id="table_comercial">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">N&deg Pedidos</th>
                            <th class="text-center">N&deg Encargo</th>
                            <th class="text-center">N&deg Rebaja</th>
                            <th class="text-center">N&deg Valoraciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection