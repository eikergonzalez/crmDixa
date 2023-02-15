@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Noticias
                </h3>
            </div>
            <div class="block-content">  
                @if(Auth::user()->rol_id <> 4)
                    <div class="col-sm-6 col-xl-4">
                        <button type="button" class="btn btn-secondary" onclick="addNewNoticia()">Nuevo</button>
                        <div class="mt-2">
                        </div>
                    </div>
                @endif
                <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Telefono</th>
                            <th>Direccion</th>
                            <th>Precio</th>
                            <th>Tipo Solicitud</th>
                            <th class="text-center" style="width: 100px;">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($propietarios as $propietario)
                        <tr>
                            <th class="text-center" scope="row">{{$propietario->propietarioid}}</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->nombre}} </a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->apellido}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->telefono}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->direccion}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $propietario->precio_solicitado, 'EUR') }}</a>
                            </td>
                            <td class="d-none d-sm-table-cell">
                            <span class="badge bg-warning">{{$propietario->solicitud}}</span>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver" onclick="detailNoticias( {{ $propietario->propietarioid }} )">
                                <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar" onclick="editNoticias( {{ $propietario->propietarioid }} )">
                                <i class="fa fa-edit"></i>
                                </button>
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

    <div class="modal fade" id="noticiaModal" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Noticias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/noticias" method="post" autocomplete="off" onsubmit="return unsetMoney()">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="id_inmueble" name="id_inmueble" value="">
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
                            <label for="direccion" class="col-form-label">Direccion</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="precio_solicitado" class="col-form-label">Precio</label>
                            <input type="text" class="form-control" id="precio_solicitado" name="precio_solicitado" required placeholder="Indique su precio ">
                        </div>
                        <div class="form-group">
                            <label for="tipo_solicitud">Tipo de Solicitud</label>
                            <select class="js-select2 form-select" id="tipo_solicitud" name="tipo_solicitud" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                @foreach($tipoSolicitudes as $solcitudes)
                                    <option value="{{ $solcitudes->id }}">{{ $solcitudes->codigo }}-{{ $solcitudes->descripcion }}</option>
                                @endforeach
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
                        <button type="submit" class="btn btn-primary">Guardar</button>
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
            $('#tipo_solicitud').select2({dropdownParent: $('#noticiaModal')});
            $('#accion').select2({dropdownParent: $('#noticiaModal')});
            $('#precio_solicitado').maskMoney({suffix:'€'});
        });

        function unsetMoney() {
            $('#precio_solicitado').val($('#precio_solicitado').maskMoney('unmasked')[0]);
        }

        function addNewNoticia() {
            $('#label').html("Agregar Noticias");
            $('#id').val('');
            $('#id_inmueble').val('');
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#direccion').val('');
            $('#precio_solicitado').val('');
            $('#tipo_solicitud').val('').change();
            $('#accion').val('').change();
            $('#observacion').val('');
            $('#noticiaModal').modal('show');
        }

        function editNoticias(id){
            let noticia = _.find(noticias, function(o) { return o.propietarioid == id; }); 
            $('#label').html("Editar Noticias");
            $('#id').val(noticia.propietarioid);
            $('#id_inmueble').val(noticia.inmuebleid);
            $('#nombre').val(noticia.nombre);
            $('#apellido').val(noticia.apellido);
            $('#telefono').val(noticia.telefono);
            $('#direccion').val(noticia.direccion);
            $('#precio_solicitado').val(noticia.precio_solicitado);
            $('#tipo_solicitud').val(noticia.tipo_solicitud).change();
            $('#accion').val(noticia.accion).change();
            $('#observacion').val(noticia.observacion);
            $('#noticiaModal').modal('show');
        }

        function detailNoticias(id){
            let noticia = _.find(noticias, function(o) { return o.propietarioid == id; });
            console.log(noticia);
            let content = `
                <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
                <p><strong>Nombre y Apellido:&nbsp; &nbsp; </strong><span>${noticia.nombre} ${noticia.apellido}</span></p>
                <p><strong>Telefono:&nbsp; &nbsp; </strong><span>${noticia.telefono}</span></p>
                <p><strong>Direccion:&nbsp; &nbsp; </strong><span>${noticia.direccion}</span></p>
                <p><strong>Precio:&nbsp; &nbsp; </strong><span>${amountFormat(noticia.precio_solicitado)}</span></p>
                <p><strong>Tipo de Solicitud:&nbsp; &nbsp; </strong><span>${noticia.solicitud}</span></p>
                <p><strong>Observaciones:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(noticia.observacion)) ? noticia.observacion : ''}</span></p>
                <p><strong>Accion:&nbsp; &nbsp; </strong><span>${noticia.estatus}</span></p>
                `;

            $('#detalleNoticia').empty();
            $('#detalleNoticia').append(content);
            $('#detalleNoticias').modal('show');
        }
    </script>
@endsection
