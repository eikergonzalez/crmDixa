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
                    <button type="button" class="btn btn-secondary">Nuevo</button>
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
                            @foreach($rol as $rol)
                            <tr>
                                <th class="text-center" scope="row">1{{$rol->id}}</th>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html">{{$rol->description}}</a>
                                </td>
                                <td class="fw-semibold">
                                <a href="be_pages_generic_profile.html">{{$rol->type_rol}}</a>
                                </td>
                                <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver">
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
@endsection
