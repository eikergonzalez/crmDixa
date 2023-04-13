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
                    <a type="button" class="btn btn-primary text-light" data-bs-dismiss="modal" aria-label="Contrato">Contrato</a>
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

    <script>
        var pedidos = {{ Js::from($pedidos) }}; 
        var ofertasdet = {{ Js::from($ofertasdet) }}; 
        var sugerenciadet = {{ Js::from($ofertasdet) }}; 
       
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
        });

        $("#formOfertas").submit(async function(e){
            e.preventDefault();
            await saveOfertas();
            showLoading();
            return false;
        });

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
                    console.log("estatus: "+resp.status);
                    hideLoading()
                    Swal.fire(resp.title,resp.msg,resp.status);
                    $('#ofertaModal').modal('hide');
                }
            }catch (error) {
                hideLoading();
                console.log("error: "+error);
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
                        console.log("paso aqui");
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
            let ofer = _.find(ofertasdet, function(o) { 
            return o.ofertaid == id; });
           console.log("DETAIL OFERTA: "+ofer.precio_valorado);
                
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
