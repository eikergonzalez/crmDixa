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
                            <div class="col-sm-4 pb-3 pt-4">
                                <div class="form-group">
                                    {{-- <label for="telefono" >Telefono</label> --}}
                                    <input type="text" class="form-control telefono" id="telefono" name="telefono" required placeholder="Indique su telefono">
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
                    <button type="button" class="btn-close" onclick="closeModalContratos();"></button>
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
                        <div id="div_contrato">
                            <hr>
                            <div>
                                <h4><b>Punto 1</b></h4>
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

                            <div class="row mb-4" id="row_actuando">
                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="nombre_rep">En nombre y representación de...</label>
                                        <input type="text" class="form-control" id="nombre_rep" name="nombre_rep">
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <label for="domicilio_rep">(en adelante, el Cliente), con domicilio en</label>
                                        <input type="text" class="form-control" id="domicilio_rep" name="domicilio_rep">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="nif_rep">provisto de N.I.F./C.I.F</label>
                                        <input type="text" class="form-control" id="nif_rep" name="nif_rep">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="calidad_rep">en calidad de</label>
                                        <input type="text" class="form-control" id="calidad_rep" name="calidad_rep">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <p>ENCARGA, de forma exclusiva, al Grupo Inmobiliario DIXA (en adelante, la Agencia), que acepta el encargo:
                                        la localización de un arrendatario para el inmueble identificado como sigue:
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="cont_direccion">Dirección</label>
                                        <input type="text" class="form-control" id="cont_direccion" name="cont_direccion">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="cont_regitrales">Datos Registrales:</label>
                                        <input type="text" class="form-control" id="cont_regitrales" name="cont_regitrales">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="cont_catastrales">Datos catastrales:</label>
                                        <input type="text" class="form-control" id="cont_catastrales" name="cont_catastrales">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="cont_metros_utiles">Metros cuadrados útiles</label>
                                        <input type="number" class="form-control" id="cont_metros_utiles" name="cont_metros_utiles">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="cont_metros_construidos">Metros cuadrados construidos</label>
                                        <input type="number" class="form-control" id="cont_metros_construidos" name="cont_metros_construidos">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="cont_metros_anexos">Metros cuadrados Anexos</label>
                                        <input type="number" class="form-control" id="cont_metros_anexos" name="cont_metros_anexos">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="cont_otros">Otros</label>
                                        <input type="text" class="form-control" id="cont_otros" name="cont_otros">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 2</b></h4>
                            </div>
                            <div class="row" id="div_pto2_compra">
                                <div class="col-sm-12">
                                    <p>
                                        El cliente afirma que el citado inmueble se encuentra libre de <b>cargas, gravámenes, vicios y evicciones a excepción de </b>
                                    </p>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="cont_pto2">Carga</label>
                                        <input type="text" class="form-control" id="cont_pto2" name="cont_pto2" placeholder="indicar si hay algún tipo de carga sobre el ENCARGO (hipoteca, derramas, embargos, etc).">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_pto2_arrenda">
                                <div class="col-sm-12">
                                    <p>
                                        La Agencia se obliga a realizar las gestiones de mediación oportunas para la 
                                        localización de un arrendatario, y a mantener informado de tales gestiones al Cliente.
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 3</b></h4>
                            </div>
                            <div class="row" id="div_pto3_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        El cliente declara tener la total y exclusiva disponibilidad del 
                                        inmueble en objeto, en su afirmada condición de propietario, según deberá 
                                        acreditar documentalmente.
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto3_arrenda">
                                <div class="col-sm-6 mb-2">
                                    <p>
                                        El cliente fija el precio mensual de arrendamiento en:
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="precio_alquiler" name="precio_alquiler">
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 4</b></h4>
                            </div>
                            <div class="row" id="div_pto4_compra">
                                <div class="col-sm-4 mb-2">
                                    <p>
                                        El cliente fija el precio del inmueble en:
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="precio_inmueble" name="precio_inmueble">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_pto4_arrenda">
                                <div class="col-sm-4 mb-2">
                                    <p>
                                        El cliente determina que el plazo de duración del arrendamiento será de:
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="number" class="form-control" id="duracion_arrenda" name="duracion_arrenda">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <select class="form-select" id="time_arrendamiento" name="time_arrendamiento" style="width: 100%;" data-placeholder="Seleccione...">
                                            <option value="">Seleccione...</option>
                                            <option value="month">Meses</option>
                                            <option value="year">años</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <label class="form-label">Destino del inmueble</label>
                                    <div class="space-x-2">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="uso_vivienda1" name="uso_vivienda" value="1">
                                            <label class="form-check-label" for="uso_vivienda1">Vivienda</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="uso_vivienda2" name="uso_vivienda" value="2">
                                            <label class="form-check-label" for="uso_vivienda2">Uso distinto del de vivienda</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 5</b></h4> 
                            </div>
                            <div class="row" id="div_pto5_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        La agencia se obliga a realizar las gestiones de mediación 
                                        oportunas para la localización de un comprador, y a mantener informado al Cliente de tales gestiones.
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto5_arrenda">
                                <div class="col-sm-12 mb-2">
                                    <label class="form-label">El importe que el arrendatario deberá entregar en concepto de Fianza corresponderá (art. 36 LAU) a:</label>
                                    <div class="space-y-2">
                                        <div class="form-check form-check">
                                            <input class="form-check-input" type="radio" id="check_pto51" name="check_pto5" value="1">
                                            <label class="form-check-label" for="check_pto51">una mensualidad (arrendamiento de vivienda)</label>
                                        </div>
                                        <div class="form-check form-check">
                                            <input class="form-check-input" type="radio" id="check_pto52" name="check_pto5" value="2">
                                            <label class="form-check-label" for="check_pto52">dos mensualidades (arrendamiento para uso distinto del de vivienda)</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 6</b></h4> 
                            </div>
                            <div class="row" id="div_pto6_compra">
                                <div class="col-sm-6 mb-2">
                                    <p>
                                        Los honorarios a percibir por la Agencia del Cliente serán del
                                    </p>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="honorarios_cliente" name="honorarios_cliente">
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        que se abonarán a la firma del contrato privado de compraventa, 
                                        en caso de que no tuviera lugar la firma del contrato privado de
                                        compraventa, formalizándose esta directamente en escritura pública, 
                                        dichos honorarios serán satisfechos por Cliente con ocasión 
                                        del otorgamiento de esta.
                                    </p>
                                </div>
                                <div class="col-sm-7 mb-2">
                                    <p>
                                        Los honorarios a percibir por la Agencia del Comprador serán de
                                    </p>
                                </div>
                                <div class="col-sm-5 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="honorarios_comprador" name="honorarios_comprador">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_pto6_arrenda">
                                <div class="col-sm-9 mb-2">
                                    <p>
                                        El Cliente requiere que el arrendatario aporte una garantía adicional consistente en
                                    </p>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <input type="text" class="form-control" id="garantia" name="garantia">
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 7</b></h4> 
                            </div>
                            <div class="row" id="div_pto7_compra">
                                <div class="col-sm-4 mb-2">
                                    <p>
                                        El encargo tendrá validez desde el día
                                    </p>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <input type="text" class="js-datepicker form-control" id="fecha_desde_validez" name="fecha_desde_validez" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy" placeholder="Desde">
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <input type="text" class="js-datepicker form-control" id="fecha_hasta_validez" name="fecha_hasta_validez" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy" placeholder="Hasta">
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        Este plazo se presumirá tácitamente renovado, de forma sucesiva, por
                                        idénticos períodos de tiempo, salvo que cualquiera de las dos partes 
                                        notifique por escrito a la otra su voluntad en contrario con, al menos,
                                        7 días de antelación respecto a la finalización del plazo o de cualquiera
                                        de sus prórrogas.
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto7_arrenda">
                                <div class="col-sm-6 mb-2">
                                    <p>
                                        Los honorarios a percibir por la Agencia serán equivalentes a
                                    </p>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <input type="text" class="form-control" id="honorarios_agencia" name="honorarios_agencia">
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <p>
                                        mensualidad de renta + I.V.A.
                                    </p>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        que se abonarán a la firma del contrato de
                                        arrendamiento y serán satisfechos por partes iguales por el Cliente y el Arrendatario.
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 8</b></h4> 
                            </div>
                            <div class="row" id="div_pto8_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        El Cliente autoriza la Agencia a solicitar y recibir arras o señal del Comprador por un importe máximo de
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <input type="text" class="form-control" id="importe_comprador" name="importe_comprador">
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <p>
                                        y a retenerlas como depositario de las mismas hasta la firma del contrato de compraventa.
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto8_arrenda">
                                <div class="col-sm-4 mb-2">
                                    <p>
                                        El encargo tendrá validez desde el día
                                    </p>
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <input type="text" class="js-datepicker form-control" id="fecha_desde_validez2" name="fecha_desde_validez2" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy" placeholder="Desde">
                                </div>
                                <div class="col-sm-3 mb-2">
                                    <input type="text" class="js-datepicker form-control" id="fecha_hasta_validez2" name="fecha_hasta_validez2" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy" placeholder="Hasta">
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        Este plazo se presumirá tácitamente renovado, de forma sucesiva, por
                                        idénticos períodos de tiempo, si el Cliente no manifiesta por escrito 
                                        a la Agencia su voluntad en contrario con, al menos, 7 días de antelación respecto de la finalización
                                        del plazo o de cualquiera de sus prórrogas.<br>
                                        Expirado el plazo antes citado o cualquiera de sus prórrogas sin que la Agencia 
                                        haya localizado un arrendatario conforme con el presente encargo, éste no tendrá derecho
                                        a percibir cantidad alguna en concepto de honorarios.
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 9</b></h4> 
                            </div>
                            <div class="row" id="div_pto9_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        El Cliente autoriza, asimismo, a la Agencia a ofertar y publicitar el inmueble. 
                                        Del mismo modo, el Cliente autoriza que la Agencia realice visitas
                                        comerciales al inmueble acompañado de potenciales compradores.
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto9_arrenda">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        El Cliente autoriza a la Agencia a solicitar y recibir los importes 
                                        correspondientes a la Fianza y a una mensualidad de renta anticipada, y a retenerlas como depositaria
                                        de las mismas hasta la firma del contrato de arrendamiento.
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 10</b></h4> 
                            </div>
                            <div class="row" id="div_pto10_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        En los siguientes supuestos, el Cliente abonará a la Agencia la totalidad de los 
                                        gastos en los que éste haya incurrido hasta el momento con ocasión de las gestiones 
                                        objeto del presente encargo, así como los honorarios que proporcionalmente le correspondan 
                                        atendiendo a las gestiones realizadas y, en su caso, al tiempo transcurrido: 
                                    </p>
                                    <ul>
                                        <li>La venta se lleve a cabo por ter ceros durante el plazo de vigencia del presente en cargo.</li>
                                        <li>En el transcurso de un año desde la fecha de finalización del encargo, se realizase la venta a favor de personas presentadas al Cliente por la Agencia.</li>
                                        <li>El Cliente revoca el encargo antes de su caducidad.</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row" id="div_pto10_arrenda">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        El Cliente autoriza, asimismo, a la Agencia a ofertar y publicitar el inmueble.
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 11</b></h4> 
                            </div>
                            <div class="row" id="div_pto11_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        Los honorarios convenidos deberán ser abonados por el Cliente en su totalidad en el supuesto de que: 
                                    </p>
                                    <ul>
                                        <li>sin mediar justa y adecuada causa el Cliente se negara a suscribir un contrato de compraventa 
                                            que trajera causa de una propuesta de compra conforme con el presente encargo o, 
                                            no siendo conforme con éste, el Cliente la hubiese aceptado.
                                        </li>
                                    </ul>
                                    <p>
                                        Para determinar los honorarios a satisfacer en los casos previstos en esta cláusula y en la precedente, 
                                        se aplicará al precio del inmueble determinado en la clausula 4, el porcentaje a satisfacer por el Cliente estipulado en la cláusula 7
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto11_arrenda">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        El Cliente declara tener la total y exclusiva disponibilidad del inmueble, en su afirmada condición de propietario, según deberá acreditar documentalmente.
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 12</b></h4> 
                            </div>
                            <div class="row" id="div_pto12_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        La agencia se obliga a indemnizar al CLiente ante la injustificada renuncia del encargo por su parte o ante la manifiesta 
                                        y probada falta de realización de las gestiones de mediación propias ara la locaclización de un comprador,
                                        de haber causado éstas un daño. 
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto12_arrenda">
                                <div class="col-sm-7 mb-2">
                                    <p>
                                        El Cliente efectuará la entrega del inmueble en el momento/ fecha
                                    </p>
                                </div>
                                <div class="col-sm-5 mb-2">
                                    <input type="text" class="js-datepicker form-control" id="entrega_arrendamiento" name="entrega_arrendamiento" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy" placeholder="Fecha de entrega">
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 13</b></h4> 
                            </div>
                            <div class="row" id="div_pto13_compra">
                                <div class="col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="condicion_compra">Indique si hay que añadir alguna condición</label>
                                        <input type="text" class="form-control" id="condicion_compra" name="condicion_compra">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="div_pto13_arrenda">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        En los siguientes supuestos, el Cliente abonará a la Agencia la totalidad de los 
                                        gastos en los que ésta haya incurrido con ocasión de las gestiones objeto del presente
                                        encargo, y los honorarios correspondientes:
                                    </p>
                                    <ul>
                                        <li>
                                            El arrendamiento se lleva a cabo por el Cliente o terceros durante el plazo de vigencia del presente encargo.
                                        </li>
                                        <li>
                                            En el transcurso de un año desde la fecha de finalización del encargo, se realizase el arrendamiento a favor de personas presentadas al Cliente por la Agencia.
                                        </li>
                                        <li>
                                            Revoca el encargo antes de su caducidad.
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" onclick="closeModalContratos();">Cerrar</a>
                        <button type="submit" class="btn btn-primary button_save_contrato">Guardar</button>
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
        var idsPropietarios = [];
        var dataInmueble = {};
        var tieneContrato = false;

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
            $('#precio_alquiler').maskMoney({suffix:'€'});
            $('#precio_inmueble').maskMoney({suffix:'€'});
            $('#honorarios_agencia').maskMoney({suffix:'€'});
            $('#importe_comprador').maskMoney({suffix:'€'});
            $('#valoracionModal').modal({backdrop: 'static'});
            $('#tipo_archivo').select2({dropdownParent: $('#modal_archivo')});

            $('#div_tipo_archivo').hide();
            $('#div_file_document').hide();
            $('#div_file_images').hide();
            $('#row_table_files').hide();
            hideLoadingFiles();
            hideLoadingValoracion();
            hideLoadingContratos()
            $(".telefono").intlTelInput({
                formatOnDisplay: true,
                initialCountry: 'ES',
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
                utilsScript: "/js/plugins/telefono/utils.js"
            });

            //$('#modalContrato').modal('show');
            $('#row_actuando').hide();
            $('#div_contrato').hide();

        });

        $("#form_valoracon").submit(async function(e){
            e.preventDefault();

            let data = {
                id : $('#id').val(),
                id_inmueble : $('#id_inmueble').val(),
                tipo_solicitud : $('#tipo_solicitud').find(':selected').val(),
                nombre : $('#nombre').val(),
                apellido : $('#apellido').val(),
                telefono : $('#telefono').val(),
                email : $('#email').val(),
                direccion : $('#direccion').val(),
                precio_valorado : $('#precio_valorado').maskMoney('unmasked')[0],
                precio_solicitado : $('#precio_solicitado').maskMoney('unmasked')[0],
                metros_utiles : $('#metros_utiles').val(),
                metros_usados : $('#metros_usados').val(),
                ascensor : $('#ascensor').find(':selected').val(),
                tipo_inmueble : $('#tipo_inmueble').find(':selected').val(),
                reforma : $('#reforma').find(':selected').val(),
                exposicion : $('#exposicion').find(':selected').val(),
                habitaciones : $('#habitaciones').val(),
                hipoteca : $('#hipoteca').find(':selected').val(),
                hipoteca_valor : $('#hipoteca_valor').val(),
                herencia : $('#herencia').find(':selected').val(),
                estatus : $('#estatus').find(':selected').val(),
                accion : $('#accion').find(':selected').val(),
                observacion : $('#observacion').val(),
                age_fecha : $('#age_fecha').val(),
                age_titulo : $('#age_titulo').val(),
                age_descri : $('#age_descri').val(),
                tieneContrato: tieneContrato,
            };

            dataInmueble = data;

            let action = $('#accion').find(':selected').val();
            if(action == 6 && !tieneContrato){
                hideLoadingContratos();
                $('#valoracionModal').modal('hide');
                $('#modalContrato').modal('show');
                return false;
            }
            showLoadingValoracion();
            await saveValoracion();
            return false;
        });

        $("#form_contratos").submit(async function(e){
            e.preventDefault();
            let dataSend = {};
            let opcion = $('input[name="tipo_contrato"]:checked').val();
            let actuando = $('input[name="actuando"]:checked').val();
            let nombre_rep = $('#nombre_rep').val();
            let domicilio_rep = $('#domicilio_rep').val();
            let nif_rep = $('#nif_rep').val();
            let calidad_rep = $('#calidad_rep').val();
            let cont_direccion = $('#cont_direccion').val();
            let cont_regitrales = $('#cont_regitrales').val();
            let cont_catastrales = $('#cont_catastrales').val();
            let cont_metros_utiles = $('#cont_metros_utiles').val();
            let cont_metros_construidos = $('#cont_metros_construidos').val();
            let cont_metros_anexos = $('#cont_metros_anexos').val();
            let cont_otros = $('#cont_otros').val();
            //ARRENDAMIENTO
            let precioAlquiler = $('#precio_alquiler').maskMoney('unmasked')[0];
            let duracionArendamiento = $('#duracion_arrenda').val();
            let timeArrendamiento = $('#time_arrendamiento').find(':selected').val();
            let usoVivienda = $('input[name="uso_vivienda"]:checked').val();
            let importeArrendamiento = $('input[name="check_pto5"]:checked').val();
            let garantia = $('#garantia').val();
            let honoraiosAgencia = $('#honorarios_agencia').maskMoney('unmasked')[0];
            let fechaValidezDesdeArrenda = moment($('#fecha_desde_validez2').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            let fechaValidezHastaArrenda = moment($('#fecha_hasta_validez2').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            let fechaEntregaArrendamiento = moment($('#entrega_arrendamiento').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            //COMPRAVENTA
            let carga = $('#cont_pto2').val();
            let precioInmueble = $('#precio_inmueble').maskMoney('unmasked')[0];
            let honorariosCliente = $('#honorarios_cliente').val();
            let honorarioAgenciaComprador = $('#honorarios_comprador').val();
            let fechaValidezDesdeCompra = moment($('#fecha_desde_validez').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            let fechaValidezHastaCompra = moment($('#fecha_hasta_validez').val(), 'DD/MM/YYYY').format('YYYY-MM-DD');
            let importeComprador = $('#importe_comprador').maskMoney('unmasked')[0];
            let condicionCompra = $('#condicion_compra').val();

            if(!validarFormContrato()){
                return false;
            }
            let propietariosMap = idsPropietarios.map((item, i) =>{
                let _nombre = $(`#nombres_${item}`).val();
                let _domicilio = $(`#domicilio_${item}`).val();
                let _telef = $(`#telefono_${item}`).val();
                let _mail = $(`#email_${item}`).val();
                let _nif = $(`#nif_${item}`).val();

                return {
                    nombre : _nombre,
                    domicilio : _domicilio,
                    telef : _telef,
                    mail : _mail,
                    nif : _nif
                };
            });

            dataSend = {...dataSend, propietarios: propietariosMap };
            dataSend = {...dataSend, opcion: opcion };
            dataSend = {...dataSend, actuando: actuando };
            dataSend = {...dataSend, nombre_rep: nombre_rep };
            dataSend = {...dataSend, domicilio_rep: domicilio_rep };
            dataSend = {...dataSend, nif_rep: nif_rep };
            dataSend = {...dataSend, calidad_rep: calidad_rep };
            dataSend = {...dataSend, cont_direccion: cont_direccion };
            dataSend = {...dataSend, cont_regitrales: cont_regitrales };
            dataSend = {...dataSend, cont_catastrales: cont_catastrales };
            dataSend = {...dataSend, cont_metros_utiles: cont_metros_utiles };
            dataSend = {...dataSend, cont_metros_construidos: cont_metros_construidos };
            dataSend = {...dataSend, cont_metros_anexos: cont_metros_anexos };
            dataSend = {...dataSend, cont_otros: cont_otros };


            if(opcion == 'arrendamiento'){
                dataSend = {...dataSend, precioAlquiler: precioAlquiler };
                dataSend = {...dataSend, duracionArendamiento: duracionArendamiento };
                dataSend = {...dataSend, timeArrendamiento: timeArrendamiento };
                dataSend = {...dataSend, usoVivienda: usoVivienda };
                dataSend = {...dataSend, importeArrendamiento: importeArrendamiento };
                dataSend = {...dataSend, garantia: garantia };
                dataSend = {...dataSend, honoraiosAgencia: honoraiosAgencia };
                dataSend = {...dataSend, fechaValidezDesdeArrenda: fechaValidezDesdeArrenda };
                dataSend = {...dataSend, fechaValidezHastaArrenda: fechaValidezHastaArrenda };
                dataSend = {...dataSend, fechaEntregaArrendamiento: fechaEntregaArrendamiento };
            }else{
                dataSend = {...dataSend, carga: carga };
                dataSend = {...dataSend, precioInmueble: precioInmueble };
                dataSend = {...dataSend, honorariosCliente: honorariosCliente };
                dataSend = {...dataSend, honorarioAgenciaComprador: honorarioAgenciaComprador };
                dataSend = {...dataSend, fechaValidezDesdeCompra: fechaValidezDesdeCompra };
                dataSend = {...dataSend, fechaValidezHastaCompra: fechaValidezHastaCompra };
                dataSend = {...dataSend, importeComprador: importeComprador };
                dataSend = {...dataSend, condicionCompra: condicionCompra };
            }

            dataInmueble = { ...dataInmueble, contrato: dataSend };

            showLoadingContratos();
            await saveValoracion();
            return false;
        });

        $("input[name='tipo_contrato']").change(function(){
            let opcion = this.value;

            $('#div_contrato').show();

            $('#cont_pto2').val('');
            $('#precio_inmueble').val('');
            $('#duracion_arrenda').val('');
            $('#time_arrendamiento').val('');
            $('#precio_alquiler').val(0);
            $('#precio_alquiler').val(0);
            $('#uso_vivienda1').prop('checked', false);
            $('#uso_vivienda2').prop('checked', false);
            $('#check_pto51').prop('checked', false);
            $('#check_pto52').prop('checked', false);
            $('#honorarios_cliente').val('');
            $('#honorarios_comprador').val('');
            $('#garantia').val('');
            $('#fecha_desde_validez').val('');
            $('#fecha_hasta_validez').val('');
            $('#honorarios_agencia').val(0);
            $('#importe_comprador').val(0);
            $('#fecha_desde_validez2').val('');
            $('#fecha_hasta_validez2').val('');
            $('#entrega_arrendamiento').val('');
            $('#condicion_compra').val('');



            if(opcion == 'arrendamiento'){
                $('#div_pto2_compra').hide();
                $('#div_pto2_arrenda').show();

                $('#div_pto3_compra').hide();
                $('#div_pto3_arrenda').show();

                $('#div_pto4_compra').hide();
                $('#div_pto4_arrenda').show();

                $('#div_pto5_compra').hide();
                $('#div_pto5_arrenda').show();

                $('#div_pto6_compra').hide();
                $('#div_pto6_arrenda').show();

                $('#div_pto7_compra').hide();
                $('#div_pto7_arrenda').show();

                $('#div_pto8_compra').hide();
                $('#div_pto8_arrenda').show();

                $('#div_pto9_compra').hide();
                $('#div_pto9_arrenda').show();

                $('#div_pto10_compra').hide();
                $('#div_pto10_arrenda').show();

                $('#div_pto11_compra').hide();
                $('#div_pto11_arrenda').show();

                $('#div_pto12_compra').hide();
                $('#div_pto12_arrenda').show();

                $('#div_pto13_compra').hide();
                $('#div_pto13_arrenda').show();
                return;
            }

            $('#div_pto2_compra').show();
            $('#div_pto2_arrenda').hide();

            $('#div_pto3_compra').show();
            $('#div_pto3_arrenda').hide();

            $('#div_pto4_compra').show();
            $('#div_pto4_arrenda').hide();

            $('#div_pto5_compra').show();
            $('#div_pto5_arrenda').hide();

            $('#div_pto6_compra').show();
            $('#div_pto6_arrenda').hide();

            $('#div_pto7_compra').show();
            $('#div_pto7_arrenda').hide();

            $('#div_pto8_compra').show();
            $('#div_pto8_arrenda').hide();

            $('#div_pto9_compra').show();
            $('#div_pto9_arrenda').hide();

            $('#div_pto10_compra').show();
            $('#div_pto10_arrenda').hide();

            $('#div_pto11_compra').show();
            $('#div_pto11_arrenda').hide();

            $('#div_pto12_compra').show();
            $('#div_pto12_arrenda').hide();

            $('#div_pto13_compra').show();
            $('#div_pto13_arrenda').hide();
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

        async function editValoracion(id, inmuebleId){
            let valoracion = _.find(valoraciones, function(o) { return o.propietarioid == id && o.inmuebleid == inmuebleId; });
            dataInmueble = {};

            $('#div_agenda').hide();
            if(valoracion.accion == 2) $('#div_agenda').show();

            getContrato(valoracion.inmuebleid);
            getArchivos(valoracion.inmuebleid);
            limpiarFormContrato();

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

        async function getContrato(idInmueble) {
            try{
                let resp = await request(`valoracion/getcontrato/${idInmueble}`,'get');
                if(resp.status = 'success'){
                     if(resp.data.length == 0){
                        tieneContrato = false;
                        return;
                    }
                    tieneContrato = true;
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
                hideLoadingFiles();
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

        function closeModalContratos() {
            $('#valoracionModal').modal('show');
            $('#modalContrato').modal('hide');
        }

        function agregarPropietario() {
            let id = (Math.random() + 1).toString(36).substring(7);

            idsPropietarios.push(id);

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
                            <input type="text" class="form-control telefono" id="telefono_${id}" name="telefono_${id}" placeholder="">
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

            $(".telefono").intlTelInput({
                formatOnDisplay: true,
                initialCountry: 'ES',
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
                utilsScript: "/js/plugins/telefono/utils.js"
            });
        }

        function eliminarPropietario(id) {
            $(`#${id}`).remove();

            idsPropietarios = idsPropietarios.filter(function( obj ) {
                return obj !== id;
            });
        }

        async function saveValoracion() {
            try{
                hideLoadingContratos();
                hideLoadingValoracion();
                let resp = await request(`valoracion`,'post',dataInmueble);

                if(resp.status = 'success'){
                    //hideLoadingContratos();
                    //hideLoadingValoracion();
                    location.reload();
                    Swal.fire(resp.title,resp.msg,resp.status);
                }

            }catch (error) {
                hideLoadingContratos();
                hideLoadingValoracion();
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        function validarFormContrato() {
            let opcion = $('input[name="tipo_contrato"]:checked').val();
            let actuando = $('input[name="actuando"]:checked').val();
            let nombre_rep = $('#nombre_rep').val();
            let domicilio_rep = $('#domicilio_rep').val();
            let nif_rep = $('#nif_rep').val();
            let calidad_rep = $('#calidad_rep').val();
            let cont_direccion = $('#cont_direccion').val();
            let cont_regitrales = $('#cont_regitrales').val();
            let cont_catastrales = $('#cont_catastrales').val();
            let cont_metros_utiles = $('#cont_metros_utiles').val();
            let cont_metros_construidos = $('#cont_metros_construidos').val();
            let cont_metros_anexos = $('#cont_metros_anexos').val();
            let cont_otros = $('#cont_otros').val();
            //ARRENDAMIENTO
            let precioAlquiler = $('#precio_alquiler').val()
            let duracionArendamiento = $('#duracion_arrenda').val();
            let timeArrendamiento = $('#time_arrendamiento').find(':selected').val();
            let usoVivienda = $('input[name="uso_vivienda"]:checked').val();
            let importeArrendamiento = $('input[name="check_pto5"]:checked').val();
            let garantia = $('#garantia').val();
            let honoraiosAgencia = $('#honorarios_agencia').val()
            let fechaValidezDesdeArrenda = $('#fecha_desde_validez2').val();
            let fechaValidezHastaArrenda = $('#fecha_hasta_validez2').val();
            let fechaEntregaArrendamiento = $('#entrega_arrendamiento').val();
            //COMPRAVENTA
            let carga = $('#cont_pto2').val();
            let precioInmueble = $('#precio_inmueble').val();
            let honorariosCliente = $('#honorarios_cliente').val();
            let honorarioAgenciaComprador = $('#honorarios_comprador').val();
            let fechaValidezDesdeCompra = $('#fecha_desde_validez').val();
            let fechaValidezHastaCompra = $('#fecha_hasta_validez').val();
            let importeComprador = $('#importe_comprador').val();
            let condicionCompra = $('#condicion_compra').val();

            if(_.isEmpty(idsPropietarios)){
                Swal.fire("Alerta!","Debe agregar un propietario",'warning');
                return false;
            }

            idsPropietarios.forEach((item, i) =>{
                let _nombre = $(`#nombres_${item}`).val();
                let _domicilio = $(`#domicilio_${item}`).val();
                let _telef = $(`#telefono_${item}`).val();
                let _mail = $(`#email_${item}`).val();
                let _nif = $(`#nif_${item}`).val();

                if(_.isEmpty(_nombre)){
                    Swal.fire("Alerta!",`Debe indicar el nombre y apellido del propieratio ${i}`,'warning');
                    return false;
                }
                if(_.isEmpty(_domicilio)){
                    Swal.fire("Alerta!",`Debe indicar el domicilio del propieratio ${i}`,'warning');
                    return false;
                }
                if(_.isEmpty(_telef)){
                    Swal.fire("Alerta!",`Debe indicar el teléfono del propieratio ${i}`,'warning');
                    return false;
                }
                if(_.isEmpty(_mail)){
                    Swal.fire("Alerta!",`Debe indicar el email del propieratio ${i}`,'warning');
                    return false;
                }
                if(_.isEmpty(_nif)){
                    Swal.fire("Alerta!",`Debe indicar el N.I.F del propieratio ${i}`,'warning');
                    return false;
                }
               
            });

            if(_.isEmpty(actuando)){
                Swal.fire("Alerta!","Debe indicar la representación del inmueble",'warning');
                return false;
            }

            if(actuando == 'otro'){
                if(_.isEmpty(nombre_rep)){
                    Swal.fire("Alerta!","Debe indicar En nombre y representación de...",'warning');
                    return false;
                }
                if(_.isEmpty(domicilio_rep)){
                    Swal.fire("Alerta!","Debe indicar (en adelante, el Cliente), con domicilio en",'warning');
                    return false;
                }
                if(_.isEmpty(nif_rep)){
                    Swal.fire("Alerta!","Debe indicar provisto de N.I.F./C.I.F",'warning');
                    return false;
                }
                if(_.isEmpty(calidad_rep)){
                    Swal.fire("Alerta!","Debe indicar en calidad de",'warning');
                    return false;
                }
            }

            if(_.isEmpty(cont_direccion)){
                Swal.fire("Alerta!","Debe indicar la dirección",'warning');
                return false;
            }
            if(_.isEmpty(cont_regitrales)){
                Swal.fire("Alerta!","Debe indicar los Datos Registrales",'warning');
                return false;
            }
            if(_.isEmpty(cont_catastrales)){
                Swal.fire("Alerta!","Debe indicar los Datos catastrales",'warning');
                return false;
            }
            if(_.isEmpty(cont_metros_utiles)){
                Swal.fire("Alerta!","Debe indicar los Metros cuadrados útiles",'warning');
                return false;
            }
            if(_.isEmpty(cont_metros_construidos)){
                Swal.fire("Alerta!","Debe indicar los Metros cuadrados construidos",'warning');
                return false;
            }

            if(opcion == 'arrendamiento'){
                if(_.isEmpty(precioAlquiler)){
                    Swal.fire("Alerta!","Debe indicar el precio mensual de arrendamiento",'warning');
                    return false;
                }
                if(_.isEmpty(duracionArendamiento)){
                    Swal.fire("Alerta!","Debe indicar el plazo de duración del arrendamiento",'warning');
                    return false;
                }
                if(_.isEmpty(timeArrendamiento)){
                    Swal.fire("Alerta!","Debe indicar el plazo de duración del arrendamiento",'warning');
                    return false;
                }
                if(_.isEmpty(usoVivienda)){
                    Swal.fire("Alerta!","Debe indicar el Destino del inmueble",'warning');
                    return false;
                }
                if(_.isEmpty(importeArrendamiento)){
                    Swal.fire("Alerta!","Debe indicar el importe que el arrendatario deberá entregar en concepto de Fianza corresponderá (art. 36 LAU)",'warning');
                    return false;
                }
                if(_.isEmpty(garantia)){
                    Swal.fire("Alerta!","Debe indicar un aporte una garantía adicional ",'warning');
                    return false;
                }
                if(_.isEmpty(honoraiosAgencia)){
                    Swal.fire("Alerta!","Debe indicar los honorarios a percibir por la Agencia",'warning');
                    return false;
                }
                if(_.isEmpty(fechaValidezDesdeArrenda)){
                    Swal.fire("Alerta!","Debe indicar la fecha de validez del encargo",'warning');
                    return false;
                }
                if(_.isEmpty(fechaValidezHastaArrenda)){
                    Swal.fire("Alerta!","Debe indicar Debe indicar la fecha de validez del encargo",'warning');
                    return false;
                }
                if(moment(fechaValidezDesdeArrenda, "DD/MM/YYYY").unix() > moment(fechaValidezHastaArrenda, "DD/MM/YYYY").unix() || moment(fechaValidezHastaArrenda, "DD/MM/YYYY").unix() < moment(fechaValidezDesdeArrenda, "DD/MM/YYYY").unix()){
                    Swal.fire("Alerta!","Rango de fechas no válidos",'warning');
                    return false;
                }
                if(_.isEmpty(fechaEntregaArrendamiento)){
                    Swal.fire("Alerta!","Debe indicar la fecha de entrega del inmueble",'warning');
                    return false;
                }
            }else{
                if(_.isEmpty(precioInmueble)){
                    Swal.fire("Alerta!","Debe indicar el precio de inmueble",'warning');
                    return false;
                }
                if(_.isEmpty(honorariosCliente)){
                    Swal.fire("Alerta!","Debe indicar los honorarios por la agencia del Cliente",'warning');
                    return false;
                }
                if(_.isEmpty(honorarioAgenciaComprador)){
                    Swal.fire("Alerta!","Debe indicar loshonorarios a percibir por la Agencia del Comprador",'warning');
                    return false;
                }
                if(_.isEmpty(fechaValidezDesdeCompra)){
                    Swal.fire("Alerta!","Debe indicar la fecha de validez del encargo",'warning');
                    return false;
                }
                if(_.isEmpty(fechaValidezHastaCompra)){
                    Swal.fire("Alerta!","Debe indicar Debe indicar la fecha de validez del encargo",'warning');
                    return false;
                }
                if(moment(fechaValidezDesdeCompra, "DD/MM/YYYY").unix() > moment(fechaValidezHastaCompra, "DD/MM/YYYY").unix() || moment(fechaValidezHastaCompra, "DD/MM/YYYY").unix() < moment(fechaValidezDesdeCompra, "DD/MM/YYYY").unix()){
                    Swal.fire("Alerta!","Rango de fechas no válidos",'warning');
                    return false;
                }
                if(_.isEmpty(importeComprador)){
                    Swal.fire("Alerta!","Debe indicar un importe",'warning');
                    return false;
                }
            }
            return true;
        }

        function limpiarFormContrato() {
            $('input[name="tipo_contrato"]').prop('checked', false);
            $('input[name="actuando"]').prop('checked', false);
            $('#nombre_rep').val('');
            $('#domicilio_rep').val('');
            $('#nif_rep').val('');
            $('#calidad_rep').val('');
            $('#cont_direccion').val('');
            $('#cont_regitrales').val('');
            $('#cont_catastrales').val('');
            $('#cont_metros_utiles').val('');
            $('#cont_metros_construidos').val('');
            $('#cont_metros_anexos').val('');
            $('#cont_otros').val('');
            //ARRENDAMIENTO
            $('#precio_alquiler').val('')
            $('#duracion_arrenda').val('');
            $('#time_arrendamiento').val('').change();
            $('input[name="uso_vivienda"]').prop('checked', false);
            $('input[name="check_pto5"]').prop('checked', false);
            $('#garantia').val('');
            $('#honorarios_agencia').val('')
            $('#fecha_desde_validez2').val('');
            $('#fecha_hasta_validez2').val('');
            $('#entrega_arrendamiento').val('');
            //COMPRAVENTA
            $('#cont_pto2').val('');
            $('#precio_inmueble').val('');
            $('#honorarios_cliente').val('');
            $('#honorarios_comprador').val('');
            $('#fecha_desde_validez').val('');
            $('#fecha_hasta_validez').val('');
            $('#importe_comprador').val('');
            $('#condicion_compra').val('');
            $("#propietarios").empty();

            $('#div_contrato').hide();
            $('#div_pto2_compra').hide();
            $('#div_pto2_arrenda').hide();
            $('#div_pto3_compra').hide();
            $('#div_pto3_arrenda').hide();
            $('#div_pto4_compra').hide();
            $('#div_pto4_arrenda').hide();
            $('#div_pto5_compra').hide();
            $('#div_pto5_arrenda').hide();
            $('#div_pto6_compra').hide();
            $('#div_pto6_arrenda').hide();
            $('#div_pto7_compra').hide();
            $('#div_pto7_arrenda').hide();
            $('#div_pto8_compra').hide();
            $('#div_pto8_arrenda').hide();
            $('#div_pto9_compra').hide();
            $('#div_pto9_arrenda').hide();
            $('#div_pto10_compra').hide();
            $('#div_pto10_arrenda').hide();
            $('#div_pto11_compra').hide();
            $('#div_pto11_arrenda').hide();
            $('#div_pto12_compra').hide();
            $('#div_pto12_arrenda').hide();
            $('#div_pto13_compra').hide();
            $('#div_pto13_arrenda').hide();
        }

    </script>
@endsection
