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
                        @foreach($noticias as $noticia)
                        <tr>
                            <th class="text-center" scope="row">{{$noticia->id}}</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$noticia->fname}} </a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$noticia->lname}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$noticia->phone}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$noticia->address}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$noticia->price}}</a>
                            </td>
                            <td class="d-none d-sm-table-cell">
                            <span class="badge bg-warning">{{$noticia->type_request}}</span>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver" onclick="detailNoticias( {{ $noticia->id }} )">
                                <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar" onclick="editNoticias( {{ $noticia->id }} )">
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
                <form action="/ajustes/noticias" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <input type="hidden" id="id" name="id" value="">
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
                            <label for="address" class="col-form-label">Direccion</label>
                            <input type="text" class="form-control" id="address" name="address" required placeholder="Indique su Direccion">
                            <!-- <input style="padding-left: 30px!important; font-size: 15px;" class="form-control btn-lg btn-block click" type="text"  id="searchTextField" name="localidad" placeholder="Buscar Dirección" required>
                            <input type="hidden" class="click" name="calle" id="calle">
                            <input type="hidden" class="numeric" name="numero" id="numero">
                            <input type="hidden" class="numeric" name="codigo_postal" id="cp">
                            <input type="hidden" class="click" name="pais" id="pais"> -->
                        </div>
                        <div class="form-group">
                            <label for="price" class="col-form-label">Precio</label>
                            <input type="text" class="form-control" id="price" name="price" required placeholder="Indique su precio ">
                        </div>
                        <div class="form-group">
                            <label for="type_request">Tipo de Solicitud</label>
                            <select class="js-select2 form-select" id="type_request" name="type_request" style="width: 100%;" required data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="VE">VENTA</option>
                                <option value="AL">ALQUILER</option>
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
                                <option value="VA">En Valoracion</option>
                                <option value="DB">De baja</option>
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
        var noticias = {{ Js::from($noticias) }};
        $(document).ready(function() {
            $('#type_request').select2({dropdownParent: $('#noticiaModal')});
            $('#type_action').select2({dropdownParent: $('#noticiaModal')});
        });

        function addNewNoticia() {
            $('#label').html("Agregar Noticias");
            $('#id').val('');
            $('#fname').val('');
            $('#lname').val('');
            $('#phone').val('');
            $('#address').val('');
            $('#price').val('');
            $('#type_request').val('').change();
            $('#type_action').val('').change();
            $('#observations').val('');
            $('#noticiaModal').modal('show');
        }

        function editNoticias(id){
           
            let noticia = _.find(noticias, function(o) { return o.id == id; });
            $('#label').html("Editar Noticias");
            $('#id').val(noticia.id);
            $('#fname').val(noticia.fname);
            $('#lname').val(noticia.lname);
            $('#phone').val(noticia.phone);
            $('#address').val(noticia.address);
            $('#price').val(noticia.price);
            $('#type_request').val(noticia.type_request).change();
            $('#type_action').val(noticia.type_action).change();
            $('#observations').val(noticia.observations);
            $('#noticiaModal').modal('show');
        }

        function detailNoticias(id){
            let noticia = _.find(noticias, function(o) { return o.id == id; });
            let content = `
                <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
                <p><strong>Nombre y Apellido:&nbsp; &nbsp; </strong><span>${noticia.fname} - ${noticia.lname}</span></p>
                <p><strong>Telefono:&nbsp; &nbsp; </strong><span>${noticia.phone}</span></p>
                <p><strong>Direccion:&nbsp; &nbsp; </strong><span>${noticia.address}</span></p>
                <p><strong>Precio:&nbsp; &nbsp; </strong><span>${noticia.price}</span></p>
                <p><strong>Tipo de Solicitud:&nbsp; &nbsp; </strong><span>${noticia.type_request}</span></p>
                <p><strong>Observaciones:&nbsp; &nbsp; </strong><span>${noticia.observations}</span></p>
                <p><strong>Accion:&nbsp; &nbsp; </strong><span>${noticia.type_action}</span></p>
                `;

            $('#detalleNoticia').empty();
            $('#detalleNoticia').append(content);
            $('#detalleNoticias').modal('show');
        }
    </script>
@endsection
