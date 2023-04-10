@extends('layouts.backend')

@section('content')
<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                Informe de Inmuebles
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
                <button type="button" class="btn btn-sm btn-alt-secondary" title="Buscar" onclick="filter_all()">
                    <i class="fa fa-eye"> Ver Todos</i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary" title="Limpiar Criterio de Busqueda" onclick="limpiar()">
                    <i class="fa fa-trash"> Limpiar</i>
                </button>
                <!-- </div> -->
            </div>

            <div class="table-responsive" id="row_table_inmueble">
                <br>
                <br>
                <br>
                <button type="button" class="btn btn-sm btn-alt-secondary" title="Exportar Excel" onclick="excel()">
                    <i class="fa fa-file-excel"> Exportar a Excel </i>
                </button>
                <br>
                <br>
                <table class="table table-hover table-vcenter" id="table_inmueble">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">N&deg Visitas</th>
                            <th class="text-center">Comentario</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    async function buscar() {
        let date1 = $('#date1').val();
        let date2 = $('#date2').val();
        let uri =  "/informe/inmueble?date1="+date1;
        console.log(uri);
        try {
            let resp = await request(`/informe-inmueble/${date1}`,'get');

                if(resp.status = 'success'){
                    if(resp.data.length == 0){
                        $("#table_inmueble tbody").empty();
                        $('#row_table_inmueble').hide();
                        return;
                    }

                    llenarTabla(resp.data);
                }
        } catch (error) {
            Swal.fire(error.title, error.msg, error.status);
        }
    }

    function llenarTabla(data) {
        $('#row_table_inmueble').hide();
        $("#table_inmueble tbody").empty();
        var newRowContent = '';

        if (data.length == 0) {
            return;
        }
        $('#row_table_inmueble').show();
        let count = 1;
        data.forEach((item) => {
            newRowContent = `
                    <tr>
                        <td class="text-center">
                            ${count}
                        </td>
                        <td class="text-center">
                            ${item.idvisita}
                        </td>
                        <td class="text-center">
                            ${item.observacion}
                        </td>
                    </tr>
                `;
            $("#table_inmueble tbody").append(newRowContent);
            count++;
        });
    }
</script>
@endsection