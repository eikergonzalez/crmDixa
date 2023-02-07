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
                <div class="table-responsive">
                            <table class="table table-hover table-vcenter">
                            <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th>Descripcion</th>
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
                                <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver" onclick="detailRol( {{ $rol->id }} )">
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
    <div class="modal fade" id="detalleRol" tabindex="-1" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalles del Rol</h5>
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
 


<script type='text/javascript'>
    var rol = {{ Js::from($roles) }};

   function detailRol(id){
        let roles = _.find(rol, function(o) { return o.id == id; });
        let content = `
            <p><strong>Id:&nbsp; &nbsp; </strong> <span>${id}</span></p>
            <p><strong>Descripcion:&nbsp; &nbsp; </strong><span>${roles.description}</span></p>
        
        `;

        $('#detalleContent').empty();
        $('#detalleContent').append(content);
        $('#detalleRol').modal('show');
    }

        

</script>
@endsection