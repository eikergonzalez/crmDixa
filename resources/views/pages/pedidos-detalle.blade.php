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
                        <button type="button" class="btn btn-sm btn-alt-secondary" title="Rebajas" onclick="getDeBaja()">
                            <i class="fa fa-briefcase"> De Baja</i>
                        </button>
                        <button type="button" class="btn btn-sm btn-alt-secondary" title="Añadir Visitas" onclick="addOferta()"> 
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
                                <th class="text-left">Nombre y Apellido</th>
                                <th class="text-left">Telefono</th>
                                <th class="text-left">Direccion</th>
                                <th class="text-left">Nota</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($ofertas as $oferta)
                                <tr>
                                    <th class="text-center" scope="row">{{$oferta->id}}</th>
                                    <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$oferta->nombre}} - {{$oferta->apellido}} </a>
                                    </td>
                                    <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$oferta->telefono}}</a>
                                    </td>
                                    <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$oferta->direccion}}</a>
                                    </td>
                                    <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$oferta->nota}}</a>
                                    </td>
                                    <td class="text-center">
                                    <div class="btn-group">
                                        @if(Auth::user()->rol_id <> 4)
                                            <a class="btn btn-sm"  title="Ver detalle"  onclick="detailOferta({{ $oferta->id }})">
                                                <i class="nav-main-link-icon far fa fa-eye"></i>
                                            </a> 
                                        @endif
                                    </div>
                                    </td>
                                </tr>
                                @endforeach
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
                                <th class="text-center">Tipo de Solicitud</th>
                                <th class="text-left">Nombre del Propietario</th>
                                <th class="text-right">Telefono</th>
                                <th class="text-left">Direccion</th>
                                <th class="text-right">Precio</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                @foreach($propietarios as $propietario)
                                <tr>
                                <th class="text-center" scope="row">{{$propietario->propietarioid}}</th>
                                    <td class="d-none d-sm-table-cell">
                                        <span class="badge bg-warning">{{$propietario->solicitud}}</span>
                                    </td>
                                    <td class="fw-semibold">
                                    <a href="be_pages_generic_profile.html">{{$propietario->nombre}} - {{$propietario->apellido}} </a>
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
                                    <td class="text-center">
                                    <div class="btn-group">
                                        @if(Auth::user()->rol_id <> 4)
                                            <a class="btn btn-sm" title="Ver detalle" onclick="detailSugerencias({{ $propietario->propietarioid }})">
                                                <i class="nav-main-link-icon far fa fa-eye"></i>
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
    
    <div class="modal" id="ofertaModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Ofertas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" autocomplete="off" id="formOfertas">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="row">
                                <div class="form-group">
                                    <label for="inmueble">Inmueble</label>
                                    <select class="js-select2 form-select" id="inmueble_id" name="inmueble_id" style="width: 100%;" required data-placeholder="Seleccione el inmueble...">
                                        <option value="">Seleccione...</option>
                                        @foreach($propietarios as $propietario)
                                            <option value="{{ $propietario->inmuebleid }}">{{ $propietario->nombre }}-{{ $propietario->apellido }}-{{ $propietario->direccion }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="form-group">
                                    <label for="nombre">Nota</label>
                                    <textarea class="form-control" id="nota" name="nota" rows="3" cols="5" placeholder="Indique aqui su motivo"></textarea>
                                </div>
                        </div>     
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary button_save" >Guardar</button>
                        <a class="btn btn-primary button_loading_ofertas" type="button" disabled>
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

    <div class="modal fade" id="detalleOferta" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalle Oferta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-1" id="detalleOfertas"></div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-primary text-light" onclick="openModalContratos();">Contrato</a>
                    <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="detalleSugerencia" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalle Sugerencias</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-1" id="detalleSugerencias"></div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                </div>
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
                                            <label class="form-check-label" for="tipo_contrato1">Propuesta de contrato de arrendamiento</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" id="tipo_contrato2" name="tipo_contrato" value="compraventa">
                                            <label class="form-check-label" for="tipo_contrato2">Propuesta de contrato de compraventa</label>
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
        var pedidos = {{ Js::from($pedidos) }}; 
        var ofertasdet = {{ Js::from($ofertasdet) }}; 
        var sugerenciadet = {{ Js::from($ofertasdet) }}; 
        var idsPropietarios = [];
        var contrato = {};
        var contratoEncargo = {};
        var tieneContrato = false;
        var tieneContratoEncargo = false;

        $(document).ready(function() {
            $('#inmueble_id').select2({dropdownParent: $('#ofertaModal')});
            $('#estatus').select2({dropdownParent: $('#pedidosModal')});
            $('#ofertaModal').modal({backdrop: 'static'});
            $('#deBajaModal').modal({backdrop: 'static'});
            $('#detalleOferta').modal({backdrop: 'static'});
            $('#detalleSugerencia').modal({backdrop: 'static'});
            hideLoading();
            $('#estatus').prop('disabled','true'); 
            $('#estatus option[value=""]').remove();
            $('#row_table_sugerencias').show();
            $('#row_table_ofertas').show();

            //CONTRATOS
            hideLoadingContratos();
            $('#importe_inmueble').maskMoney({suffix:'€'});
            $('#precio_inmueble').maskMoney({suffix:'€'});
            $('#pago1').maskMoney({suffix:'€'});
            $('#pago2').maskMoney({suffix:'€'});
            $('#pago3').maskMoney({suffix:'€'});
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
            //getPropuestaContrato();
            //getEncargoContrato();
        });

        $("#formOfertas").submit(async function(e){
            e.preventDefault();
            await saveOfertas();
            showLoading();
            return false;
        });


        //CONTRATO
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

            let dataPost = { propietario_id: propietarios.propietarioid, inmueble_id: propietarios.inmuebleid, contrato: dataSend };

            try{
                showLoadingContratos();
                let resp = await request(`/contrato/save-propuesta`,'post',dataPost);

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

        $("input[name='tipo_contrato']").click(function(){
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

        $("input[name='actuando']").click(function(){
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

        async function getPropuestaContrato(inmuebleId) {
            try{
                idsPropietarios = [];
                let resp = await request(`/contrato/getcontrato?inmueble_id=${inmuebleId}&tipo=PROPUESTA_CONTRATO`,'get');
                if(resp.status = 'success'){
                    if(!resp.data){
                        tieneContrato = false;
                        contrato = {};
                        return;
                    }
                    tieneContrato = true;
                    contrato = resp.data;
                }
            }catch (error) {

                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function getEncargoContrato(inmuebleId) {
            try{
                idsPropietarios = [];
                let resp = await request(`/contrato/getcontrato?inmueble_id=${inmuebleId}&tipo=NOTA_ENCARGO`,'get');
                if(resp.status = 'success'){
                    if(!resp.data){
                        tieneContratoEncargo = false;
                        contratoEncargo = {};
                        return;
                    }
                    contratoEncargo = resp.data;
                    tieneContratoEncargo = true;
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

        function openModalContratos() {
            
            let contratoMostrar = '';
            let dataSend = {};

            if(tieneContratoEncargo){
                contratoMostrar = 'encargo';
                dataSend = contratoEncargo;
            }
            if(tieneContrato){
                contratoMostrar = 'propuesta';
                dataSend = contrato;
            }

            if(_.isEmpty(contratoMostrar)){
                $('#modalContrato').modal('show');
                $('#detalleOferta').modal('hide');
                return;
            }

            llenarContratoForm(dataSend);
        }

        function llenarContratoForm(data) {
            let dataDecode = JSON.parse(data.data_json);
            console.log(dataDecode);

            if(dataDecode.opcion == 'compraventa'){
                $('#tipo_contrato2').prop('checked', true);
                $('#tipo_contrato2').click();
            }else{
                $('#tipo_contrato1').prop('checked', true);
                $('#tipo_contrato1').click();
            }

            _.forEach(dataDecode.propietarios, function(item) {
                idsPropietarios.push(item.id);

                rowContent = `
                    <div class="row mb-2" id="${item.id}">
                        <h4>Propietario</h4>
                        <div class="col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="nombres_${item.id}">Nombres y Apellidos</label>
                                <input type="text" class="form-control" id="nombres_${item.id}" name="nombres_${item.id}" placeholder="Nombre y apellidos" value="${item.nombre}">
                            </div>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="domicilio_${item.id}">Dommicilio</label>
                                <input type="text" class="form-control" id="domicilio_${item.id}" name="domicilio_${item.id}" placeholder="Dommicilio" value="${item.domicilio}">
                            </div>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="telefono_${item.id}">Teléfono</label>
                                <input type="text" class="form-control telefono" id="telefono_${item.id}" name="telefono_${item.id}" placeholder="" value="${item.telef}">
                            </div>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="email_${item.id}">E-mail</label>
                                <input type="text" class="form-control" id="email_${item.id}" name="email_${item.id}" placeholder="Email" value="${item.mail}">
                            </div>
                        </div>
                        <div class="col-sm-4 mb-2">
                            <div class="form-group">
                                <label for="nif_${item.id}">N.I.F</label>
                                <input type="text" class="form-control" id="nif_${item.id}" name="nif_${item.id}" placeholder="N.I.F" value="${item.nif}">
                            </div>
                        </div>
                        <div class="col-sm-4 mb-2 mt-4">
                            <a type="button" class="btn btn-danger" onclick="eliminarPropietario('${item.id}')">Eliminar propietario</a>
                        </div>
                        <h></h>
                    </div>
                `;
                $("#propietarios").append(rowContent);
            });

            if(dataDecode.actuando == 'propio'){
                $('#actuando1').prop('checked', true);
                $('#actuando1').click();

                $('#nombre_rep').val(dataDecode.nombre_rep);
                $('#domicilio_rep').val(dataDecode.domicilio_rep);
                $('#nif_rep').val(dataDecode.nif_rep);
                $('#calidad_rep').val(dataDecode.calidad_rep);
            }else{
                $('#actuando2').prop('checked', true);
                $('#actuando2').click();
            }

            $('#cont_direccion').val(dataDecode.cont_direccion);
            $('#cont_regitrales').val(dataDecode.cont_regitrales);
            $('#cont_catastrales').val(dataDecode.cont_catastrales);
            $('#cont_metros_utiles').val(dataDecode.cont_metros_utiles);
            $('#cont_metros_construidos').val(dataDecode.cont_metros_construidos);
            $('#cont_metros_anexos').val(dataDecode.cont_metros_anexos);
            $('#cont_otros').val(dataDecode.cont_otros);

            if(dataDecode.opcion == 'compraventa'){
                $('#precio_inmueble').val(dataDecode.precioInmueble);
                $('#pago1').val(dataDecode.pago1);
                $('#pago2').val(dataDecode.pago2);
                $('#pago3').val(dataDecode.pago3);
                $('#cont_pto3').val(dataDecode.carga);
                $('#fecha_antes').val(moment(dataDecode.fechaAntes1).format('DD/MM/YYYY'));
                $('#fecha_antes2').val(moment(dataDecode.fechaAntes2).format('DD/MM/YYYY'));
                $('#test_pto7').val(dataDecode.textPto7);
            }else{
                $('#duracion_arrenda').val(dataDecode.duracionArendamiento);
                $('#time_arrendamiento').val(dataDecode.timeArrendamiento).change();
                $('#precio_alquiler').val(dataDecode.precioAlquiler);
                $('#importe_inmueble').val(dataDecode.importeInmueble);
                $('#fianza').val(dataDecode.fianza);
                $('#mensualidad_anticipada').val(dataDecode.mensualidadAnticipada);
                $('#garantia_adicional').val(dataDecode.garantiaAdicional);

                if(dataDecode.usoVivienda == 1){
                    $('#uso_vivienda1').prop('checked', true);
                }else{
                    $('#uso_vivienda2').prop('checked', true);
                }
            }


            $(".telefono").intlTelInput({
                formatOnDisplay: true,
                initialCountry: 'ES',
                placeholderNumberType: "MOBILE",
                separateDialCode: true,
                utilsScript: "/js/plugins/telefono/utils.js"
            });

            $('#modalContrato').modal('show');
            $('#detalleOferta').modal('hide');
        }

        //END CONTRATO





        function showLoading() {
            $('.button_loading_ofertas').show();
            $('.button_save').hide();
        }

        function getDeBaja() {
            $('#deBajaModal').modal('show');
        }

        function addOferta(id) {
            $('#ofertaModal').modal('show');
        }

        function hideLoading() {
            $('.button_loading_pedidos').hide();
            $('.button_loading_ofertas').hide();
            $('.button_save').show();
        }

        async function saveOfertas() {
            try{
                showLoading();
                var data = {
                    inmueble_id : $('#inmueble_id').val(),
                    nota : $('#nota').val(),
                }
                let resp = await request(`/ofertas`,'post', data);
                if(resp.status = 'success'){
                    hideLoading()
                    Swal.fire(resp.title,resp.msg,resp.status);
                    $('#ofertaModal').modal('hide');
                }
            }catch (error) {
                hideLoading();
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function darDeBaja() {
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
                        var data = {
                            estatus : $('#estatus').val(),
                            motivo_de_baja : $('#motivo_de_baja').val(),
                        };
                        let resp = await request(`/pedidos/dardebaja/${pedidos.pedidosid}`,'post', data);
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

        function detailOferta(id){
            let ofer = _.find(ofertasdet, function(o) { return o.ofertaid == id; });
            console.log(ofer);
            getPropuestaContrato(ofer.inmuebleid);
            getEncargoContrato(ofer.inmuebleid);
            let content = `
                <p><strong>Tipo de Solicitud:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(ofer.tipo_solicitud)) ? ofer.tipo_solicitud : ''}</span></p>
                <p><strong>Nombre y Apellido:&nbsp; &nbsp; </strong><span>${ofer.nombre} ${ofer.apellido}</span></p>
                <p><strong>Telefono:&nbsp; &nbsp; </strong><span>${ofer.telefono}</span></p>
                <p><strong>Correo Electronico:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(ofer.email)) ? ofer.email : ''}</span></p>
                <p><strong>Direccion:&nbsp; &nbsp; </strong><span>${ofer.direccion}</span></p>
                <p><strong>Precio Solicitado:&nbsp; &nbsp; </strong><span>${amountFormat(ofer.precio_valorado)}</span></p>
                <p><strong>Nota:&nbsp; &nbsp; </strong><span>${(!_.isEmpty(ofer.nota)) ? ofer.nota : ''}</span></p>
                `;

            $('#detalleOfertas').empty();
            $('#detalleOfertas').append(content);
            $('#detalleOferta').modal('show');
        }

        function detailSugerencias(id){
            let pedido = _.find(sugerenciadet, function(o) { return o.ofertaid == id; });
           

            //$('#detalleSugerencia').empty();
           // $('#detalleSugerencias').append(content);
            $('#detalleSugerencia').modal('show');
        }

    </script>
@endsection
