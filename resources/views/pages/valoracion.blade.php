@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Valoración
                </h3>
            </div>
            <div class="block-content">
                @if(Auth::user()->rol_id <> 4)
                    <div class="col-sm-6 col-xl-4">
                        <button type="button" class="btn btn-secondary" onclick="addNewValoracion()">Nuevo</button>
                        <div class="mt-2">
                        </div>
                    </div>
                @endif
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
                        <tr>
                            <th class="text-center" scope="row">{{$propietario->id}}</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->direccion}} </a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->solicitud}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->nombre}} - {{$propietario->apellido}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html"></a>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver">
                                <i class="fa fa-eye"></i>
                                </button>
                                <!-- <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar">
                                <i class="fa fa-edit"></i>
                                </button> -->
                                <!-- <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Eliminar">
                                <i class="fa fa-trash-alt"></i>
                                </button> -->
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

    <div class="modal fade" id="valoracionModal" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Valoracion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/noticias" method="post" autocomplete="off" onsubmit="unsetMoney()">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group">
                            <label for="type_request">Tipo de Solicitud</label>
                            <select class="js-select2 form-select" id="tipo_solicitud" name="tipo_solicitud" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                @foreach($tipoSolicitudes as $solcitudes)
                                    <option value="{{ $solcitudes->id }}">{{ $solcitudes->codigo }}-{{ $solcitudes->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nombre" class="col-form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required placeholder="Indique su nombre">
                        </div>
                        <div class="form-group">
                            <label for="apellido" class="col-form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="apellido" required placeholder="Indique su apellido">
                        </div>
                        <div class="form-group">
                            <label for="telefono" class="col-form-label">Telefono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required placeholder="Indique su telefono">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo Electronico</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Indique su Correo Electronico">
                        </div>
                        <div class="form-group">
                            <label for="direccion" class="col-form-label">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="precio_valorado" class="col-form-label">Precio Valorado</label>
                            <input type="text" class="form-control" id="precio_valorado" name="precio_valorado" required placeholder="Indique su precio valorado ">
                        </div>
                        <div class="form-group">
                            <label for="precio_solicitado" class="col-form-label">Precio Solicitado</label>
                            <input type="text" class="form-control" id="precio_solicitado" name="precio_solicitado" required placeholder="Indique su precio solicitado ">
                        </div>
                        <div class="form-group">
                            <label for="metros_utiles" class="col-form-label">Metros Utiles</label>
                            <input type="text" class="form-control" id="metros_utiles" name="metros_utiles" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="metros_usados" class="col-form-label">Metros Construidos</label>
                            <input type="text" class="form-control" id="metros_usados" name="metros_usados" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="ascensor">Ascensor</label>
                            <select class="js-select2 form-select" id="ascensor" name="ascensor" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tipo_inmueble">Tipo Inmueble</label>
                            <select class="js-select2 form-select" id="tipo_inmueble" name="tipo_inmueble" style="width: 100%;" required data-placeholder="Seleccione...">
                                @foreach($tipo_inmueble as $tp)
                                    <option value="{{ $tp->id }}">{{ $tp->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type_request">Reforma</label>
                            <select class="js-select2 form-select" id="reforma" name="reforma" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type_request">Exposicion</label>
                            <select class="js-select2 form-select" id="exposicion" name="exposicion" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="IN">Interior</option>
                                <option value="EX">Exterior</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="habitaciones" class="col-form-label">N&deg; Habitaciones </label>
                            <input type="text" class="form-control" id="habitaciones" name="habitaciones" required placeholder="Indique su numero de habitaciones">
                        </div>
                        <div class="form-group">
                            <label for="hipoteca">Hipoteca</label>
                            <select class="js-select2 form-select" id="hipoteca" name="hipoteca" style="width: 100%;" required data-placeholder="Seleccione..." onclick="valorHipoteca()" >
                                <option value="">Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="form-group" id="valor_hipoteca">
                            <label for="hipoteca_valor" class="col-form-label">Hipoteca Valor</label>
                            <input type="text" class="form-control" id="hipoteca_valor" name="hipoteca_valor" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="herencia">Herencia</label>
                            <select class="js-select2 form-select" id="herencia" name="herencia" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="col-form-label" for="observacion">Observaciones</label>
                            <textarea class="form-control" id="observacion" name="observacion" rows="4" placeholder="Indique aqui sus observaciones"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="accion">Accion</label>
                            <select class="js-select2 form-select" id="accion" name="accion" style="width: 100%;" required data-placeholder="Seleccione...">
                            <option value="">Seleccione...</option>
                                @foreach($estatus as $stat)
                                    <option value="{{ $stat->id }}">{{ $stat->codigo }}-{{ $stat->descripcion }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary" onclick="unsetMoney()">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalleNoticias" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalles de Noticias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-1" id="detalleNoticia">
                    
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
       var noticias = {{ Js::from($propietarios) }};
        $(document).ready(function() {
            $('#ascensor').select2({dropdownParent: $('#valoracionModal')});
            $('#tipo_inmueble').select2({dropdownParent: $('#valoracionModal')});
            $('#reforma').select2({dropdownParent: $('#valoracionModal')});
            $('#exposicion').select2({dropdownParent: $('#valoracionModal')});
            $('#hipoteca').select2({dropdownParent: $('#valoracionModal')});
            $('#herencia').select2({dropdownParent: $('#valoracionModal')});
            $('#tipo_solicitud').select2({dropdownParent: $('#valoracionModal')});
            $('#accion').select2({dropdownParent: $('#valoracionModal')});
            $('#precio_solicitado').maskMoney({suffix:'€'});
            $('#precio_valorado').maskMoney({suffix:'€'});
            $('#valor_hipoteca').hide();
        });

        function valorHipoteca() {
            let valor = $('#hipoteca').val();
            alert(valor);

            if(valor=='SI'){
                $('#valor_hipoteca').show();
            }else{
                $('#valor_hipoteca').hide();
            }
                
        }

        function unsetMoney() {
            $('#precio_solicitado').val($('#precio_solicitado').maskMoney('unmasked')[0]);
            $('#precio_valorado').val($('#precio_valorado').maskMoney('unmasked')[0]);
        }

        function addNewValoracion() {
            let noticia = _.find(noticias, function(o) { return o.propietarioid == id; });
            $('#label').html("Agregar Valoracion");
            $('#id').val('');
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#direccion').val('');
            $('#precio_solicitado').val('');
            $('#precio_valorado').val('');
            $('#email').val('');
            $('#metros_utiles').val('');
            $('#metros_usados').val('');
            $('#ascensor').val('').change();
            $('#tipo_inmueble').val('').change();
            $('#reforma').val('').change();
            $('#exposicion').val('').change();
            $('#hipoteca').val('').change();
            $('#hipoteca_valor').val('');
            $('#herencia').val('').change();
            $('#tipo_solicitud').val('').change();
            $('#tipo_accion').val('').change();
            $('#observacion').val('');
            $('#valoracionModal').modal('show');
        }

        function editValoracion(id){
           
            let noticia = _.find(noticias, function(o) { return o.id == id; });

            $('#label').html("Editar Noticias");
            $('#id').val(noticia.id);
            $('#fname').val(noticia.fname);
            $('#lname').val(noticia.lname);
            $('#phone').val(noticia.phone);
            $('#address').val(noticia.address);
            $('#price').val(noticia.price);
            $('#type_request').val(noticia.type_request).change();
            $('#type_action').val(noticia.type_action).change();
            $('#observations').val(noticia.observations);
            $('#noticiaModal').modal('show');
        }

        function detailValoracion(id){
            let noticia = _.find(noticias, function(o) { return o.id == id; });
            let content = `
                <p><strong>Tipo de Solicitud:&nbsp; &nbsp; </strong><span>${noticia.type_request}</span></p>
                <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
                <p><strong>Nombre y Apellido:&nbsp; &nbsp; </strong><span>${dataJson.fname} ${dataJson.lname}</span></p>
                <p><strong>Telefono:&nbsp; &nbsp; </strong><span>${dataJson.phone}</span></p>
                <p><strong>Correo Electronico:&nbsp; &nbsp; </strong><span>${dataJson.correo}</span></p>
                <p><strong>Direccion:&nbsp; &nbsp; </strong><span>${dataJson.address}</span></p>
                <p><strong>Precio Valorado:&nbsp; &nbsp; </strong><span>${amountFormat(dataJson.price_value)}</span></p>
                <p><strong>Precio Solicitado:&nbsp; &nbsp; </strong><span>${amountFormat(dataJson.price)}</span></p>
                <p><strong>Observaciones:&nbsp; &nbsp; </strong><span>${dataJson.observations}</span></p>
                <p><strong>Accion:&nbsp; &nbsp; </strong><span>${noticia.type_action}</span></p>
                `;

            $('#detalleNoticia').empty();
            $('#detalleNoticia').append(content);
            $('#detalleNoticias').modal('show');
        }
    </script>
@endsection
