@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                   
                </h3>
            </div>
            <div class="block-content">
                @if(Auth::user()->rol_id <> 4)
                    <div class="col-sm-6 col-xl-4">
                        <div class="mt-2">
                            Pedido - Zona Interesada
                        </div>
                        <button type="button" class="btn btn-secondary" onclick="addNewNoticia()" data-toggle="modal" data-target="#noticiaModal">Nuevo</button>
                        <button type="button" class="btn btn-secondary" onclick="addNewNoticia()" data-toggle="modal" data-target="#noticiaModal">Nuevo</button>
                    </div>
                @endif
                <div class="table-responsive">
                    <form action="/valoracion" method="post" autocomplete="off" onsubmit="return unsetMoney()">
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
                                        <select class="js-select2 form-select" id="accion" name="accion" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                            @foreach($estatus as $stat)
                                                <option value="{{ $stat->id }}">{{ $stat->descripcion }}</option>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
