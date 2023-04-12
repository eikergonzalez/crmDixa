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
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Rebajas" onclick="openModalRebaja()">
                        <i class="fa fa-briefcase"> Rebajas</i>
                    </button>
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Añadir Visitas" onclick="addVisita()"> 
                        <i class="fa fa-plus"> Añadir Visitas</i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><b> Tipo de Solicitud: </b> {{ $propietarios->solicitud }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Nombre: </b> {{ $propietarios->nombre }} {{ $propietarios->apellido }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Teléfono: </b> {{ $propietarios->telefono }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Dirección: </b> {{ $propietarios->direccion }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Precio Solicitado: </b> {{ $propietarios->precio_solicitado }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Precio Valorado: </b> {{ $propietarios->precio_valorado }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Metros Útiles: </b> {{ $propietarios->metros_utiles }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Metros Usados: </b> {{ $propietarios->metros_usados }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Ascensor: </b> {{ $propietarios->ascensor }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> # habitaciones: </b> {{ $propietarios->habitaciones }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Exposición: </b> {{ ($propietarios->exposicion == 'IN') ? 'Interior' : 'Exterior' }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Hipoteca: </b> {{ $propietarios->hipoteca }} </p>
                            </div>
                            @if($propietarios->hipoteca == 'SI')
                                <div class="col-sm-6">
                                    <p><b> Valor de la Hipoteca: </b> {{ $propietarios->hipoteca_valor }} </p>
                                </div>
                            @endif
                            <div class="col-sm-6">
                                <p><b> Herencia: </b> {{ $propietarios->herencia }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Reforma: </b> {{ $propietarios->reforma }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Tipo de Inmueble: </b> {{ $propietarios->tipoinmueble }} </p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default" role="tab" id="accordion_h2">
                                <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q2" aria-expanded="true" aria-controls="accordion_q2">Archivos</a>
                            </div>
                            <div id="accordion_q2" class="collapse" role="tabpanel" aria-labelledby="accordion_h2" data-bs-parent="#accordion">
                                <div class="block-content" style="font-size: 12px">
                                    @foreach($tipoArchivo as $archivo)
                                        <div class="row">
                                            <div class="col-sm-8">
                                                @if( empty($archivo->getDocumentos($inmuebleId)->name_file) )
                                                    <i class="fa fa-fw fa-times me-1 text-danger" id="icon_{{ $archivo->id }}"></i> {{ $archivo->descripcion }}
                                                @else
                                                    <i class="fa fa-fw fa-check me-1 text-success" id="icon_{{ $archivo->id }}"></i> {{ $archivo->descripcion }}
                                                @endif
                                            </div>
                                            <div class="col-sm-4">
                                                @if( empty($archivo->getDocumentos($inmuebleId)->name_file) )
                                                    <button type="button" class="btn btn-outline-primary bt-sm button_save_files_{{ $archivo->id }} button_save_files" onclick="openFile({{ $archivo->id }});">
                                                        <i class="fa fa-fw fa-upload me-1"></i> Cargar
                                                    </button>
                                                    <a class="btn btn-primary button_loading_files_{{ $archivo->id }} button_loading_files" type="button" disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Guardando...
                                                    </a>
                                                    <input type="file" id="file_{{ $archivo->id }}" style="display: none;" data-id="{{ $archivo->id }}"
                                                        accept=".doc, .docx,.pdf"
                                                        onchange="upFile({{ $archivo->id }}, {{ $inmuebleId }})" />
                                                @else
                                                    <button type="button" class="btn btn-outline-primary bt-sm button_save_files_{{ $archivo->id }} button_save_files" onclick="openFile({{ $archivo->id }});">
                                                        <i class="fa fa-fw fa-upload me-1"></i> Actualizar 
                                                    </button>
                                                    <a class="btn btn-primary button_loading_files_{{ $archivo->id }} button_loading_files" type="button" disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Guardando...
                                                    </a>
                                                    <input type="file" id="file_{{ $archivo->id }}" style="display: none;" data-id="{{ $archivo->id }}"
                                                        accept=".doc, .docx,.pdf"
                                                        onchange="upFile({{ $archivo->id }}, {{ $inmuebleId }})" />
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach

                                </div>
                            </div>

                            <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default" role="tab" id="accordion_h1">
                                <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q1" aria-expanded="true" aria-controls="accordion_q1">Imagenes</a>
                            </div>
                            <div id="accordion_q1" class="collapse" role="tabpanel" aria-labelledby="accordion_h1" data-bs-parent="#accordion">
                                <div class="block-content">
                                    <div class="row items-push js-gallery img-fluid-100">
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-outline-primary bt-sm button_save_imagen" onclick="openFileImagen();">
                                                <i class="fa fa-fw fa-upload me-1"></i> Cargar Imagen
                                            </button>
                                            <a class="btn btn-primary button_loading_imagen" type="button" disabled>
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Guardando...
                                            </a>
                                            <input type="file" id="file_imagen" style="display: none;"
                                                multiple="" accept="image/jpg, image/jpeg, image/png"
                                                onchange="upImagen({{ $inmuebleId }})" />
                                        </div>
                                        <br>
                                        <br>
                                        <div id="image_content" class="row">
                                            @foreach($imagenes as $image)
                                                <div class="col-sm-4 animated fadeIn">
                                                    <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{ asset($image->path) }}">
                                                        <img class="img-fluid" src="{{ asset($image->path) }}" alt="">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
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
                                    <label for="nombre">Pedidos</label>
                                    <select class="js-select2 form-select" id="pedido_id" name="pedido_id" style="width: 100%;" data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                        @foreach($pedidos as $pedido)
                                            <option value="{{ $pedido->id }}">{{ $pedido->nombre }} {{ $pedido->apellido }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="correo">Correo</label>
                                    <input type="email" class="form-control" id="correo" name="correo" placeholder="Indique su correo" required>
                                </div>
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

    <div class="modal" id="rebajaModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Rebaja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" autocomplete="off" id="formRebaja">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12 pb-3">
                                <div class="form-group">
                                    <label for="nombre">Precio solicitado</label>
                                    <input type="text" class="form-control" id="precio_solicitado" name="precio_solicitado" placeholder="Indique su nombre" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary button_save_rebaja">Guardar</button>
                        <a class="btn btn-primary button_loading_rebaja" type="button" disabled>
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
                                <div class="col-sm-4 mb-2">
                                    <p>
                                        El precio propuesto para la compra del inmueble queda fijado en:
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="precio_inmueble" name="precio_inmueble">
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        El pago se hará del siguiente modo:
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="pago1" name="pago1">
                                    </div>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    A la firma del presente documeto por el Proponente, como prueba de su voluntad de suscribir un contrato de compraventa
                                    de dicho inmueble. En el supuesto de que la presente propuesta fuese conforme con el Encargo de Venta suscrito por 
                                    el vendedor, dicha cantidad, a cuenta del precio del inmueble, constituirá arras o señal según lo establecido
                                    en el art. 1.454 del Código Civil. En supuesto contrario, dicha cantidad, a la aceptación de la presente propuesta por el vendedor
                                    constituirá arras o señal según lo establecido en el mismo precepto
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="pago2" name="pago2">
                                    </div>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    A la firma del contrato privado o de compraventa
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="pago3" name="pago3">
                                    </div>
                                </div>
                                <div class="col-sm-8 mb-2">
                                    Con ocación del otorgamiento de la escritura pública de compraventa
                                </div>
                            </div>
                            <div class="row" id="div_pto2_arrenda">
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
                                <h4><b>Punto 3</b></h4>
                            </div>
                            <div class="row" id="div_pto3_compra">
                                <div class="col-sm-12">
                                    <p>
                                        El inmueble en objeto será enregado libre de <b>cargas, gravámenes, vicios y evicciones a excepción de </b>
                                    </p>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <div class="form-group">
                                        <label for="cont_pto2">Carga</label>
                                        <input type="text" class="form-control" id="cont_pto3" name="cont_pto3" placeholder="indicar si hay algún tipo de carga sobre el ENCARGO (hipoteca, derramas, embargos, etc).">
                                    </div>
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
                                <div class="col-sm-8 mb-2">
                                    <p>
                                        El proponente se compromete a suscribir el contrato privado de compraveta antes del dia
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <input type="text" class="js-datepicker form-control" id="fecha_antes" name="fecha_antes" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy">
                                </div>
                                <div class="col-sm-8 mb-2">
                                    <p>
                                        Y la escritura pública de compraventa antes del dia
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <input type="text" class="js-datepicker form-control" id="fecha_antes2" name="fecha_antes2" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy">
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        Dicho compromiso, salvo pacto contrario, será asumido del mismo modo por el Vendedor, 
                                        si la presente propuesta hubiera sido formulada por el Proponente  conforme al Encargo de Venta
                                        del inmueble, o si a pesar de no ser conforme al Encargo, el Vendedor la aceptará formalmente.
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto4_arrenda">
                                <div class="col-sm-8 mb-2">
                                    <p>
                                        El Proponente, a la firma del presente documento, y como prueba de su voluntad de 
                                        suscribir un contrato de arrendamiento de dicho inmueble, entrega el importe de
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="importe_inmueble" name="importe_inmueble">
                                    </div>
                                </div>
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        Dicha cantidad, a la aceptaciónde la presente propuesta por el Arrendador, constituirá:
                                    </p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="fianza">Fianza</label>
                                        <input type="text" class="form-control" id="fianza" name="fianza">
                                    </div>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <div class="form-group">
                                        <label for="fianza">Una mensualidad de renta anticipada</label>
                                        <input type="text" class="form-control" id="mensualidad_anticipada" name="mensualidad_anticipada">
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
                                        En el supuesto e que la presente propuesta fuese conforme con el encargo suscrito por el Vendedor, ésta será
                                        vinculante para el Proponente y el Vendedor, desde la firma del primero. En caso contrario, la presente propuesta
                                        será vinculante para el Proponente y para el Vendedor, una vez que haya sido aceptada por este.
                                        En este último caso, de no ser aceptada en el plazo de 1 días, se reestituirá al Prponente la cantidad
                                        entregada en concepto de arras o señal.
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto5_arrenda">
                                <div class="col-sm-8 mb-2">
                                    <p>El proponente se compromete a aportar una garantía adicional consistente en</p>
                                </div>
                                <div class="col-sm-4 mb-2">
                                    <input type="text" class="form-control" id="garantia_adicional" name="garantia_adicional">
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 6</b></h4> 
                            </div>
                            <div class="row" id="div_pto6_compra">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        Habiendo sido aceptada la presente propuesta o habiendo sido formulada conforme con el encargo, 
                                        la falta de suscripción del contrato de compra - venta en los plazos y condiciones establecidos 
                                        en las cláusulas precedentes por causa imputable al Proponente, comportará la pérdida de las sumas 
                                        abonadas por él en concepto de arras en favor del Vendedor. Si la causa de dicha falta de suscripción 
                                        fuera imputable al Vendedor, éste deberá devol - verlas dobladas al Proponente (art. 1.454 del Código Civil).
                                    </p>
                                </div>
                            </div>
                            <div class="row" id="div_pto6_arrenda">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        La presente propuesta será vinculante para el Proponente y el Arrendador, una vez que haya sido aceptada por éste.
                                        Si la propuesta no fuese aceptada por el Arrendador en el plazo de 15 días, se restituirá al Proponente 
                                        el importe referido en la cláusula cuarta.
                                    </p>
                                </div>
                            </div>

                            <hr>

                            <div>
                                <h4><b>Punto 7</b></h4> 
                            </div>
                            <div class="row" id="div_pto7_compra">
                                <div class="col-sm-12 mb-2">
                                    <textarea class="form-control" id="test_pto7" name="test_pto7" rows="4" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="row" id="div_pto7_arrenda">
                                <div class="col-sm-12 mb-2">
                                    <p>
                                        La falta de suscripción del contrato de arrendamiento en el plazo indicado en la cláusula primera 
                                        por causa imputable al Proponente, comportará la pérdida del importe referido en la cláusula cuarta, 
                                        en favor del Arrendador. Si la falta de suscripción fuera imputable al Arrendador, éste deberá devolver 
                                        el doble de dicho importe al proponente.
                                    </p>
                                </div>
                            </div>

                            <hr>
                            <div id="div_pto8_arrenda">
                                <div>
                                    <h4><b>Punto 8</b></h4> 
                                </div>
                                <div class="row" id="div_pto8_arrenda">
                                    <div class="col-sm-12 mb-2">
                                        <p>
                                            El Proponente declara expresamente conocer y aceptar la situación urbanística, el estado del inmueble, así como las normas de la Comunidad de Vecinos.
                                        </p>
                                    </div>
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
        var uuid = null;
        var idsPropietarios = [];
        var dataInmueble = {};
        var tieneContrato = false;

        $(document).ready(function() {
            $('#pedido_id').select2({dropdownParent: $('#agendaModal')});
            $('#row_table_visitas').hide();
            $('#agendaModal').modal({backdrop: 'static'});
            hideLoadingVisitas();
            hideLoadingFiles();
            hideLoadingImagen();
            hideLoadingRebaja();
            hideLoadingContratos();
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#correo').val('');
            getVisitas('{{ $propietarios->inmuebleid }}');
            $('#precio_solicitado').maskMoney({suffix:'€'});
            $('#importe_inmueble').maskMoney({suffix:'€'});
            $('#precio_inmueble').maskMoney({suffix:'€'});
            $('#pago1').maskMoney({suffix:'€'});
            $('#pago2').maskMoney({suffix:'€'});
            $('#pago3').maskMoney({suffix:'€'});
            $('#honorarios_agencia').maskMoney({suffix:'€'});
            $('#importe_comprador').maskMoney({suffix:'€'});
            $('#precio_alquiler').maskMoney({suffix:'€'});
            $('#fianza').maskMoney({suffix:'€'});
            $('#mensualidad_anticipada').maskMoney({suffix:'€'});
            $('#garantia_adicional').maskMoney({suffix:'€'});
            $('#valoracionModal').modal({backdrop: 'static'});
            $(".telefono").intlTelInput({
                formatOnDisplay: true,
                initialCountry: 'ES',
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
                utilsScript: "/js/plugins/telefono/utils.js"
            });
            $('#row_actuando').hide();
            $('#div_contrato').hide();
            $('#modalContrato').modal('show');
        });

        $("#formVisita").submit(async function(e){
            e.preventDefault();
            await saveVisitas();
            return false;
        });

        $("#formRebaja").submit(async function(e){
            e.preventDefault();
            await saveRebaja();
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
            let duracionArendamiento = $('#duracion_arrenda').val();
            let timeArrendamiento = $('#time_arrendamiento').find(':selected').val();
            let usoVivienda = $('input[name="uso_vivienda"]:checked').val();
            let precioAlquiler = $('#precio_alquiler').maskMoney('unmasked')[0];
            let importeInmueble = $('#importe_inmueble').maskMoney('unmasked')[0];
            let fianza = $('#fianza').maskMoney('unmasked')[0];
            let mensualidadAnticipada = $('#mensualidad_anticipada').maskMoney('unmasked')[0];
            let garantiaAdicional = $('#garantia_adicional').maskMoney('unmasked')[0];

            //COMPRAVENTA
            let precioInmueble = $('#precio_inmueble').maskMoney('unmasked')[0];
            let pago1 = $('#pago1').maskMoney('unmasked')[0];
            let pago2 = $('#pago2').maskMoney('unmasked')[0];
            let pago3 = $('#pago3').maskMoney('unmasked')[0];
            let carga = $('#cont_pto3').val();
            let fechaAntes1 = $('#fecha_antes').val();
            let fechaAntes2 = $('#fecha_antes2').val();
            let textPto7 = $('#test_pto7').val();

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
                dataSend = {...dataSend, duracionArendamiento: duracionArendamiento };
                dataSend = {...dataSend, timeArrendamiento: timeArrendamiento };
                dataSend = {...dataSend, usoVivienda: usoVivienda };
                dataSend = {...dataSend, precioAlquiler: precioAlquiler };
                dataSend = {...dataSend, importeInmueble: importeInmueble };
                dataSend = {...dataSend, fianza: fianza };
                dataSend = {...dataSend, mensualidadAnticipada: mensualidadAnticipada };
                dataSend = {...dataSend, garantiaAdicional: garantiaAdicional };
            }else{
                dataSend = {...dataSend, precioInmueble: precioInmueble };
                dataSend = {...dataSend, pago1: pago1 };
                dataSend = {...dataSend, pago2: pago2 };
                dataSend = {...dataSend, pago3: pago3 };
                dataSend = {...dataSend, carga: carga };
                dataSend = {...dataSend, fechaAntes1: fechaAntes1 };
                dataSend = {...dataSend, fechaAntes2: fechaAntes2 };
                dataSend = {...dataSend, textPto7: textPto7 };
            }

            try{
                //showLoadingContratos();
                let resp = await request(`/contrato/save-propuesta`,'post',dataSend);

                if(resp.status = 'success'){
                    hideLoadingContratos();
                    location.reload();
                    Swal.fire(resp.title,resp.msg,resp.status);
                }

            }catch (error) {
                hideLoadingContratos();
                Swal.fire(error.title,error.msg,error.status);
            }
            return false;
        });

        $("input[name='tipo_contrato']").change(function(){
            let opcion = this.value;

            $('#div_contrato').show();


            $('#precio_inmueble').val('');
            $('#pago1').val('');
            $('#pago2').val('');
            $('#pago3').val('');
            $('#duracion_arrenda').val('');
            $('#time_arrendamiento').val('');
            $('#uso_vivienda1').prop('checked', false);
            $('#uso_vivienda2').prop('checked', false);
            $('#cont_pto3').val('');
            $('#precio_alquiler').val(0);
            $('#fecha_antes').val('');
            $('#fecha_antes2').val('');
            $('#importe_inmueble').val(0);
            $('#fianza').val(0);
            $('#mensualidad_anticipada').val(0);
            $('#garantia_adicional').val(0);
            $('#test_pto7').val('');

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

                $('#div_pto8_arrenda').show();

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

            $('#div_pto8_arrenda').hide();
        });

        $("input[name='actuando']").change(function(){
            let opcion = this.value;

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

        function showLoadingContratos() {
            $('.button_loading_contrato').show();
            $('.button_save_contrato').hide();
        }

        function hideLoadingContratos() {
            $('.button_loading_contrato').hide();
            $('.button_save_contrato').show();
        }

        function closeModalContratos() {
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
            let duracionArendamiento = $('#duracion_arrenda').val();
            let timeArrendamiento = $('#time_arrendamiento').find(':selected').val();
            let usoVivienda = $('input[name="uso_vivienda"]:checked').val();
            let precioAlquiler = $('#precio_alquiler').val();
            let importeInmueble = $('#importe_inmueble').val();
            let fianza = $('#fianza').val();
            let mensualidadAnticipada = $('#mensualidad_anticipada').val();
            let garantiaAdicional = $('#garantia_adicional').val();
            //COMPRAVENTA
            let precioInmueble = $('#precio_inmueble').val();
            let pago1 = $('#pago1').val();
            let pago2 = $('#pago2').val();
            let pago3 = $('#pago3').val();
            let carga = $('#cont_pto3').val();
            let fechaAntes1 = $('#fecha_antes').val();
            let fechaAntes2 = $('#fecha_antes2').val();
            let textPto7 = $('#test_pto7').val();

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
                if(_.isEmpty(precioAlquiler)){
                    Swal.fire("Alerta!","Debe indicar el precio mensual de arrendamiento",'warning');
                    return false;
                }
                if(_.isEmpty(importeInmueble)){
                    Swal.fire("Alerta!","Debe indicar el importe que el arrendatario",'warning');
                    return false;
                }
                if(_.isEmpty(fianza)){
                    Swal.fire("Alerta!","Debe indicar la fianza",'warning');
                    return false;
                }
                if(_.isEmpty(mensualidadAnticipada)){
                    Swal.fire("Alerta!","Debe indicar la mensualidad anticipada",'warning');
                    return false;
                }
                if(_.isEmpty(garantiaAdicional)){
                    Swal.fire("Alerta!","Debe indicar la garantía adicionals",'warning');
                    return false;
                }
            }else{
                if(_.isEmpty(precioInmueble)){
                    Swal.fire("Alerta!","Debe indicar el precio de inmueble",'warning');
                    return false;
                }
                if(_.isEmpty(pago1)){
                    Swal.fire("Alerta!","Debe indicar el pago",'warning');
                    return false;
                }
                if(_.isEmpty(pago2)){
                    Swal.fire("Alerta!","Debe indicar el pago",'warning');
                    return false;
                }
                if(_.isEmpty(pago3)){
                    Swal.fire("Alerta!","Debe indicar el pago",'warning');
                    return false;
                }
                if(_.isEmpty(fechaAntes1)){
                    Swal.fire("Alerta!","Indique la fecha a suscribir el contrato",'warning');
                    return false;
                }
                if(_.isEmpty(fechaAntes2)){
                    Swal.fire("Alerta!","Indique la fecha de la escritura pública",'warning');
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
            $('#duracion_arrenda').val('')
            $('#time_arrendamiento').val('').change();
            $('input[name="uso_vivienda"]').prop('checked', false);
            $('#precio_alquiler').val('');
            $('#importe_inmueble').val('');
            $('#fianza').val('');
            $('#mensualidad_anticipada').val('');
            $('#garantia_adicional').val('');
            //COMPRAVENTA
            $('#precio_inmueble').val('');
            $('#pago1').val('');
            $('#pago2').val('');
            $('#pago3').val('');
            $('#cont_pto3').val('');
            $('#fecha_antes').val('');
            $('#fecha_antes2').val('');
            $('#test_pto7').val('');

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
            $('#div_pto8_arrenda').hide();
        }

        function addVisita(){
            $('#pedido_id').val('').change();
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
                    pedido_id : $('#pedido_id').find(':selected').val(),
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

        async function saveRebaja() {
            try{
                showLoadingRebaja();
                var data = {
                    inmueble_id : {{ $inmuebleId }},
                    precio_solicitado : $('#precio_solicitado').maskMoney('unmasked')[0],
                }

                let resp = await request(`/encargo/rebaja`,'post', data);
                if(resp.status = 'success'){
                    hideLoadingRebaja();
                    Swal.fire(resp.title,resp.msg,resp.status);
                    $('#rebajaModal').modal('hide');
                }
            }catch (error) {
                hideLoadingRebaja();
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

        function showLoadingImagen() {
            $('.button_loading_imagen').show();
            $('.button_save_imagen').hide();
        }

        function hideLoadingImagen() {
            $('.button_loading_imagen').hide();
            $('.button_save_imagen').show();
        }

        function showLoadingRebaja() {
            $('.button_loading_rebaja').show();
            $('.button_save_rebaja').hide();
        }

        function hideLoadingRebaja() {
            $('.button_loading_rebaja').hide();
            $('.button_save_rebaja').show();
        }

        function showLoadingFiles() {
            $('.button_loading_files').show();
            $('.button_save_files').hide();
        }

        function hideLoadingFiles() {
            $('.button_loading_files').hide();
            $('.button_save_files').show();
        }

        function showLoadingVisitas() {
            $('.button_loading_visitas').show();
            $('.button_save_visitas').hide();
        }

        function hideLoadingVisitas() {
            $('.button_loading_visitas').hide();
            $('.button_save_visitas').show();
        }

        function openFile(id) {
            $(`#file_${id}`).click();
        }

        function openFileImagen() {
            $(`#file_imagen`).click();
        }

        async function upFile (inmuebleId){
            try{
                uuid = '{{ \Illuminate\Support\Str::uuid()}}';

                $(`.button_loading_files_${id}`).show();
                $(`.button_save_files_${id}`).hide();

                var formData = new FormData();
                let documento_file = $(`#file_${id}`).prop('files');

                formData.append('uuid', uuid);
                formData.append('documento_file', documento_file[0]);
                formData.append('tipo', 'archivo');
                formData.append('tipo_archivo', id);
                formData.append('inmueble_id', inmuebleId);

                let resp = await requestFile(`/encargo/savefile`,'post',formData);

                if(resp.status = 'success'){
                    
                    $(`.button_loading_files_${id}`).hide();
                    $(`.button_save_files_${id}`).show();
                    $(`#icon_${id}`).attr('class', 'fa fa-fw fa-check me-1 text-success');

                    Swal.fire(resp.title,resp.msg,resp.status);
                }
            }catch (error) {
                $(`.button_loading_files_${id}`).hide();
                $(`.button_save_files_${id}`).show();
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function upImagenupImagen(inmuebleId){
            try{
                uuid = '{{ \Illuminate\Support\Str::uuid()}}';

                showLoadingImagen();

                var formData = new FormData();
                let images_file = $('#file_imagen').prop('files');

                images_file.forEach(element => {
                    formData.append('images_file[]', element);
                });

                formData.append('uuid', uuid);
                formData.append('tipo', 'imagen');
                formData.append('inmueble_id', inmuebleId);

                let resp = await requestFile(`/encargo/saveimagen`,'post',formData);

                if(resp.status = 'success'){
                    //showImages(resp.data);
                    hideLoadingImagen();
                    location.reload();
                    Swal.fire(resp.title,resp.msg,resp.status);
                }
            }catch (error) {
                hideLoadingImagen();
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        function showImages(images) {
            let protocol = window.location.protocol; // http:
            let url = window.location.hostname; //intergrow.site
            $("#image_content").empty();
            var newRowContent = '';

            if(images.length == 0){
                return;
            }

            images.forEach((item) =>{
                newRowContent = `
                    <div class="col-sm-4 animated fadeIn">
                        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="${protocol}//${url}/${item.path}"
                            <img class="img-fluid" src="${protocol}//${url}/${item.path}" alt="">
                        </a>
                    </div>
                `;

                $("#image_content").append(newRowContent);
            });
        }

        function openModalRebaja() {
            $('#precio_solicitado').val(0);
            $('#rebajaModal').modal('show');
        }
    </script>
@endsection
