@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Usuario
                </h3>
            </div>
            <div class="block-content">  
                <div class="col-sm-6 col-xl-4">
                    <button type="button" class="btn btn-secondary" onclick="addNewUser()">Nuevo</button>
                    <button type="button" class="btn btn-secondary">Transferir</button>
                </div>
                <div class="table-responsive pt-6">
                    <table class="table table-hover table-vcenter">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Estatus</th>
                                <th class="d-none d-sm-table-cell" style="width: 15%;">Rol</th>
                                <th class="text-center" style="width: 100px;">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <th class="text-center" scope="row">{{ $usuario->id }}</th>
                                            <td class="fw-semibold">{{ $usuario->name }}</td>
                                    <td class="fw-semibold">{{ $usuario->email }}</td>
                                    <td class="fw-semibold">
                                        {{ ($usuario->activo) ? 'Activo' : 'Inactivo' }}
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        @switch($usuario->rol_id)
                                            @case(2)
                                                <span class="badge bg-success">{{ $usuario->role->description }}</span>
                                                @break
                                            @case(3)
                                                <span class="badge bg-success-light">{{ $usuario->role->description }}</span>
                                                @break
                                            @case(4)
                                                <span class="badge bg-gray">{{ $usuario->role->description }}</span>
                                                @break
                                            @default
                                                <span class="badge bg-info">{{ $usuario->role->description }}</span>
                                        @endswitch
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver" onclick="detailUser( {{ $usuario->id }},'{{ $usuario->role->description }}' )">
                                                <i class="fa fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar" onclick="editUser( {{ $usuario->id }} )">
                                                <i class="fa fa-edit"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Eliminar" onclick="deleteUser( {{ $usuario->id }} )">
                                                <i class="fa fa-trash-alt"></i>
                                            </button>
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


    <div class="modal fade" id="usuarioModal" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/ajustes/usuarios" method="post" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-body pb-5">
                        <input type="hidden" id="id" name="id" value="">
                        <div class="form-group">
                            <label for="name" class="col-form-label">Nombre</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Indique su nombre">
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Indique su correo ">
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Indique su contraseña">
                        </div>
                        <div class="form-group">
                            <label for="rol_id">Rol</label>
                            <select class="js-select2 form-select" id="rol_id" name="rol_id" required style="width: 100%;" data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->id }}">{{ $rol->description }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="activo">Estatus</label>
                            <select class="js-select2 form-select" id="activo" name="activo" required style="width: 100%;" data-placeholder="Seleccione...">
                                <option value="">Seleccione...</option>
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
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

    <div class="modal fade" id="detalleUsuario" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalles del usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-1" id="detalleContent">
                    
                </div>
                <div class="modal-footer">
                    <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        var usuarios = {{ Js::from($usuarios) }};

        $(document).ready(function() {
            $('#rol_id').select2({dropdownParent: $('#usuarioModal')});
            $('#activo').select2({dropdownParent: $('#usuarioModal')});
        });

        function addNewUser() {
            $('#label').html("Agregar usuario");
            $('#id').val('');
            $('#name').val('');
            $('#email').val('');
            $('#password').val('');
            $('#rol_id').val('').change();
            $('#activo').val('').change();
            $('#usuarioModal').modal('show');
        }

        function editUser(id){
            let usuario = _.find(usuarios, function(o) { return o.id == id; });
            $('#label').html("Editar usuario");
            $('#id').val(usuario.id);
            $('#name').val(usuario.name);
            $('#email').val(usuario.email);
            $('#password').val('');
            $('#rol_id').val(usuario.rol_id).change();
            $('#activo').val(usuario.activo).change();
            $('#usuarioModal').modal('show');
        }

        function detailUser(id,rol){
            let usuario = _.find(usuarios, function(o) { return o.id == id; });
            let content = `
                <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
                <p><strong>Nombre:&nbsp; &nbsp; </strong><span>${usuario.name}</span></p>
                <p><strong>Correo Electrónico:&nbsp; &nbsp; </strong><span>${usuario.email}</span></p>
                <p><strong>Rol:&nbsp; &nbsp; </strong><span>${rol}</span></p>
                <p><strong>Estatus:&nbsp; &nbsp; </strong><span>${(usuario.activo) ? 'Activo' : 'Inactivo'}</span></p>
            `;

            $('#detalleContent').empty();
            $('#detalleContent').append(content);
            $('#detalleUsuario').modal('show');
        }

        function deleteUser(id){
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
                        let resp = await request(`/ajustes/usuarios/${id}`,'delete');
                        if(resp.status = 'success'){
                            Swal.fire({
                                title: resp.title,
                                text: resp.msg,
                                icon: resp.status,
                                confirmButtonText: 'Ok',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            })
                        }
                    }catch (error) {
                        Swal.fire(error.title,error.msg,error.status);
                    }
                }
            });
        }
    </script>
@endsection
