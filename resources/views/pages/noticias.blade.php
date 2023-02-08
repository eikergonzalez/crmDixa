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
                        <button type="button" class="btn btn-secondary" onclick=addNewNoticia()">Nuevo</button>
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
                            <th class="text-center" style="width: 100px;">Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $datas)
                        <tr>
                            <th class="text-center" scope="row">{{datas->id}}</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{datas->fname}} </a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{datas->lname}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{datas->phone}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{datas->address}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{datas->price}}</a>
                            </td>
                            <td class="d-none d-sm-table-cell">
                            <span class="badge bg-warning">{{datas->type_request}}</span>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver">
                                <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar">
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

    <div class="modal fade" id="noticiasModal" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
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
                            <label for="name" class="col-form-label">Nombre</label>
                            <input type="text" class="form-control" id="fname" name="fname" required placeholder="Indique su nombre">
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Apellido</label>
                            <input type="text" class="form-control" id="lname" name="lname" required placeholder="Indique su apellido">
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Telefono</label>
                            <input type="text" class="form-control" id="phone" name="phone" required placeholder="Indique su telefono">
                        </div>
                        <div class="form-group">
                            <label for="name" class="col-form-label">Direccion</label>
                            <input type="text" class="form-control" id="address" name="address" required placeholder="Indique su Direccion">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Precio</label>
                            <input type="email" class="form-control" id="price" name="price" required placeholder="Indique su precio ">
                        </div>
                        <div class="form-group">
                            <label for="type_request">Tipo de Solicitud</label>
                            <select class="js-select2 form-select" id="type_request" name="type_request" required style="width: 100%;" data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option> 
                                    <option value="EN">Venta</option>
                                    <option value="AL">Alquiler</option>
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
                    <h5 class="modal-title" id="label">Detalles de Noticia</h5>
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

        function addNewNoticias() {
            $('#label').html("Agregar Noticias");
            $('#id').val('');
            $('#fname').val('');
            $('#lname').val('');
            $('#phone').val('');
            $('#address').val('').change();
            $('#price').val('').change();
            $('#type_request').val('').change();
            $('#noticiaModal').modal('show');
        }

        function editNoticias(id){
            let noticias = _.find(noticias, function(o) { return o.id == id; });
            $('#label').html("Editar Noticias");
            $('#id').val(noticias.id);
            $('#fname').val(noticias.fname);
            $('#lname').val(noticias.lname);
            $('#phone').val(noticias.phone);
            $('#address').val(noticias.address);
            $('#price').val(noticias.price);
            $('#type_request').val(noticias.type_request).change();
            $('#noticiasModal').modal('show');
        }

        function detailNoticias(id){
            let noticias = _.find(noticias, function(o) { return o.id == id; });
            let content = `
                <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
                <p><strong>Nombre y ApellidoNombre:&nbsp; &nbsp; </strong><span>${noticias.fname} - ${noticias.lname}</span></p>
                <p><strong>Telefono:&nbsp; &nbsp; </strong><span>${noticias.phone}</span></p>
                <p><strong>Direccion:&nbsp; &nbsp; </strong><span>${noticias.address}</span></p>
                <p><strong>Precio:&nbsp; &nbsp; </strong><span>${noticias.price}</span></p>
                <p><strong>Tipo de Solicitud:&nbsp; &nbsp; </strong><span>${noticias.type_request}</span></p>
                `;

            $('#detalleNoticia').empty();
            $('#detalleNoticia').append(content);
            $('#detalleNoticias').modal('show');
        }
    </script>
@endsection
