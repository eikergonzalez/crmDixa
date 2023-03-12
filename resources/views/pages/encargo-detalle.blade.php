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
                        <button type="button" class="btn btn-sm btn-alt-secondary" title="Añadir Visitas">
                            <i class="fa fa-plus"> Añadir Visitas</i>
                        </button>
                        <button type="button" class="btn btn-sm btn-alt-secondary" title="Idealista">
                            <i class="fa fa-share-alt"> Idealista</i>
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
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver" onclick="detailNoticias( )">
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
    </div>
@endsection
