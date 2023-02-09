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
                        @foreach($noticias as $noticia)
                        <tr>
                            <th class="text-center" scope="row">{{$noticia->id}}</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$noticia->getData()->address}} </a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html"></a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$noticia->getData()->fname}} - {{$noticia->getData()->lname}}</a>
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
                            <select class="js-select2 form-select" id="type_request" name="type_request" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="VE">VENTA</option>
                                <option value="AL">ALQUILER</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="fname" class="col-form-label">Nombre</label>
                            <input type="text" class="form-control" id="fname" name="fname" required placeholder="Indique su nombre">
                        </div>
                        <div class="form-group">
                            <label for="lname" class="col-form-label">Apellido</label>
                            <input type="text" class="form-control" id="lname" name="lname" required placeholder="Indique su apellido">
                        </div>
                        <div class="form-group">
                            <label for="phone" class="col-form-label">Telefono</label>
                            <input type="text" class="form-control" id="phone" name="phone" required placeholder="Indique su telefono">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo Electronico</label>
                            <input type="email" class="form-control" id="correo" name="correo" required placeholder="Indique su Correo Electronico">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Direccion</label>
                            <input type="text" class="form-control" id="address" name="address" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-form-label">Precio Valorado</label>
                            <input type="text" class="form-control" id="price_value" name="price_value" required placeholder="Indique su precio valorado ">
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-form-label">Precio Solicitado</label>
                            <input type="text" class="form-control" id="price" name="price" required placeholder="Indique su precio solicitado ">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Metros Utiles</label>
                            <input type="text" class="form-control" id="mtutiles" name="mtutiles" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="address" class="col-form-label">Metros Construidos</label>
                            <input type="text" class="form-control" id="mtconstruidos" name="mtconstruidos" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="type_request">Ascensor</label>
                            <select class="js-select2 form-select" id="ascensor" name="ascensor" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tinmueble">Tipo Inmueble</label>
                            <select class="js-select2 form-select" id="tinmueble" name="tinmueble" style="width: 100%;" required data-placeholder="Seleccione...">
                                @foreach($tipo_inmueble as $tp)
                                    <option value="{{ $tp->id }}">{{ $tp->descripcion }}</option>
                                @endforeach
                                <!-- <option value="">Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option> -->
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
                            <label for="nhabitaciones" class="col-form-label">N Habitaciones </label>
                            <input type="text" class="form-control" id="nhabitaciones" name="nhabitaciones" required placeholder="Indique su numero de habitaciones">
                        </div>
                        <div class="form-group">
                            <label for="hipoteca">Hipoteca</label>
                            <select class="js-select2 form-select" id="hipoteca" name="hipoteca" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="SI">SI</option>
                                <option value="NO">NO</option>
                            </select>
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
                            <label class="col-form-label" for="observations">Observaciones</label>
                            <textarea class="form-control" id="observations" name="observations" rows="4" placeholder="Indique aqui sus observaciones"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="type_request">Accion</label>
                            <select class="js-select2 form-select" id="type_action" name="type_action" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="ES">En Seguimiento</option>
                                <option value="EN">Encargo</option>
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
        var noticias = {{ Js::from($noticias) }};
        $(document).ready(function() {
            $('#ascensor').select2({dropdownParent: $('#valoracionModal')});
            $('#tinmueble').select2({dropdownParent: $('#valoracionModal')});
            $('#reforma').select2({dropdownParent: $('#valoracionModal')});
            $('#exposicion').select2({dropdownParent: $('#valoracionModal')});
            $('#hipoteca').select2({dropdownParent: $('#valoracionModal')});
            $('#herencia').select2({dropdownParent: $('#valoracionModal')});
            $('#type_request').select2({dropdownParent: $('#valoracionModal')});
            $('#type_action').select2({dropdownParent: $('#valoracionModal')});
            $('#price').maskMoney({suffix:'€'});
            $('#price_value').maskMoney({suffix:'€'});
        });

        function unsetMoney() {
            $('#price').val($('#price').maskMoney('unmasked')[0]);
            $('#price_value').val($('#price_value').maskMoney('unmasked')[0]);
        }

        function addNewValoracion() {
            let noticia = _.find(noticias, function(o) { return o.id == id; });
            let dataJson = JSON.parse(noticia.data_json); 
            $('#label').html("Agregar Valoracion");
            $('#id').val('');
            $('#fname').val('');
            $('#lname').val('');
            $('#phone').val('');
            $('#address').val('');
            $('#price').val('');
            $('#price_value').val('');
            $('#correo').val('');
            $('#mutiles').val('');
            $('#mconstruidos').val('');
            $('#ascensor').val('').change();
            $('#tinmueble').val('').change();
            $('#reforma').val('').change();
            $('#exposicion').val('').change();
            $('#hipoteca').val('').change();
            $('#herencia').val('').change();
            $('#type_request').val('').change();
            $('#type_action').val('').change();
            $('#observations').val('');
            $('#valoracionModal').modal('show');
        }

        function editValoracion(id){
           
            let noticia = _.find(noticias, function(o) { return o.id == id; });
            let dataJson = JSON.parse(noticia.data_json); 
            $('#label').html("Editar Noticias");
            $('#id').val(noticia.id);
            $('#fname').val(dataJson.fname);
            $('#lname').val(dataJson.lname);
            $('#phone').val(dataJson.phone);
            $('#address').val(dataJson.address);
            $('#price').val(dataJson.price);
            $('#type_request').val(noticia.type_request).change();
            $('#type_action').val(noticia.type_action).change();
            $('#observations').val(dataJson.observations);
            $('#noticiaModal').modal('show');
        }

        function detailValoracion(id){
            let noticia = _.find(noticias, function(o) { return o.id == id; });
            let dataJson = JSON.parse(noticia.data_json); 
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
