@extends('layouts.backend')

@section('content')
    <div class="content">
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="fa-fa-arrow-left block-title">
                    <a class="nav-main-link{{ request()->is('encargo-detalle') ? ' active' : '' }}" href="/encargo">
                        <i class="nav-main-link-icon far fa fa-arrow-left"></i>
                        <span class="nav-main-link-name"> Firma Pendiente - Direccion</span>
                    </a>
                </h3>
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
                    <div class="col-sm-6">
                        <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default" role="tab" id="accordion_h2">
                                <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q2" aria-expanded="true" aria-controls="accordion_q2">Archivos</a>
                            </div>
                            <div id="accordion_q2" class="collapse" role="tabpanel" aria-labelledby="accordion_h2" data-bs-parent="#accordion">
                                <div class="block-content" style="font-size: 12px">
                                    @foreach($tipoArchivo as $archivo)
                                        <div class="row">
                                            <div class="col-sm-8">
                                                @if( empty($archivo->getDocumentos($inmuebleId)->name_file) )
                                                    <i class="fa fa-fw fa-times me-1 text-danger" id="icon_{{ $archivo->id }}"></i> {{ $archivo->descripcion }}
                                                @else
                                                    <i class="fa fa-fw fa-check me-1 text-success" id="icon_{{ $archivo->id }}"></i> {{ $archivo->descripcion }}
                                                @endif
                                            </div>
                                            <div class="col-sm-4">
                                                @if( empty($archivo->getDocumentos($inmuebleId)->name_file) )
                                                    <button type="button" class="btn btn-outline-primary bt-sm button_save_files_{{ $archivo->id }} button_save_files" onclick="openFile({{ $archivo->id }});">
                                                        <i class="fa fa-fw fa-upload me-1"></i> Cargar
                                                    </button>
                                                    <a class="btn btn-primary button_loading_files_{{ $archivo->id }} button_loading_files" type="button" disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Guardando...
                                                    </a>
                                                    <input type="file" id="file_{{ $archivo->id }}" style="display: none;" data-id="{{ $archivo->id }}"
                                                        accept=".doc, .docx,.pdf"
                                                        onchange="upFile({{ $archivo->id }}, {{ $inmuebleId }})" />
                                                @else
                                                    <button type="button" class="btn btn-outline-primary bt-sm button_save_files_{{ $archivo->id }} button_save_files" onclick="openFile({{ $archivo->id }});">
                                                        <i class="fa fa-fw fa-upload me-1"></i> Actualizar 
                                                    </button>
                                                    <a class="btn btn-primary button_loading_files_{{ $archivo->id }} button_loading_files" type="button" disabled>
                                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                        Guardando...
                                                    </a>
                                                    <input type="file" id="file_{{ $archivo->id }}" style="display: none;" data-id="{{ $archivo->id }}"
                                                        accept=".doc, .docx,.pdf"
                                                        onchange="upFile({{ $archivo->id }}, {{ $inmuebleId }})" />
                                                @endif
                                            </div>
                                        </div>
                                        <hr>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        var uuid = null;

        $(document).ready(function() {
            hideLoadingFiles();
            $('#precio_solicitado').maskMoney({suffix:'€'});
        });

        function showLoadingImagen() {
            $('.button_loading_imagen').show();
            $('.button_save_imagen').hide();
        }

        function hideLoadingImagen() {
            $('.button_loading_imagen').hide();
            $('.button_save_imagen').show();
        }


        function showLoadingFiles() {
            $('.button_loading_files').show();
            $('.button_save_files').hide();
        }

        function hideLoadingFiles() {
            $('.button_loading_files').hide();
            $('.button_save_files').show();
        }

        function openFile(id) {
            $(`#file_${id}`).click();
        }

        function openFileImagen() {
            $(`#file_imagen`).click();
        }

        async function upFile (inmuebleId){
            try{
                uuid = '{{ \Illuminate\Support\Str::uuid()}}';

                $(`.button_loading_files_${id}`).show();
                $(`.button_save_files_${id}`).hide();

                var formData = new FormData();
                let documento_file = $(`#file_${id}`).prop('files');

                formData.append('uuid', uuid);
                formData.append('documento_file', documento_file[0]);
                formData.append('tipo', 'archivo');
                formData.append('tipo_archivo', id);
                formData.append('inmueble_id', inmuebleId);

                let resp = await requestFile(`/encargo/savefile`,'post',formData);

                if(resp.status = 'success'){
                    
                    $(`.button_loading_files_${id}`).hide();
                    $(`.button_save_files_${id}`).show();
                    $(`#icon_${id}`).attr('class', 'fa fa-fw fa-check me-1 text-success');

                    Swal.fire(resp.title,resp.msg,resp.status);
                }
            }catch (error) {
                $(`.button_loading_files_${id}`).hide();
                $(`.button_save_files_${id}`).show();
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function upImagenupImagen(inmuebleId){
            try{
                uuid = '{{ \Illuminate\Support\Str::uuid()}}';

                showLoadingImagen();

                var formData = new FormData();
                let images_file = $('#file_imagen').prop('files');

                images_file.forEach(element => {
                    formData.append('images_file[]', element);
                });

                formData.append('uuid', uuid);
                formData.append('tipo', 'imagen');
                formData.append('inmueble_id', inmuebleId);

                let resp = await requestFile(`/encargo/saveimagen`,'post',formData);

                if(resp.status = 'success'){
                    //showImages(resp.data);
                    hideLoadingImagen();
                    location.reload();
                    Swal.fire(resp.title,resp.msg,resp.status);
                }
            }catch (error) {
                hideLoadingImagen();
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        function showImages(images) {
            let protocol = window.location.protocol; // http:
            let url = window.location.hostname; //intergrow.site
            $("#image_content").empty();
            var newRowContent = '';

            if(images.length == 0){
                return;
            }

            images.forEach((item) =>{
                newRowContent = `
                    <div class="col-sm-4 animated fadeIn">
                        <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="${protocol}//${url}/${item.path}"
                            <img class="img-fluid" src="${protocol}//${url}/${item.path}" alt="">
                        </a>
                    </div>
                `;

                $("#image_content").append(newRowContent);
            });
        }
    </script>
@endsection
