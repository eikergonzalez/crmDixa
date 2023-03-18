@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Encargo
                </h3>
            </div>
            <div class="block-content">
                <div class="table-responsive">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Direccion</th>
                                <th>Tipo Solicitud</th>
                                <th>Nombre y Apellido</th>
                                <th>Estatus</th>
                                <th class="text-center" style="width: 100px;">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($propietarios as $propietario)
                                @php
                                    $precioSolicitado = !empty($propietario->precio_solicitado) ? $propietario->precio_solicitado : 0;
                                    $precioValorado = !empty($propietario->precio_valorado) ? $propietario->precio_valorado : 0;
                                    $porcentaje = ((abs($precioValorado - $precioSolicitado)) / 100) * 100;
                                    $color = 'btn-alt-secondary';

                                    if(floatval($porcentaje) >= floatval(15)){
                                        $color = "btn-alt-danger";
                                    }
                                    if(floatval($porcentaje) > floatval(7) && floatval($porcentaje) < floatval(15)){
                                        $color = "btn-alt-warning";
                                    }
                                    if(floatval($porcentaje) < floatval(7)){
                                        $color = "btn-alt-success";
                                    }

                                @endphp
                                <tr>
                                    <th class="text-center" scope="row">{{ $propietario->propietarioid }}</th>
                                    <td class="fw-semibold">
                                        <a href="javascript:void(0)">{{ $propietario->direccion }} </a>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span class="badge bg-warning">{{ $propietario->solicitud }}</span>
                                    </td>
                                    <td class="fw-semibold">
                                        <a href="javascript:void(0)">{{ $propietario->nombre }} - {{ $propietario->apellido }}</a>
                                    </td>
                                    <td class="fw-semibold">
                                        <a href="javascript:void(0)">{{ $propietario->estatus }}</a>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            @if(Auth::user()->rol_id <> 4)
                                                <a class="btn btn-sm {{ $color }}" href="/encargo/detalle/{{ $propietario->inmuebleid }}" title="Ver detalle">
                                                    <i class="nav-main-link-icon far fa fa-eye"></i>
                                                </a>
                                                <a type="button" class="btn btn-sm btn-alt-secondary" title="Visitas" onclick="getVisitas({{ $propietario->inmuebleid }})">
                                                    <i class="fa fa-user"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="agendaModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Visita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" autocomplete="off" id="formVisita">
                    {{ csrf_field() }}
                    <input type="hidden" id="inmueble_id" name="inmueble_id" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Indique su nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Indique su apellido" required>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Indique su telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 pb-3">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Indique su correo" required>
                            </div>
                        </div>
                        <div class="row m-3" id="row_table_visitas">
                            <br>
                            <br>
                            <table class="table table-bordered table-striped table-vcenter" id="table_visitas">
                                <thead>
                                    <tr>
                                        <th class="text-center">Nombre</th>
                                        <th class="text-center">Apellido</th>
                                        <th class="text-center">Telefono</th>
                                        <th class="text-center">Correo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary button_save_visitas">Guardar</button>
                        <a class="btn btn-primary button_loading_visitas" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>

        $(document).ready(function() {
            $('#row_table_visitas').hide();
            $('#agendaModal').modal({backdrop: 'static'});
            hideLoadingVisitas();
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#correo').val('');
        });

        $("#formVisita").submit(async function(e){
            e.preventDefault();
            await saveVisitas();
            return false;
        });

        async function getVisitas(idInmueble) {
            try{
                $('#inmueble_id').val(idInmueble);
                let resp = await request(`visitas/${idInmueble}`,'get');

                if(resp.status = 'success'){
                    if(resp.data.length == 0){
                        $("#table_visitas tbody").empty();
                        $('#row_table_visitas').hide();
                        $('#agendaModal').modal('show');
                        return;
                    }

                    llenarTabla(resp.data);
                    $('#agendaModal').modal('show');
                }
            }catch (error) {
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function saveVisitas() {
            try{
                showLoadingVisitas();
                var data = {
                    nombre : $('#nombre').val(),
                    apellido : $('#apellido').val(),
                    telefono : $('#telefono').val(),
                    correo : $('#correo').val(),
                    inmueble_id : $('#inmueble_id').val(),
                }

                let resp = await request(`visitas`,'post', data);
                console.log(resp);
                if(resp.status = 'success'){
                    if(resp.data.length == 0){
                        $("#table_visitas tbody").empty();
                        $('#row_table_visitas').hide();
                        return;
                    }
                    hideLoadingVisitas();
                    llenarTabla(resp.data);
                    Swal.fire(resp.title,resp.msg,resp.status);
                }
            }catch (error) {
                hideLoadingVisitas();
                console.log("error: "+error);
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        function llenarTabla(data) {
            $('#row_table_visitas').hide();
            $("#table_visitas tbody").empty();
            var newRowContent = '';

            if(data.length == 0){
                return;
            }
            $('#row_table_visitas').show();
            data.forEach((item) =>{
                newRowContent = `
                    <tr>
                        <td class="text-center">
                            ${item.nombre}
                        </td>
                        <td class="text-center">
                            ${item.apellido}
                        </td>
                        <td class="fw-semibold">
                            ${item.telefono}
                        </td>
                        <td class="text-center">
                            ${item.correo}
                        </td>
                    </tr>
                `;
                $("#table_visitas tbody").append(newRowContent);
            });
        }

        function showLoadingVisitas() {
            $('.button_loading_visitas').show();
            $('.button_save_visitas').hide();
        }

        function hideLoadingVisitas() {
            $('.button_loading_visitas').hide();
            $('.button_save_visitas').show();
        }
    </script>
@endsection
