@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Pedidos
                </h3>
            </div>
            <div class="block-content">
                @if(Auth::user()->rol_id <> 4)
                    <div class="col-sm-6 col-xl-4">
                        <button type="button" class="btn btn-secondary" onclick="addNewPedidos()">Nuevo</button>
                        <div class="mt-2">
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Tipo Solicitud</th>
                            <th>Nombre y Apellido</th>
                            <th>Estatus</th>
                            <th class="text-center" style="width: 100px;">Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($pedidos as $pedido)
                        <tr>
                            <th class="text-center" scope="row">{{$pedido->pedidoid}}</th>
                            <td class="d-none d-sm-table-cell">
                            <span class="badge bg-warning">{{$pedido->tipo_solicitud}}</span>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$pedido->nombre}} - {{$pedido->apellido}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$pedido->estatus}}</a>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                                @if(Auth::user()->rol_id <> 4)
                                    <a class="btn btn-sm" href="/pedidos/detalle/{{ $pedido->pedidoid }}" title="Ver detalle">
                                        <i class="nav-main-link-icon far fa fa-eye"></i>
                                    </a>
                                    <a type="button" class="btn btn-sm btn-alt-secondary" title="Visitas" onclick="editPedidos({{ $pedido->pedidoid }})">
                                        <i class="fa fa-edit"></i>
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
    </div>

    <!-- Modal Agregar Pedidos -->
    <div class="modal" id="pedidosModal" role="dialog" aria-labelledby="modal-default-extra-large" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Pedido</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/pedidos" method="post" autocomplete="off" onsubmit="unsetMoney()" id="form_pedidos">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="row">
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="type_request">Tipo de Solicitud</label>
                                    <select class="js-select2 form-select" id="tipo_solicitud" name="tipo_solicitud" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        @foreach($tipoSolicitudes as $solcitudes)
                                            <option value="{{ $solcitudes->id }}">{{ $solcitudes->codigo }}-{{ $solcitudes->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Indique su nombre">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" required placeholder="Indique su apellido">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="email" >Telefono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required placeholder="Indique su Telefono">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="email" >Correo Electronico</label>
                                    <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required placeholder="Indique su Correo Electronico">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="direccion" >Zona Interesada</label>
                                    <input type="text" class="form-control" id="zona_interesada" name="zona_interesada" required placeholder="Indique su zona de interes">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="precio_solicitado" >Precio</label>
                                    <input type="text" class="form-control" id="precio" name="precio" required placeholder="Indique su precio ">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="metros_utiles" >Metros Cuadrados</label>
                                    <input type="text" class="form-control" id="metros_cuadrados" name="metros_cuadrados" required placeholder="Indique Metros Cuadrados">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="ascensor">Ascensor</label>
                                    <select class="js-select2 form-select" id="ascensor" name="ascensor" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="tipo_inmueble">Tipo Inmueble</label>
                                    <select class="js-select2 form-select" id="tipo_inmueble" name="tipo_inmueble" style="width: 100%;" required data-placeholder="Seleccione...">
                                        @foreach($tipo_inmueble as $tp)
                                            <option value="{{ $tp->id }}">{{ $tp->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="type_request">Reforma</label>
                                    <select class="js-select2 form-select" id="reforma" name="reforma" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="type_request">Exposicion</label>
                                    <select class="js-select2 form-select" id="exposicion" name="exposicion" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        <option value="IN">Interior</option>
                                        <option value="EX">Exterior</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="type_request">Terraza</label>
                                    <select class="js-select2 form-select" id="terraza" name="terraza" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="habitaciones" >N&deg; Habitaciones </label>
                                    <input type="text" class="form-control" id="habitaciones" name="habitaciones" required placeholder="Indique su numero de habitaciones">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="formapago">Forma de Pago</label>
                                    <select class="js-select2 form-select" id="forma_de_pago" name="forma_de_pago" style="width: 100%;" required data-placeholder="Seleccione...">
                                    <option value="">Seleccione...</option>
                                        @foreach($formadepago as $fdp)
                                            <option value="{{ $fdp->id }}">{{ $fdp->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="estatus">Estatus</label>
                                    <select class="js-select2 form-select" id="estatus" name="estatus" style="width: 100%;" required data-placeholder="Seleccione...">
                                    <option value="">Seleccione...</option>
                                        @foreach($stat as $stats)
                                            <option value="{{ $stats->id }}">{{ $stats->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label  for="observacion">Observaciones</label>
                                    <textarea class="form-control" id="observacion" name="observacion" rows="4" placeholder="Indique aqui sus observaciones"></textarea>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                    <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary button_save">Guardar</button>
                        <a class="btn btn-primary button_loading" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var pedidos = {{ Js::from($pedidos) }};
        $(document).ready(function() {
            $('#pedidosModal').modal({backdrop: 'static'});
            $('#tipo_solicitud').select2({dropdownParent: $('#pedidosModal')});
            $('#forma_de_pago').select2({dropdownParent: $('#pedidosModal')});
            $('#estatus').select2({dropdownParent: $('#pedidosModal')});
            $('#ascensor').select2({dropdownParent: $('#pedidosModal')});
            $('#tipo_inmueble').select2({dropdownParent: $('#pedidosModal')});
            $('#reforma').select2({dropdownParent: $('#pedidosModal')});
            $('#exposicion').select2({dropdownParent: $('#pedidosModal')});
            $('#terraza').select2({dropdownParent: $('#pedidosModal')});
            $('#estatus').select2({dropdownParent: $('#pedidosModal')});
            $('#precio').maskMoney({suffix:'€'});
            hideLoading();
        });

        function addNewPedidos() {
            $('#label').html("Agregar Pedido");
            $('#id').val('');
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#correo_electronico').val('');
            $('#zona_interesada').val('');
            $('#precio').val('');
            $('#metros_cuadrados').val('');
            $('#ascensor').val('').change();
            $('#tipo_inmueble').val('').change();
            $('#reforma').val('').change();
            $('#exposicion').val('').change();
            $('#habitaciones').val('').change();
            $('#terraza').val('').change();
            $('#tipo_solicitud').val('').change();
            $('#forma_de_pago').val('').change();
            $('#estatus').val('').change();
            $('#observacion').val('');
            $('#pedidosModal').modal('show');
        }

        $("#form_pedidos").submit(function(e){
            let precio = $('#precio').maskMoney('unmasked')[0];
            $('#precio').maskMoney('destroy');
            $('#precio').val(precio);
            showLoading();
            return true;
        });


        function editPedidos(id){
            let pedido = _.find(pedidos, function(o) { 
                return o.pedidoid == id; 
            });
            $('#label').html("Editar Pedidos");
            $('#id').val(pedido.pedidoid);
            $('#tipo_solicitud').val(pedido.idtipo_solicitud).change();
            $('#nombre').val(pedido.nombre);
            $('#apellido').val(pedido.apellido);
            $('#telefono').val(pedido.telefono);
            $('#correo_electronico').val(pedido.correo_electronico);
            $('#zona_interesada').val(pedido.zona_interesada);
            $('#precio').val(pedido.precio);
            $('#metros_cuadrados').val(pedido.metros_cuadrados);
            $('#ascensor').val(pedido.ascensor).change();
            $('#tipo_inmueble').val(pedido.idtipo_inmueble).change();
            $('#reforma').val(pedido.reforma).change();
            $('#exposicion').val(pedido.exposicion).change();
            $('#habitaciones').val(pedido.habitaciones).change();
            $('#terraza').val(pedido.terraza).change();
            $('#forma_de_pago').val(pedido.idforma_de_pago).change();
            $('#estatus').val(pedido.idestatus).change();
            $('#observacion').val(pedido.observacion);
            $('#pedidosModal').modal('show');
        }

        function showLoading() {
            $('.button_loading').show();
            $('.button_save').hide();
        }

        function hideLoading() {
            $('.button_loading').hide();
            $('.button_save').show();
        }

    </script>
@endsection
