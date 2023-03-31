@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="fa-fa-arrow-left block-title">
                    <a class="nav-main-link{{ request()->is('de-baja-detalle') ? ' active' : '' }}" href="/de-baja">
                        <i class="nav-main-link-icon far fa fa-arrow-left"></i>
                        <span class="nav-main-link-name"> Detalle</span>
                    </a>
                </h3>
                <div class="btn-group">
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Rebajas" onclick="cambiarestatus()">
                        <i class="fa fa-exchange-alt"> Cambiar a Disponible</i>
                    </button>
                </div>
            </div>
            <div class="block-content">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <p><b> Tipo de Solicitud: </b> {{ $propietarios->solicitud }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Nombre: </b> {{ $propietarios->nombre }} {{ $propietarios->apellido }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Teléfono: </b> {{ $propietarios->telefono }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Dirección: </b> {{ $propietarios->direccion }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Precio Solicitado: </b> {{ $propietarios->precio_solicitado }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Precio Valorado: </b> {{ $propietarios->precio_valorado }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Metros Útiles: </b> {{ $propietarios->metros_utiles }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Metros Usados: </b> {{ $propietarios->metros_usados }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Ascensor: </b> {{ $propietarios->ascensor }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> # habitaciones: </b> {{ $propietarios->habitaciones }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Exposición: </b> {{ ($propietarios->exposicion == 'IN') ? 'Interior' : 'Exterior' }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Hipoteca: </b> {{ $propietarios->hipoteca }} </p>
                            </div>
                            @if($propietarios->hipoteca == 'SI')
                                <div class="col-sm-6">
                                    <p><b> Valor de la Hipoteca: </b> {{ $propietarios->hipoteca_valor }} </p>
                                </div>
                            @endif
                            <div class="col-sm-6">
                                <p><b> Herencia: </b> {{ $propietarios->herencia }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Reforma: </b> {{ $propietarios->reforma }} </p>
                            </div>
                            <div class="col-sm-6">
                                <p><b> Tipo de Inmueble: </b> {{ $propietarios->tipoinmueble }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        var propietarios = {{ Js::from($propietarios) }};

        console.log(propietarios);

        async function cambiarestatus() {
            Swal.fire({
                title: '¿Está de acuerdo en cambiar a Disponible?',
                text: " ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#C62D2D',
                confirmButtonText: 'Si',
                cancelButtonText: 'No ',
            }).then(async (result) => {
                if (result.value) {
                    try{
                        var data = {
                            estatus : 8
                        };
                        console.log("paso aqui"+data);
                        let resp = await request(`/debaja/cambiarestatus/${propietarios.inmuebleid}`,'post', data);
                        console.log(resp);
                        if(resp.status = 'success'){
                            Swal.fire({
                                title: resp.title,
                                text: resp.msg,
                                icon: resp.status,
                                confirmButtonText: 'Ok',
                            });
                        }
                    }catch (error) {
                        Swal.fire(error.title,error.msg,error.status);
                    }
                }
            });
        }
       

    </script>
@endsection