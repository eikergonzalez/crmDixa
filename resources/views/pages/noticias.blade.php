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
                        <button type="button" class="btn btn-secondary" onclick="addNewNoticia()" data-toggle="modal" data-target="#noticiaModal">Nuevo</button>
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
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar" onclick="editNoticias( {{ $propietario->propietarioid }} )" data-toggle="modal" data-target="#noticiaModal">
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

    <div class="modal fade" id="noticiaModal" tabindex="-1" role="dialog" aria-labelledby="modal-default-large" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Noticias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/noticias" method="post" autocomplete="off" onsubmit="return unsetMoney()">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="id_inmueble" name="id_inmueble" value="">
                        <input type="hidden" id="id_agenda" name="id_agenda" value="">
                        <input type="hidden" id="agenda_titulo" name="agenda_titulo" value="">
                        <input type="hidden" id="agenda_descri" name="agenda_descri" value="">
                        <input type="hidden" id="agenda_fecha" name="agenda_fecha" value="">
                        <div class="row">
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
                                    <label for="telefono">Telefono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required placeholder="Indique su telefono">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="direccion">Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Indique su Direccion">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="precio_solicitado">Precio</label>
                                    <input type="text" class="form-control" id="precio_solicitado" name="precio_solicitado" required placeholder="Indique su precio ">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="tipo_solicitud">Tipo de Solicitud</label>
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
                                    <label for="accion">Accion</label>
                                    <select class="js-select2 form-select" id="accion" name="accion" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        @foreach($estatus as $stat)
                                            <option value="{{ $stat->id }}">{{ $stat->codigo }}-{{ $stat->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-2 col-offset-4 pb-3">
                                <div class="form-group pt-4">
                                    <a type="button" class="btn btn-info text-light btn-lg" onclick="openModalAgenda()">
                                        <i class="fa fa-fw fa-calendar-alt me-1"></i>Agenda
                                    </a>
                                </div>
                            </div>
                            <div class="col-sm-6 pb-3">
                                <div class="form-group">
                                    <label for="observacion">Observaciones</label>
                                    <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Indique aqui sus observaciones"></textarea>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary" id="btn-save-noticia">Guardar</button>
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

    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar evento</h5>
                    <button type="button" class="btn-close" onclick="closeModalAgenda();"></button>
                </div>
                <form action="/agenda" method="post" autocomplete="off" id="formAgenda">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <div class="form-group">
                            <label for="age_titulo" class="col-form-label">Título</label>
                            <input type="text" class="form-control" id="age_titulo" name="age_titulo" required placeholder="Indique el título del evento">
                        </div>
                        <div class="form-group">
                            <label for="age_descri" class="col-form-label">Descripción</label>
                            <textarea class="form-control" id="age_descri" name="age_descri" rows="4" placeholder="Indique la descripción del evento"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="age_fecha" class="col-form-label">Fecha</label>
                            <input type="text" class="js-flatpickr form-control" id="age_fecha" name="age_fecha" placeholder="d/m/Y" data-date-format="d/m/Y">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" onclick="closeModalAgenda();">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var noticias = {{ Js::from($propietarios) }};

        $(document).ready(function() {
            $('#tipo_solicitud').select2({dropdownParent: $('#noticiaModal')});
            $('#accion').select2({dropdownParent: $('#noticiaModal')});
            $('#precio_solicitado').maskMoney({suffix:'€'});
            $('#noticiaModal').modal({
                    backdrop: 'static'
            })
        });

        $("#formAgenda").submit(function(e){
            $('#agenda_titulo').val($('#age_titulo').val());
            $('#agenda_descri').val($('#age_descri').val());
            $('#agenda_fecha').val($('#age_fecha').val());
            closeModalAgenda()
            return false;
        });
        $("#formAgenda").submit(function(e){
            $('#agenda_titulo').val($('#age_titulo').val());
            $('#agenda_descri').val($('#age_descri').val());
            $('#agenda_fecha').val($('#age_fecha').val());
            closeModalAgenda()
            return false;
        });

        function unsetMoney() {
            $('#precio_solicitado').val($('#precio_solicitado').maskMoney('unmasked')[0]);
            $('#btn-save-noticia').prop('disabled', true);
        }

        function addNewNoticia() {
            $('#label').html("Agregar Noticias");
            $('#id').val('');
            $('#id_inmueble').val('');
            $('#id_agenda').val('');
            $('#agenda_titulo').val('');
            $('#agenda_descri').val('');
            $('#agenda_fecha').val('');
            $('#age_titulo').val('');
            $('#age_descri').val('');
            $('#age_fecha').val('');
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
            $('#id_agenda').val(noticia.agendaid);
            $('#agenda_titulo').val(noticia.agendatitulo);
            $('#agenda_descri').val(noticia.agendadescri);
            $('#agenda_fecha').val(moment(noticia.agendafecha).format('DD/MM/YYYY'));
            $('#age_titulo').val(noticia.agendatitulo);
            $('#age_descri').val(noticia.agendadescri);
            $('#age_fecha').val(moment(noticia.agendafecha).format('DD/MM/YYYY'));
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

        async function openModalAgenda() {
            $('#noticiaModal').modal('hide');
            $('#eventModal').modal('show');
        }

        function closeModalAgenda() {
            $('#eventModal').modal('hide');
            $('#noticiaModal').modal('show');
        }
    </script>
@endsection
