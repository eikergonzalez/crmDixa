@extends('layouts.backend')

@section('content')
<div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    De Baja
                </h3>
            </div>
            <div class="block-content">
               h
                    </tbody> <div class="col-sm-6 col-xl-4">
                   
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
                        @foreach($propietarios as $propietario)
                        <tr>
                            <th class="text-center" scope="row">{{$propietario->propietarioid}}</th>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->direccion}} </a>
                            </td>
                            <td class="d-none d-sm-table-cell">
                            <span class="badge bg-warning">{{$propietario->solicitud}}</span>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->nombre}} - {{$propietario->apellido}}</a>
                            </td>
                            <td class="fw-semibold">
                            <a href="be_pages_generic_profile.html">{{$propietario->estatus}}</a>
                            </td>
                            <td class="text-center">
                            <div class="btn-group">
                                @if(Auth::user()->rol_id <> 4)
                                    <button type="button" class="btn btn-sm btn-alt-secondary" data-bs-toggle="tooltip" title="Ver">
                                    <i class="fa fa-eye"></i>
                                    </button>
                                @endif
                            </div>
                            </td>
                        </tr>
                        @endforeac
                    </table>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
