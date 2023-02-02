@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Encargo
                </h3>
            </div>
            <div class="block-content">
                <div class="col-sm-6 col-xl-4">
                    <button type="button" class="btn btn-secondary">Nuevo</button>
                    <div class="mt-2">
                    
                    </div>
                </div>
                <div class="table-responsive">
                        <table class="table table-hover table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>Direccion</th>
                            <th>Tipo Solicitud</th>
                            <th>Nombre y Apellido</th>
                            <th>Estatus</th>
                            <th class="text-center" style="width: 100px;">Accion</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                        <th class="text-center" scope="row">1</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">España Madrid </a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">Venta</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">Ralph Murray</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">En seguimiento</a>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver">
                                <i class="fa fa-eye"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar">
                                <i class="fa fa-user"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Eliminar">
                                <i class="fa fa-share-alt"></i>
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
    </div>
@endsection
