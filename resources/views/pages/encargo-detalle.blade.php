@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="fa-fa-arrow-left block-title">
                    <a class="nav-main-link{{ request()->is('encargo-detalle') ? ' active' : '' }}" href="/encargo">
                        <i class="nav-main-link-icon far fa fa-arrow-left"></i>
                        <span class="nav-main-link-name"> Encargo - Direccion</span>
                    </a>
                </h3>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Rebajas">
                        <i class="fa fa-briefcase"> Rebajas</i>
                    </button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Añadir Visitas" onclick="addVisita()"> 
                        <i class="fa fa-plus"> Añadir Visitas</i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><b> Tipo de Solicitud: </b> {{ $propietarios->solicitud }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Nombre: </b> {{ $propietarios->nombre }} {{ $propietarios->apellido }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> ######: </b> ###### </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default" role="tab" id="accordion_h1">
                                <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q1" aria-expanded="true" aria-controls="accordion_q1">Imagenes</a>
                            </div>
                            <div id="accordion_q1" class="collapse" role="tabpanel" aria-labelledby="accordion_h1" data-bs-parent="#accordion">
                                <div class="block-content">
                                    <p>contenido</p>
                                </div>
                            </div>
                        </div>
                        <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default" role="tab" id="accordion_h2">
                                <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q2" aria-expanded="true" aria-controls="accordion_q2">Archivos</a>
                            </div>
                            <div id="accordion_q2" class="collapse" role="tabpanel" aria-labelledby="accordion_h2" data-bs-parent="#accordion">
                                <div class="block-content">
                                    <p>•	ESCRITURAS DE PROPIEDAD</p>
                                    <p>•	DNI VENDEDORES</p>
                                    <p>•	DNI COMPRADORES</p>
                                    <p>•	NOTA SIMPLE</p>
                                    <p>•	PROPUESTA CONTRATO DE COMPRAVENTA</p>
                                    <p>•	CONTRATO DE ARRAS</p>
                                    <p>•	JUSTIFICANTE TRANSFERENCIAS ARRAS</p>
                                    <p>•	CERTIFICADO + ETIQUETA ENERGÉTICA</p>
                                    <p>•	CERTIFICADO DE TITULARIDAD CUENTA BANCARIA</p>
                                    <p>•	CERTIFICADO COMUNIDAD DE PROPIETARIOS</p>
                                    <p>•	RECIBO IBI AÑO EN CURSO</p>
                                    <p>•	PROVISIÓN DE FONDOS</p>
                                    <p>•	ESTADOS CIVILES COMPRADOR/ VENDEDOR</p>
                                    <p>•	PROFESIONES COMPRADOR/ VENDEDOR</p>
                                    <p>•	VERIFICACIÓN DEUDA IBI ÚLTIMOS 5 AÑOS</p>
                                    <p>•	VERIFICACIÓN IMPORTE RECIBO, DEUDAS Y DERRAMAS DE COMUNIDAD DE PROPIETARIOS.</p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="row_table_visitas">
                    <br>
                    <br>
                    <br>
                    <table class="table table-hover table-vcenter" id="table_visitas">
                        <span class="nav-main-link-name">Visitas</span>
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Apellido</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Correo</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
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

    <div class="modal" id="vDetailModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <!-- <div class="modal-dialog" role="document">
            <div class="modal-content"> -->
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> -->
               
            <!-- </div>
        </div> -->
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
            getVisitas('{{ $propietarios->inmuebleid }}');
        });

        $("#formVisita").submit(async function(e){
            e.preventDefault();
            await saveVisitas();
            return false;
        });

        function addVisita(){
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#correo').val('');
            $('#agendaModal').modal('show');
        }

        async function getVisitas(idInmueble) {
            try{
                $('#inmueble_id').val(idInmueble);
                let resp = await request(`/visitas/${idInmueble}`,'get');

                if(resp.status = 'success'){
                    if(resp.data.length == 0){
                        $("#table_visitas tbody").empty();
                        $('#row_table_visitas').hide();
                        return;
                    }

                    llenarTabla(resp.data);
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

                let resp = await request(`/visitas`,'post', data);
                if(resp.status = 'success'){
                    if(resp.data.length == 0){
                        $("#table_visitas tbody").empty();
                        $('#row_table_visitas').hide();
                        return;
                    }
                    hideLoadingVisitas();
                    llenarTabla(resp.data);
                    Swal.fire(resp.title,resp.msg,resp.status);
                    $('#agendaModal').modal('hide');
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
            let count = 1;
            data.forEach((item) =>{
                newRowContent = `
                    <tr>
                        <td class="text-center">
                            ${count}
                        </td>
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
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-secondary" title="Ver" onclick="detailVisita()" data-toggle="modal" data-target="#vDetailModal">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                $("#table_visitas tbody").append(newRowContent);
                count++;
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
