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
                                    <th class="text-center" scope="row">{{$propietario->propietarioid}}</th>
                                    <td class="fw-semibold">
                                        <a href="javascript:void(0)">{{$propietario->direccion}} </a>
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <span class="badge bg-warning">{{$propietario->solicitud}}</span>
                                    </td>
                                    <td class="fw-semibold">
                                        <a href="javascript:void(0)">{{$propietario->nombre}} - {{$propietario->apellido}}</a>
                                    </td>
                                    <td class="fw-semibold">
                                        <a href="javascript:void(0)">{{$propietario->estatus}}</a>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                        @if(Auth::user()->rol_id <> 4)
                                            <button type="button" class="btn btn-sm {{ $color }}"  title="Ver" onclick="editValoracion( {{ $propietario->propietarioid }}, {{ $propietario->inmuebleid }})">
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
                        <button type="submit" class="btn btn-primary button_save_valoracion">Guardar</button>
                        <a class="btn btn-primary button_loading_valoracion" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </a>
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

    <div class="modal fade" id="modal_archivo" tabindex="-1" role="dialog" aria-labelledby="modal-default-large" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
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
                        <div class="row m-3" id="row_table_files">
                            <br>
                            <br>
                            <table class="table table-bordered table-striped table-vcenter" id="table_files">
                                <thead>
                                    <tr>
                                        <th class="text-center">Archivo</th>
                                        <th class="text-center">Tipo</th>
                                        <th class="text-center">Tipo Documento</th>
                                        <th class="d-none d-md-table-cell text-center" style="width: 100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" onclick="closeModalArchivos();">Cerrar</a>
                        <a type="button" class="btn btn-primary button_save_files" onclick="saveArchivo()">Guardar</a>
                        <a class="btn btn-primary button_loading_files" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalContrato" tabindex="-1" role="dialog" aria-labelledby="modal-default-large" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Contrato</h5>
                    <button type="button" class="btn-close" onclick="closeModalArchivos();"></button>
                </div>
                <form action="#" method="post" autocomplete="off" id="form_contratos">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <div class="row">
                            <div class="col-sm-12 col-offset-8">
                                <div class="mb-4">
                                    <label class="form-label">Tipo de contrato</label>
                                    <div class="space-x-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="tipo_contrato1" name="tipo_contrato" value="arrendamiento">
                                            <label class="form-check-label" for="tipo_contrato1">Nota encargo de arrendamiento</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="tipo_contrato2" name="tipo_contrato" value="compraventa">
                                            <label class="form-check-label" for="tipo_contrato2">Nota encargo de compraventa</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a type="button" class="btn btn-info mb-2" onclick="agregarPropietario()">Agregar propietario</a>
                        <div id="propietarios">
                            
                        </div>
                        <div class="row">
                            <div class="col-sm-9 mt-3">
                                <div class="mb-4">
                                    <label class="form-label">Actuando:</label>
                                    <div class="space-y-2">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="actuando1" name="actuando" value="propio">
                                            <label class="form-check-label" for="actuando1">En su propio nombre y representación (en adelante, el Cliente)</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" id="actuando2" name="actuando" value="otro">
                                            <label class="form-check-label" for="actuando2">En nombre y representación de...</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="row_actuando">
                            <div class="col-sm-6 mn-2">
                                <div class="form-group">
                                    <label for="nombre_rep">En nombre y representación de...</label>
                                    <input type="text" class="form-control" id="nombre_rep" name="nombre_rep">
                                </div>
                            </div>
                            <div class="col-sm-6 mn-2">
                                <div class="form-group">
                                    <label for="domicilio_rep">(en adelante, el Cliente), con domicilio en</label>
                                    <input type="text" class="form-control" id="domicilio_rep" name="domicilio_rep">
                                </div>
                            </div>
                            <div class="col-sm-4 mn-2">
                                <div class="form-group">
                                    <label for="nif_rep">provisto de N.I.F./C.I.F</label>
                                    <input type="text" class="form-control" id="nif_rep" name="nif_rep">
                                </div>
                            </div>
                            <div class="col-sm-4 mn-2">
                                <div class="form-group">
                                    <label for="calidad_rep">en calidad de</label>
                                    <input type="text" class="form-control" id="calidad_rep" name="calidad_rep">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" onclick="closeModalContratos();">Cerrar</a>
                        <a type="button" class="btn btn-primary button_save_contrato" onclick="saveContrato()">Guardar</a>
                        <a class="btn btn-primary button_loading_contrato" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        var valoraciones = {{ Js::from($propietarios) }};
        var uuid = null;
        var filesUploadedList = null;

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
            $('#row_table_files').hide();
            hideLoadingFiles();
            hideLoadingValoracion();
            $(".telefono").intlTelInput({
                formatOnDisplay: true,
                initialCountry: 'ES',
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
                utilsScript: "/js/plugins/telefono/utils.js"
            });

            $('#modalContrato').modal('show');
            $('#row_actuando').hide();

        });

        $("#form_valoracon").submit(function(e){
            let precioSolicitado = $('#precio_solicitado').maskMoney('unmasked')[0];
            let precioValorado = $('#precio_valorado').maskMoney('unmasked')[0];
            $('#precio_solicitado').maskMoney('destroy');
            $('#precio_valorado').maskMoney('destroy');
            $('#precio_solicitado').val(precioSolicitado);
            $('#precio_valorado').val(precioValorado);
            showLoadingValoracion();
            return true;
        });

        $("input[name='tipo_contrato']").change(function(){
            let opcion = this.value;

            if(opcion == 'arrendamiento'){
                conratoArrendamiento();
                return;
            }

            contratoCompraVenta();

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

        $("input[name='actuando']").change(function(){
            let opcion = this.value;
            console.log(opcion);

            if(opcion == 'propio'){
                $('#nombre_rep').val('');
                $('#domicilio_rep').val('');
                $('#nif_rep').val('');
                $('#calidad_rep').val('');
                $('#row_actuando').hide();
                return;
            }

            $('#row_actuando').show();

        });

        function addNewValoracion() {
            $('#div_agenda').hide();
            $('#label').html("Agregar Valoracion");
            $('#id').val('');
            $('#id_inmueble').val('');
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
            $("#table_files tbody").empty();
            $('#row_table_files').hide();
            uuid = '{{ \Illuminate\Support\Str::uuid()}}';
        }

        function editValoracion(id, inmuebleId){
            let valoracion = _.find(valoraciones, function(o) { return o.propietarioid == id && o.inmuebleid == inmuebleId; });

            $('#div_agenda').hide();
            if(valoracion.accion == 2) $('#div_agenda').show();

            getArchivos(valoracion.inmuebleid);

            $('#label').html("Editar Valoracion");
            $('#id').val(valoracion.propietarioid);
            $('#id_inmueble').val(valoracion.inmuebleid);
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

            if(action == 6) procesoContratos();
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
            try{
                let resp = await request(`valoracion/getfiles/${idInmueble}`,'get');
                if(resp.status = 'success'){
                     if(resp.data.length == 0){
                        $("#table_files tbody").empty();
                        $('#row_table_files').hide();
                        uuid = '{{ \Illuminate\Support\Str::uuid()}}';
                        return;
                    }
                    uuid = resp.data[0].uuid;
                    filesUploadedList = resp.data;
                    llenarTabla();
                }
            }catch (error) {
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function saveArchivo() {
            try{
                showLoadingFiles();
                var formData = new FormData();
                let tipo = $("input[name='tipo']:checked").val();
                let tipo_archivo = $('#tipo_archivo').val();
                let documento_file = $('#documento_file').prop('files');
                let images_file = $('#images_file').prop('files');

                if(tipo == 'imagen' && images_file.length <= 0){
                    Swal.fire('Alerta!','Debe seleccionar al menos un archivo','warning');
                    hideLoadingFiles();
                    return false;
                }

                if(tipo == 'archivo'){
                    if(documento_file.length <= 0){
                        Swal.fire('Alerta!','Debe seleccionar un archivo','warning');
                        hideLoadingFiles();
                        return false;
                    }
                    if(!tipo_archivo){
                        Swal.fire('Alerta!','Debe indicar el tipo de archivo','warning');
                        hideLoadingFiles();
                        return false;
                    }
                }

                if(tipo == 'imagen'){
                    images_file.forEach(element => {
                        formData.append('images_file[]', element);
                    });
                }

                if(tipo == 'archivo'){
                    formData.append('documento_file', documento_file[0]);
                }

                formData.append('uuid', uuid);
                formData.append('tipo', tipo);
                formData.append('tipo_archivo', tipo_archivo);
                formData.append('inmueble_id', $('#id_inmueble').val());

                let resp = await requestFile(`valoracion/savefile`,'post',formData);

                if(resp.status = 'success'){
                    filesUploadedList = resp.data;
                    llenarTabla();
                    let opcion = this.value;

                    if(tipo == 'imagen'){
                        $('#div_tipo_archivo').hide();
                        $('#div_file_document').hide();
                        $('#div_file_images').show();
                        $('#tipo_archivo').val('').change();
                        $('#documento_file').val('');
                    }else{
                        $('#div_tipo_archivo').show();
                        $('#div_file_document').show();
                        $('#div_file_images').hide();
                        $('#images_file').val('');
                    }
                    hideLoadingFiles();
                    Swal.fire(response.title,response.msg,response.status);
                }
            }catch (error) {
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function deleteArchivo(id) {
            Swal.fire({
                title: '¿Está de acuerdo?',
                text: "Esta acción no se podrá reverir",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C62D2D',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'No, Cancelar!',
            }).then(async (result) => {
                if (result.value) {
                    try{
                        let resp = await request(`valoracion/deletefile/${id}`,'delete');
                        if(resp.status = 'success'){
                            filesUploadedList = resp.data;
                            llenarTabla();
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

        function showLoadingFiles() {
            $('.button_loading_files').show();
            $('.button_save_files').hide();
        }

        function hideLoadingFiles() {
            $('.button_loading_files').hide();
            $('.button_save_files').show();
        }

        function showLoadingValoracion() {
            $('.button_loading_valoracion').show();
            $('.button_save_valoracion').hide();
        }

        function hideLoadingValoracion() {
            $('.button_loading_valoracion').hide();
            $('.button_save_valoracion').show();
        }

        function showLoadingContratos() {
            $('.button_loading_contrato').show();
            $('.button_save_contrato').hide();
        }

        function hideLoadingContratos() {
            $('.button_loading_contrato').hide();
            $('.button_save_contrato').show();
        }

        function llenarTabla() {
            $('#row_table_files').hide();
            $("#table_files tbody").empty();
            var newRowContent = '';

            if(filesUploadedList.length == 0){
                return;
            }
            $('#row_table_files').show();
            filesUploadedList.forEach((item) =>{
                newRowContent = `
                    <tr>
                        <td class="text-center">
                            <a href="/${item.path}" target="_blank">${item.name_file}</a>
                        </td>
                        <td class="text-center">
                            ${item.tipo}
                        </td>
                        <td class="fw-semibold">
                            ${(item.tipo_archivo) ?  item.tipo_archivo : ''}
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <a type="button"  class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Eliminar" onclick="deleteArchivo(${item.id})">
                                    <i class="fa fa-trash-alt"></i>
                                </a>
                          </div>
                        </td>
                    </tr>
                `;
                $("#table_files tbody").append(newRowContent);
            });
        }

        function procesoContratos() {
            hideLoadingContratos();
            $('#valoracionModal').modal('hide');
            $('#modalContrato').modal('show');
        }

        function closeModalContratos() {
            $('#valoracionModal').modal('show');
            $('#modalContrato').modal('hide');
        }

        function saveContrato() {
            
        }

        function conratoArrendamiento() {
            
        }

        function contratoCompraVenta() {
            
        }

        function agregarPropietario() {
            let id = '{{ \Illuminate\Support\Str::uuid()}}';
            id = id.split('-')[4];

            rowContent = `
                <div class="row mb-2" id="${id}">
                    <h4>Propietario</h4>
                    <div class="col-sm-4 mb-2">
                        <div class="form-group">
                            <label for="nombres_${id}">Nombres y Apellidos</label>
                            <input type="text" class="form-control" id="nombres_${id}" name="nombres_${id}" placeholder="Nombre y apellidos">
                        </div>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="form-group">
                            <label for="domicilio_${id}">Dommicilio</label>
                            <input type="text" class="form-control" id="domicilio_${id}" name="domicilio_${id}" placeholder="Dommicilio">
                        </div>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="form-group">
                            <label for="telefono_${id}">Teléfono</label>
                            <input type="number" class="form-control telefono" id="telefono_${id}" name="telefono_${id}" placeholder="">
                        </div>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="form-group">
                            <label for="email_${id}">E-mail</label>
                            <input type="text" class="form-control" id="email_${id}" name="email_${id}" placeholder="Email">
                        </div>
                    </div>
                    <div class="col-sm-4 mb-2">
                        <div class="form-group">
                            <label for="nif_${id}">N.I.F</label>
                            <input type="text" class="form-control" id="nif_${id}" name="nif_${id}" placeholder="N.I.F">
                        </div>
                    </div>
                    <div class="col-sm-4 mb-2 mt-4">
                        <a type="button" class="btn btn-danger" onclick="eliminarPropietario('${id}')">Eliminar propietario</a>
                    </div>
                    <h></h>
                </div>
            `;
            $("#propietarios").append(rowContent);
        }

        function eliminarPropietario(id) {
            $(`#${id}`).remove();
        }

    </script>
@endsection
