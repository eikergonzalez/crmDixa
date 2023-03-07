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
                    <!-- <div class="col-sm-6 col-xl-4">
                        <button type="button" class="btn btn-secondary" onclick="addNewValoracion()">Nuevo</button>
                        <div class="mt-2">
                        </div>
                    </div> -->
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
                            <th class="text-center" scope="row">{{$propietario->propietarioid}}</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->direccion}} </a>
                            </td>
                            <td class="d-none d-sm-table-cell">
                            <span class="badge bg-warning">{{$propietario->solicitud}}</span>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->nombre}} - {{$propietario->apellido}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->estatus}}</a>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                            @if(Auth::user()->rol_id <> 4)
                                <button type="button" class="btn btn-sm btn-alt-secondary"  title="Ver" onclick="editValoracion( {{ $propietario->propietarioid }}, {{ $propietario->inmuebleid }})">
                                <i class="fa fa-eye"></i>
                                </button>
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

    <div class="modal" id="valoracionModal" role="dialog" aria-labelledby="modal-default-extra-large" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Valoracion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/valoracion" method="post" autocomplete="off" id="form_valoracon">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="id_inmueble" name="id_inmueble" value="">
                        <input type="hidden" id="id_agenda" name="id_agenda" value="">
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
                                    <label for="telefono" >Telefono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" required placeholder="Indique su telefono">
                                </div>
                             </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="email" >Correo Electronico</label>
                                    <input type="email" class="form-control" id="email" name="email" required placeholder="Indique su Correo Electronico">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="direccion" >Direccion</label>
                                    <input type="text" class="form-control" id="direccion" name="direccion" required placeholder="Indique su Direccion">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="precio_valorado" >Precio Valorado</label>
                                    <input type="text" class="form-control" id="precio_valorado" name="precio_valorado" required placeholder="Indique su precio valorado ">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="precio_solicitado" >Precio Solicitado</label>
                                    <input type="text" class="form-control" id="precio_solicitado" name="precio_solicitado" required placeholder="Indique su precio solicitado ">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="metros_utiles" >Metros Utiles</label>
                                    <input type="text" class="form-control" id="metros_utiles" name="metros_utiles" required placeholder="Indique su Direccion">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="metros_usados" >Metros Construidos</label>
                                    <input type="text" class="form-control" id="metros_usados" name="metros_usados" required placeholder="Indique su Direccion">
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
                                    <label for="habitaciones" >N&deg; Habitaciones </label>
                                    <input type="text" class="form-control" id="habitaciones" name="habitaciones" required placeholder="Indique su numero de habitaciones">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="hipoteca">Hipoteca</label>
                                    <select class="js-select2 form-select" id="hipoteca" name="hipoteca" style="width: 100%;" onchange="valorHipoteca();" required data-placeholder="Seleccione..." >
                                        <option value="">Seleccione...</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4" id="div_hipoteca_valor">
                                <div class="form-group">
                                    <label for="hipoteca_valor" >Hipoteca Valor</label>
                                    <input type="text" class="form-control" id="hipoteca_valor" name="hipoteca_valor" placeholder="Indique el valor de su hipoteca">
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="herencia">Herencia</label>
                                    <select class="js-select2 form-select" id="herencia" name="herencia" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        <option value="NO">NO</option>
                                        <option value="SI">SI</option>
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
                                    <label for="accion">Accion</label>
                                    <select class="js-select2 form-select" id="accion" name="accion" style="width: 100%;" required data-placeholder="Seleccione..." onchange="changeAction()">
                                    <option value="">Seleccione...</option>
                                        @foreach($estatus as $stat)
                                            <option value="{{ $stat->id }}">{{ $stat->descripcion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6 pb-3">
                                <div class="form-group">
                                    <label  for="observacion">Observaciones</label>
                                    <textarea class="form-control" id="observacion" name="observacion" rows="3" placeholder="Indique aqui sus observaciones"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-2 col-offset-4 pb-3">
                                <div class="form-group pt-4">
                                    <a type="button" class="btn btn-info text-light btn-lg" onclick="openModalArchivos()">
                                        <i class="fa fa-fw fa-paperclip me-1"></i>Adjuntar
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div id="div_agenda">
                            <h4>Agenda</h4>
                            <hr>

                            <div class="row">
                                <div class="col-sm-3 pb-3">
                                    <div class="form-group">
                                        <label for="age_fecha">Fecha</label>
                                        <input type="text" class="js-flatpickr form-control" id="age_fecha" name="age_fecha" placeholder="d/m/Y" data-date-format="d/m/Y">
                                    </div>
                                </div>
                                <div class="col-sm-3 pb-3">
                                    <div class="form-group">
                                        <label for="age_titulo">Título</label>
                                        <input type="text" class="form-control" id="age_titulo" name="age_titulo" placeholder="Indique el título del evento">
                                    </div>
                                </div>
                                <div class="col-sm-6 pb-3">
                                    <div class="form-group">
                                        <label for="age_descri">Descripción</label>
                                        <textarea class="form-control" id="age_descri" name="age_descri" rows="3" placeholder="Indique la descripción del evento"></textarea>
                                    </div>
                                </div>
                                
                            </div>
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

    <div class="modal fade" id="detalleValoracion" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalles de Valoracion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-1" id="detalleValoracions">
                    
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_archivo" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Archivos</h5>
                    <button type="button" class="btn-close" onclick="closeModalArchivos();"></button>
                </div>
                <form action="#" method="post" autocomplete="off" id="form_archivos">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <div class="mb-4">
                                        <label class="form-label">Tipo de archivo</label>
                                        <div class="space-x-2">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="check_imagen" name="tipo" value="imagen">
                                                <label class="form-check-label" for="check_imagen">Imagenes</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="check_archivo" name="tipo" value="archivo">
                                                <label class="form-check-label" for="check_archivo">Archivo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6" id="div_tipo_archivo">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="tipo_archivo">Tipo</label>
                                        <select class="js-select2 form-select" id="tipo_archivo" name="tipo_archivo" style="width: 100%;" data-placeholder="Seleccione...">
                                            <option value="">Seleccione...</option>
                                            @foreach($tipoArchivo as $tipo)
                                                <option value="{{ $tipo->id }}">{{ $tipo->descripcion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-4" id="div_file_document">
                                <label class="form-label" for="documento_file">Seleccionar documento</label>
                                <input class="form-control" type="file" id="documento_file" accept="application/msword,application/pdf" name="documento_file">
                            </div>
                            <div class="col-sm-6 mb-4" id="div_file_images">
                                <label class="form-label" for="images_file">Seleccionar Imagenes</label>
                                <input class="form-control" type="file" id="images_file" multiple="" accept="image/jpg, image/jpeg, image/png" name="images_file">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" onclick="closeModalArchivos();">Cerrar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var valoraciones = {{ Js::from($propietarios) }};

        $(document).ready(function() {
            $('#ascensor').select2({dropdownParent: $('#valoracionModal')});
            $('#tipo_inmueble').select2({dropdownParent: $('#valoracionModal')});
            $('#reforma').select2({dropdownParent: $('#valoracionModal')});
            $('#exposicion').select2({dropdownParent: $('#valoracionModal')});
            $('#hipoteca').select2({dropdownParent: $('#valoracionModal')});
            $('#herencia').select2({dropdownParent: $('#valoracionModal')});
            $('#tipo_solicitud').select2({dropdownParent: $('#valoracionModal')});
            $('#accion').select2({dropdownParent: $('#valoracionModal')});
            $('#estatus').select2({dropdownParent: $('#valoracionModal')});
            $('#precio_solicitado').maskMoney({suffix:'€'});
            $('#precio_valorado').maskMoney({suffix:'€'});
            $('#valoracionModal').modal({backdrop: 'static'});
            $('#tipo_archivo').select2({dropdownParent: $('#modal_archivo')});

            $('#div_tipo_archivo').hide();
            $('#div_file_document').hide();
            $('#div_file_images').hide();
        });

        $("#form_valoracon").submit(function(e){
            let precioSolicitado = $('#precio_solicitado').maskMoney('unmasked')[0];
            let precioValorado = $('#precio_valorado').maskMoney('unmasked')[0];
            $('#precio_solicitado').maskMoney('destroy');
            $('#precio_valorado').maskMoney('destroy');
            $('#precio_solicitado').val(precioSolicitado);
            $('#precio_valorado').val(precioValorado);
            return true;
        });

        $("#form_archivos").submit(function(e){
            let tipo = $("input[name='tipo']:checked").val();
            let tipo_archivo = $('#tipo_archivo').val();
            let documento_file = $('#documento_file').prop('files');
            let images_file = $('#images_file').prop('files');

            if(tipo == 'imagen' && images_file.length <= 0){
                Swal.fire('Alerta!','Debe seleccionar al menos un archivo','warning');
                return false;
            }

            if(tipo == 'archivo'){
                if(documento_file.length <= 0){
                    Swal.fire('Alerta!','Debe seleccionar un archivo','warning');
                    return false;
                }
                if(!tipo_archivo){
                    Swal.fire('Alerta!','Debe indicar el tipo de archivo','warning');
                    return false;
                }
            }
            //let tipoArchivo = $('#tipo_archivo').find(':selected').val();
            console.log(tipo);
            console.log(tipo_archivo);
            console.log(documento_file.length);
            console.log(images_file.length);
            //console.log(tipoArchivo);
            return false;
        });

        $("input[name='tipo']").change(function(){
            let opcion = this.value;

            if(opcion == 'imagen'){
                $('#div_tipo_archivo').hide();
                $('#div_file_document').hide();
                $('#div_file_images').show();
                $('#tipo_archivo').val('').change();
                $('#documento_file').val('');
                return;
            }

            $('#div_tipo_archivo').show();
            $('#div_file_document').show();
            $('#div_file_images').hide();
            $('#images_file').val('');

        });

        function addNewValoracion() {
            $('#div_agenda').hide();
            $('#label').html("Agregar Valoracion");
            $('#id').val('');
            $('#id_inmueble').val('');
            $('#id_agenda').val('');
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#direccion').val('');
            $('#precio_valorado').val('');
            $('#precio_solicitado').val('');
            $('#email').val('');
            $('#metros_utiles').val('');
            $('#metros_usados').val('');
            $('#ascensor').val('').change();
            $('#tipo_inmueble').val('').change();
            $('#reforma').val('').change();
            $('#habitaciones').val('').change();
            $('#exposicion').val('').change();
            $('#hipoteca').val('').change();
            $('#hipoteca_valor').val('');
            $('#herencia').val('').change();
            $('#tipo_solicitud').val('').change();
            $('#estatus').val('').change();
            $('#accion').val('').change();
            $('#observacion').val('');
            $('#age_fecha').val('');
            $('#age_titulo').val('');
            $('#age_descri').val('');
            $('#precio_solicitado').maskMoney({suffix:'€'});
            $('#precio_valorado').maskMoney({suffix:'€'});
            $('#valoracionModal').modal('show');
            $('#valoracionModal').modal({backdrop: 'static', keyboard: false});
        }

        function editValoracion(id, inmuebleId){
            let valoracion = _.find(valoraciones, function(o) { return o.propietarioid == id && o.inmuebleid == inmuebleId; });

            $('#div_agenda').hide();
            if(valoracion.accion == 2) $('#div_agenda').show();

            console.log(valoracion);

            $('#label').html("Editar Valoracion");
            $('#id').val(valoracion.propietarioid);
            $('#id_inmueble').val(valoracion.inmuebleid);
            $('#id_agenda').val(valoracion.agendaid);
            $('#nombre').val(valoracion.nombre);
            $('#apellido').val(valoracion.apellido);
            $('#telefono').val(valoracion.telefono);
            $('#direccion').val(valoracion.direccion);
            $('#precio_valorado').val(valoracion.precio_valorado);
            $('#precio_solicitado').val(valoracion.precio_solicitado);
            $('#email').val(valoracion.email);
            $('#metros_utiles').val(valoracion.metros_utiles);
            $('#metros_usados').val(valoracion.metros_usados);
            $('#ascensor').val(valoracion.ascensor).change();
            $('#tipo_inmueble').val(valoracion.tipo_inmueble).change();
            $('#reforma').val(valoracion.reforma).change();
            $('#habitaciones').val(valoracion.habitaciones).change();
            $('#exposicion').val(valoracion.exposicion).change();
            $('#hipoteca').val(valoracion.hipoteca).change();
            $('#hipoteca_valor').val(valoracion.hipoteca_valor);
            $('#herencia').val(valoracion.herencia).change();
            $('#tipo_solicitud').val(valoracion.tipo_solicitud).change();
            $('#estatus').val(valoracion.status).change();
            $('#accion').val(valoracion.accion).change();
            $('#observacion').val(valoracion.observacion);
            $('#age_fecha').val(valoracion.agendafecha);
            $('#age_titulo').val(valoracion.agendatitulo);
            $('#age_descri').val(valoracion.agendadescri);
            $('#precio_solicitado').maskMoney({suffix:'€'});
            $('#precio_valorado').maskMoney({suffix:'€'});
            $('#valoracionModal').modal('show');
            $('#valoracionModal').modal({backdrop: 'static', keyboard: false});
        }

        function detailValoracion(id){
            let valoracion = _.find(valoraciones, function(o) { return o.propietarioid == id; });
            let content = `
                <p><strong>Tipo de Solicitud:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.tipo_solicitud)) ? valoracion.tipo_solicitud : ''}</span></p>
                <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
                <p><strong>Nombre y Apellido:&nbsp; &nbsp; </strong><span>${valoracion.nombre} ${valoracion.apellido}</span></p>
                <p><strong>Telefono:&nbsp; &nbsp; </strong><span>${valoracion.telefono}</span></p>
                <p><strong>Correo Electronico:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.email)) ? valoracion.email : ''}</span></p>
                <p><strong>Direccion:&nbsp; &nbsp; </strong><span>${valoracion.direccion}</span></p>
                <p><strong>Precio Valorado:&nbsp; &nbsp; </strong><span>${amountFormat(valoracion.precio_valorado)}</span></p>
                <p><strong>Precio Solicitado:&nbsp; &nbsp; </strong><span>${amountFormat(valoracion.precio_solicitado)}</span></p>
                <p><strong>Observaciones:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.observacion)) ? valoracion.observacion : ''}</span></p>
                <p><strong>Metros Utiles:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.metros_utiles)) ? valoracion.metros_utiles : ''}</span></p>
                <p><strong>Metros Construidos:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.metros_usados)) ? valoracion.metros_usados : ''}</span></p>
                <p><strong>Ascensor:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.ascensor)) ? valoracion.ascensor : ''}</span></p>
                <p><strong>Tipo Inmueble:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.tipo_inmueble)) ? valoracion.tipo_inmueble : ''}</span></p>
                <p><strong>Reforma:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.reforma)) ? valoracion.reforma : ''}</span></p>
                <p><strong>Exposicion:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.exposicion)) ? valoracion.exposicion : ''}</span></p>
                <p><strong>Hipoteca:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.hipoteca)) ? valoracion.hipoteca : ''}</span></p>
                <p><strong>Hipoteca Valor:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.exposicion)) ? valoracion.exposicion : ''}</span></p>
                <p><strong>Herencia:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.herencia)) ? valoracion.herencia : ''}</span></p>
                <p><strong>Accion:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(valoracion.estatus)) ? valoracion.estatus : ''}</span></p>
                `;

            $('#detalleValoracions').empty();
            $('#detalleValoracions').append(content);
            $('#detalleValoracion').modal('show');
        }

        function valorHipoteca() {
            var valor = $('#hipoteca').find(':selected').val();
            $('#div_hipoteca_valor').hide();

            if(valor=='SI'){
                $('#div_hipoteca_valor').show();
            }
        }

        function changeAction() {
            let action = $('#accion').find(':selected').val();
            $('#div_agenda').hide();
            if(action == 2) $('#div_agenda').show();
        }

        function openModalArchivos() {
            $('#valoracionModal').modal('hide');
            $('#modal_archivo').modal('show');
        }

        function closeModalArchivos() {
            $('#modal_archivo').modal('hide');
            $('#valoracionModal').modal('show');
        }

        async function getArchivos(idInmueble) {
            
        }

        async function saveArchivo(idInmueble) {
            let type = $(`#det_type_${id}`).find(':selected').val();
            let url = $(`#det_url_${id}`).val();
            let video = $(`#det_video_${id}`).val();

            if(_.isEmpty(type)) return;

            if(type == 'url' && _.isEmpty(url)) return;

            var formData = new FormData();
            formData.append('web_id', $('#web_id1').find(':selected').val());
            formData.append('det_type', $(`#det_type_${id}`).find(':selected').val());
            formData.append('det_url',(type == 'url') ? $(`#det_url_${id}`).val() : '' );
            formData.append('det_timer', $(`#det_timer_${id}`).val());
            formData.append('det_order', $(`#det_order_${id}`).val());
            formData.append('det_status', ($(`#det_status_${id}`).is(':checked')) ? 1 : 0);
            formData.append('det_video', (type == 'video') ? $(`#det_video_${id}`)[0].files[0] : '');

            requestFile(`webs-view-detail/${id}`,'post',formData).then((response) =>{
                let record = response.data;
                webUrlDet = record;
                llenaTabla($('#web_id1').find(':selected').val());
                Swal.fire(response.title,response.msg,response.status);
            }).catch((err) =>{
                Swal.fire(err.title,err.msg,err.status);
            });
        }

        async function deleteArchivo(id) {
            
        }
    </script>
@endsection
