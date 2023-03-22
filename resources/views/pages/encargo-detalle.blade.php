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
                    <button type="button" class="btn btn-sm btn-alt-secondary" title="Añadir Visitas" onclick="addVisita()"> 
                        <i class="fa fa-plus"> Añadir Visitas</i>
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

                            <div class="block block-rounded mb-1">
                            <div class="block-header block-header-default" role="tab" id="accordion_h1">
                                <a class="fw-semibold" data-bs-toggle="collapse" data-bs-parent="#accordion" href="#accordion_q1" aria-expanded="true" aria-controls="accordion_q1">Imagenes</a>
                            </div>
                            <div id="accordion_q1" class="collapse" role="tabpanel" aria-labelledby="accordion_h1" data-bs-parent="#accordion">
                                <div class="block-content">
                                    <div class="row items-push js-gallery img-fluid-100">
                                        <div class="col-sm-6">
                                            <button type="button" class="btn btn-outline-primary bt-sm button_save_imagen" onclick="openFileImagen();">
                                                <i class="fa fa-fw fa-upload me-1"></i> Cargar Imagen
                                            </button>
                                            <a class="btn btn-primary button_loading_imagen" type="button" disabled>
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                Guardando...
                                            </a>
                                            <input type="file" id="file_imagen" style="display: none;"
                                                multiple="" accept="image/jpg, image/jpeg, image/png"
                                                onchange="upImagen({{ $inmuebleId }})" />
                                        </div>
                                        <br>
                                        <br>
                                        <div id="image_content" class="row">
                                            @foreach($imagenes as $image)
                                                <div class="col-sm-4 animated fadeIn">
                                                    <a class="img-link img-link-zoom-in img-thumb img-lightbox" href="{{ asset($image->path) }}">
                                                        <img class="img-fluid" src="{{ asset($image->path) }}" alt="">
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>

                <div class="table-responsive" id="row_table_visitas">
                    <br>
                    <br>
                    <br>
                    <table class="table table-hover table-vcenter" id="table_visitas">
                        <span class="nav-main-link-name">Visitas</span>
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 50px;">#</th>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Apellido</th>
                                <th class="text-center">Telefono</th>
                                <th class="text-center">Correo</th>
                                <th class="text-center" style="width: 100px;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="agendaModal" role="dialog" aria-labelledby="modal-default-normal" aria-hidden="true" data-backdrop="static" data-keyboard="false" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="label">Agregar Visita</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="#" method="post" autocomplete="off" id="formVisita">
                    {{ csrf_field() }}
                    <input type="hidden" id="inmueble_id" name="inmueble_id" >
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="nombre">Nombre</label>
                                    <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Indique su nombre" required>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="apellido">Apellido</label>
                                    <input type="text" class="form-control" id="apellido" name="apellido" placeholder="Indique su apellido" required>
                                </div>
                            </div>
                            <div class="col-sm-4 pb-3">
                                <div class="form-group">
                                    <label for="telefono">Telefono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Indique su telefono" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4 pb-3">
                            <div class="form-group">
                                <label for="correo">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Indique su correo" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a type="button" class="btn btn-secondary text-light" data-bs-dismiss="modal" aria-label="Close">Cerrar</a>
                        <button type="submit" class="btn btn-primary button_save_visitas">Guardar</button>
                        <a class="btn btn-primary button_loading_visitas" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardando...
                        </a>
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
        var uuid = null;

        $(document).ready(function() {
            $('#row_table_visitas').hide();
            $('#agendaModal').modal({backdrop: 'static'});
            hideLoadingVisitas();
            hideLoadingFiles();
            hideLoadingImagen();
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#correo').val('');
            getVisitas('{{ $propietarios->inmuebleid }}');
        });

        $("#formVisita").submit(async function(e){
            e.preventDefault();
            await saveVisitas();
            return false;
        });

        function addVisita(){
            $('#nombre').val('');
            $('#apellido').val('');
            $('#telefono').val('');
            $('#correo').val('');
            $('#agendaModal').modal('show');
        }

        async function getVisitas(idInmueble) {
            try{
                $('#inmueble_id').val(idInmueble);
                let resp = await request(`/visitas/${idInmueble}`,'get');

                if(resp.status = 'success'){
                    if(resp.data.length == 0){
                        $("#table_visitas tbody").empty();
                        $('#row_table_visitas').hide();
                        return;
                    }

                    llenarTabla(resp.data);
                }
            }catch (error) {
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        async function saveVisitas() {
            try{
                showLoadingVisitas();
                var data = {
                    nombre : $('#nombre').val(),
                    apellido : $('#apellido').val(),
                    telefono : $('#telefono').val(),
                    correo : $('#correo').val(),
                    inmueble_id : $('#inmueble_id').val(),
                }

                let resp = await request(`/visitas`,'post', data);
                if(resp.status = 'success'){
                    if(resp.data.length == 0){
                        $("#table_visitas tbody").empty();
                        $('#row_table_visitas').hide();
                        return;
                    }
                    hideLoadingVisitas();
                    llenarTabla(resp.data);
                    Swal.fire(resp.title,resp.msg,resp.status);
                    $('#agendaModal').modal('hide');
                }
            }catch (error) {
                hideLoadingVisitas();
                console.log("error: "+error);
                Swal.fire(error.title,error.msg,error.status);
            }
        }

        function llenarTabla(data) {
            $('#row_table_visitas').hide();
            $("#table_visitas tbody").empty();
            var newRowContent = '';

            if(data.length == 0){
                return;
            }
            $('#row_table_visitas').show();
            let count = 1;
            data.forEach((item) =>{
                newRowContent = `
                    <tr>
                        <td class="text-center">
                            ${count}
                        </td>
                        <td class="text-center">
                            ${item.nombre}
                        </td>
                        <td class="text-center">
                            ${item.apellido}
                        </td>
                        <td class="fw-semibold">
                            ${item.telefono}
                        </td>
                        <td class="text-center">
                            ${item.correo}
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm btn-alt-secondary" title="Ver" onclick="detailVisita()" data-toggle="modal" data-target="#vDetailModal">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                $("#table_visitas tbody").append(newRowContent);
                count++;
            });
        }

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

        function showLoadingVisitas() {
            $('.button_loading_visitas').show();
            $('.button_save_visitas').hide();
        }

        function hideLoadingVisitas() {
            $('.button_loading_visitas').hide();
            $('.button_save_visitas').show();
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

        async function upImagen(inmuebleId){
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
