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
                        <button type="button" class="btn btn-sm btn-alt-secondary" title="Rebajas">
                            <i class="fa fa-briefcase"> Rebajas</i>
                        </button>
                        <button type="button" class="btn btn-sm btn-alt-secondary" title="Añadir Visitas" onclick="addVisita()" data-toggle="modal" data-target="#visitaModal"> 
                            <i class="fa fa-plus"> Añadir Visitas</i>
                        </button>
                </div>
            </div>
            <div class="block-content">
                
                <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                            <span class="nav-main-link-name"> Visitas</span>
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
                            <tr>
                                <th class="text-center" scope="row"></th>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html"></a>
                                </td>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html"></a>
                                </td>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html"></a>
                                </td>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html"></a>
                                </td>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html"></a>
                                </td>
                                <td class="d-none d-sm-table-cell">
                                <span class="badge bg-warning"></span>
                                </td>
                                <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Ver" onclick="detailVisita()" data-toggle="modal" data-target="#vDetailModal">
                                    <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                                </td>
                            </tr>
         
                            </tbody>
                        </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="visitaModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false" >
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Visita a este inmueble</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/visitas" method="post" autocomplete="off" id="form_valoracon">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <input type="hidden" id="id" name="id" value="">
                        <input type="hidden" id="id_inmueble" name="id_inmueble" value="">
                        <input type="hidden" id="id_agenda" name="id_agenda" value="">
                        <div class="row">
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="pedido">Seleccione su pedido</label>
                                    <select class="js-select2 form-select" id="pedidoid" name="pedidoid" style="width: 100%;" required data-placeholder="Seleccione...">
                                        <option value="">Seleccione...</option>
                                      
                                          
                                     
                                    </select>
                                </div>
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

    <div class="modal" id="vDetailModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <!-- <div class="modal-dialog" role="document">
            <div class="modal-content"> -->
                <!-- <div class="modal-header">
                    <h5 class="modal-title" id="label">Detalles</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> -->
               
            <!-- </div>
        </div> -->
    </div>

    <script>
        $(document).ready(function() {
           
            $('#visitaModal').modal({backdrop: 'static'});
            $('#vDetailModal').modal({backdrop: 'static'});

        });

        function addVisita() {
            $('#label').html("Agregar visita a un inmueble");
            $('#id').val('');
            $('#id_inmueble').val('');
            $('#pedidoid').val('').change();
            $('#visitaModal').modal('show');
        }

        function detailVisita() {
        
           $('#id').val('');
            $('#id_inmueble').val('');
            $('#pedidoid').val('').change();
            
            $('#detalleVi').empty();
            //$('#detalleVi').append(content);
            $('#vDetailModal').modal('show');
        }
    </script>
@endsection
