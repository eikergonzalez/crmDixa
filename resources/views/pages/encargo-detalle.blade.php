@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    Encargo - Direccion
                </h3>
            </div>
            <div class="block-content">
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
                            @foreach($propietarios as $propietario)
                            <tr>
                                <th class="text-center" scope="row">{{$propietario->propietarioid}}</th>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html">{{$propietario->nombre}} </a>
                                </td>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html">{{$propietario->apellido}}</a>
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
                                <td class="d-none d-sm-table-cell">
                                <span class="badge bg-warning">{{$propietario->solicitud}}</span>
                                </td>
                                <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver" onclick="detailNoticias( {{ $propietario->propietarioid }} )">
                                    <i class="fa fa-eye"></i>
                                    </button>
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Editar" onclick="editNoticias( {{ $propietario->propietarioid }} )" data-toggle="modal" data-target="#noticiaModal">
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
@endsection
