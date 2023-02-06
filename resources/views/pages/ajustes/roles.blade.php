@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Roles
                </h3>
            </div>
            <div class="block-content">
                <div class="col-sm-6 col-xl-4">
                    @if(Auth::user()->rol_id = 1)
                    <button type="button" class="btn btn-secondary" onclick="addNewRol()">Nuevo</button>
                    @endif
                </div>
                <div class="table-responsive">
                            <table class="table table-hover table-vcenter">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Descripcion</th>
                                <th>Tipo de Rol</th>
                                <th class="text-center" style="width: 100px;">Accion</th>
                            </tr>
                            </thead>

                            <tbody>
                                @foreach($roles as $rol)
                            <tr>
                                <th class="text-center" scope="row">{{$rol->id}}</th>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html">{{$rol->description}}</a>
                                </td>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html">admin</a>
                                </td>
                                <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver" data-id='{{ $rol->id }}' onclick="verRolModal();">
                                    <i class="fa fa-eye"></i>
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

  <!-- Modal New Rol-->
  <div class="modal fade" id="rolModal" >
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
                <h4 class="modal-title">Agregar Nuevo Rol</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
                <div class="col-lg-8 col-xl-5">
                    <div class="mb-4">
                      <label class="form-label" for="example-text-input">Descripcion</label>
                      <input type="text" class="form-control" id="description" name="description" placeholder="Descripcion Rol">
                    </div>
                    <div class="mb-4">
                      <label class="form-label" for="example-select">Tipo de Rol</label>
                      <select class="form-select" id="example-select" name="example-select">
                        <option selected>Seleccione:</option>
                        <option value="1">Gerente</option>
                        <option value="2">Coordinador</option>
                        <option value="3">Comercial</option>
                      </select>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>

<!-- Modal Ver Rol-->
<div class="modal fade" id="VerRolModal" >
    <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title">Ver Rol</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
                <div class="col-lg-8 col-xl-5">
                    <div class="mb-4">
                        <label class="form-label" for="example-static-input-plain">Descripcion</label>
                        <input type="text" readonly class="form-control-plaintext" id="description" name="description">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label" for="example-static-input-plain">Tipo de Rol</label>
                        <input type="text" readonly class="form-control-plaintext" id="type_rol" name="type_rol">
                    </div>
                </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        </div>
    </div>
    </div>
</div>
<script type='text/javascript'>
    var rol = {{ Js::from($rol) }};

    function addNewUser() {
        $('#label').html("Agregar Rol");
        $('#id').val('');
        $('#description').val('');
        $('#type_rol').val('');
        $('#rolModal').modal('show');
    }

   function detailUser(id){
            let rol = _.find(rol, function(o) { return o.id == id; });
            let content = `
                <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
                <p><strong>Descripcion:&nbsp; &nbsp; </strong><span>${rol.description}</span></p>
                <p><strong>Tipo de Rol:&nbsp; &nbsp; </strong><span>${rol.type_rol}</span></p>
            
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
                        let resp = await request(`/ajustes/rol/${id}`,'delete');
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