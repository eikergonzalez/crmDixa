@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="fa-fa-arrow-left block-title">
                    <a class="nav-main-link{{ request()->is('pedidos-detalle') ? ' active' : '' }}" href="/pedidos">
                        <i class="nav-main-link-icon far fa fa-arrow-left"></i>
                        <span class="nav-main-link-name"> Pedidos - Zona Interesada</span>
                    </a>
                </h3>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Rebajas" onclick="getDeBaja({{ $pedidos->pedidoid }})">
                        <i class="fa fa-briefcase"> De Baja</i>
                    </button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Añadir Visitas" onclick="addOferta({{ $pedidos->pedidoid }})"> 
                        <i class="fa fa-plus"> Añadir Oferta</i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><b> Tipo de Solicitud: </b> {{ $pedidos -> tipo_solicitud}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Nombre: </b> {{ $pedidos -> nombre}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Apellido: </b> {{ $pedidos -> apellido}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Telefono: </b> {{ $pedidos -> telefono}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Correo Electronico: </b> {{ $pedidos -> correo_electronico}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Zona Interesada: </b> {{ $pedidos -> zona_interesada}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Precio: </b> {{ $pedidos -> precio}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Metros Cuadrados: </b> {{ $pedidos -> metros_cuadrados}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Ascensor: </b> {{ $pedidos -> ascensor}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Tipo Inmueble: </b> {{ $pedidos -> tipo_inmueble}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Reforma: </b> {{ $pedidos -> reforma}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Exposicion: </b> {{ $pedidos -> exposicion}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Terraza: </b> {{ $pedidos -> terraza}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Habitaciones: </b> {{ $pedidos -> habitaciones}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Forma de Pago: </b> {{ $pedidos -> forma_de_pago}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Estatus: </b> {{ $pedidos -> estatus}} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Observaciones: </b> {{ $pedidos -> observacion}} </p>
                            </div>
                        </div>
                    </div>

                <div class="table-responsive" id="row_table_ofertas">
                    <br>
                    <br>
                    <br>
                    <table class="table table-hover table-vcenter" id="table_ofertas">
                        <span class="nav-main-link-name">Ofertas</span>
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

                <div class="table-responsive" id="row_table_sugerencias">
                    <br>
                    <br>
                    <br>
                    <table class="table table-hover table-vcenter" id="table_sugerencias">
                        <span class="nav-main-link-name">Sugerencias</span>
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
    <div class="modal" id="ofertaModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Ofertas</h5>
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
                        <button type="submit" class="btn btn-primary button_save_visitas" >Guardar</button>
                        <a class="btn btn-primary button_loading_visitas" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal" id="deBajaModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Dar de Baja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" autocomplete="off" id="formDeBaja">
                    {{ csrf_field() }}
                    <input type="hidden" id="pedidoid" name="pedidoid">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-9 pb-3">
                                <div class="form-group">
                                    <label for="accion">Dar de Baja</label>
                                    <select class="js-select2 form-select" id="estatus" name="estatus" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        @foreach($debaja as $stat)
                                            <option value="{{ $stat->id }}">{{ $stat->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="form-group">
                                    <label for="nombre">Motivo</label>
                                    <textarea class="form-control" id="motivo_de_baja" name="motivo_de_baja" rows="3" cols="5" placeholder="Indique aqui su motivo"></textarea>
                                </div>
                            </div>
                        </div>                       
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="button" class="btn btn-primary button_save_pedidos" onclick="darDeBaja()">Guardar</button>
                        <a class="btn btn-primary button_loading_pedidos" type="button" disabled>
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
            $('#estatus').select2({dropdownParent: $('#pedidosModal')});
            $('#ofertaModal').modal({backdrop: 'static'});
            $('#deBajaModal').modal({backdrop: 'static'});
            hideLoading();
            $('#estatus').prop('disabled','true'); 
            $('#estatus option[value=""]').remove();
           
        });

        function getDeBaja(id) {
            //alert(id);
            $('#deBajaModal').modal('show');
            $('#pedidoid').val(id);
          
        }

        function hideLoading() {
            $('.button_loading_pedidos').hide();
            $('.button_save').show();
        }

        async function darDeBaja() {
            var id = $('#pedidoid').val(1);
            alert(id);
            Swal.fire({
                title: '¿Está de acuerdo en dar de baja este pedido?',
                text: " ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C62D2D',
                confirmButtonText: 'Si',
                cancelButtonText: 'No ',
            }).then(async (result) => {
                if (result.value) {
                    try{

                        console.log("paso aqui");
                        let resp = await request(`pedidos/dardebaja/${id}`,'dardebaja');
                        if(resp.status = 'success'){
                        
                            Swal.fire({
                                title: resp.title,
                                text: resp.msg,
                                icon: resp.status,
                                confirmButtonText: 'Ok',
                            });
                        }
                    }catch (error) {
                        Swal.fire(error.title,error.msg,error.status);
                    }
                }
            });
        }

    </script>
@endsection
