<!doctype html>
<html lang="en" style="font-size: 12px">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Dixa</title>

        <meta name="description" content="Dixa">
        <meta name="author" content="inmobiliaria Dixa">
        <meta name="robots" content="noindex, nofollow">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

        @yield('css_before')

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

        <link rel="stylesheet" id="css-main" href="{{ mix('css/dashmix.css') }}">
        <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
        <script src="{{ asset('js/plugins/jquery320/jquery3.2.0.js') }}" ></script>

        <style>
            .wrapper {
                position: relative;
                width: 400px;
                height: 200px;
                
            }

            .signature-pad {
                position: absolute;
                left: 0;
                top: 0;
                width:400px;
                height:200px;
                background-color: white;
            }
        </style>
    </head>
    <body>
        <div id="page-container" class="sidebar-mini sidebar-dark enable-page-overlay side-scroll page-header-fixed main-content-narrow">

            <main id="main-container">

                <div class="content content-boxed">
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">{{ $id }}</h3>
                            <div class="block-options">
                            <button type="button" class="btn-block-option" onclick="Dashmix.helpers('dm-print');">
                              <i class="si si-printer me-1"></i> Imprimir
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="p-sm-4 p-xl-4">
                            <div class="row mb-5">
                                <div class="col-2">
                                    <img src="{{ asset('images/logo_contrato.png') }}" width="150px" height="110px">
                                </div>
                                <div class="col-7 text-center">
                                    @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                        <img src="{{ asset('images/propuesta_contrato_compraventa.png') }}" width="520px" height="100px">
                                    @else
                                        <img src="{{ asset('images/propuesta_contrato_arrendamiento.png') }}" width="520px" height="100px">
                                    @endif
                                </div>
                                <div class="col-3 text-end">
                                    <address>
                                        Tlf. oficina.: 91 2770619<br>
                                        www.dixainmobiliaria.com<br>
                                        Mail: info@dixainmobiliaria.com<br>
                                    </address>
                                </div>
                            </div>

                            <div class="row mb-3">
                                @php
                                    $index = 1;
                                @endphp
                                @foreach ($data_json->propietarios as $propietario)
                                    <div class="col-12 mb-3">
                                        <address>
                                            @if($index == 1)<b>1)</b> @endif <b>D./Dª</b> {{ $propietario->nombre }} <b>mayor de edad, con domicilio en</b> {{ $propietario->domicilio }}, <b>teléfono</b> {{ $propietario->telef }},
                                            <b>e-mail</b> {{ $propietario->mail }}, <b>N.I.F</b> {{ $propietario->nif }}
                                        </address>
                                    </div>
                                    @php
                                        $index++;
                                    @endphp
                                @endforeach
                            </div>

                            <div class="row">
                                <div class="col-3">
                                    <label class="form-label">Actuando:</label>
                                </div>
                                <div class="col-sm-9">
                                    <div class="mb-4">
                                        <div class="space-y-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled @if($data_json->actuando == 'propio') checked @endif>
                                                <label class="form-check-label" for="actuando1"><b>En su propio nombre y representación (en adelante, el Cliente)</b></label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" disabled @if($data_json->actuando == 'otro') checked @endif>
                                                @if($data_json->actuando == 'propio')
                                                    <label class="form-check-label" for="actuando2">
                                                        <b>En nombre y representación de...</b>
                                                    </label>
                                                @else
                                                    <label class="form-check-label" for="actuando2">
                                                        <b>En nombre y representación de...</b> {{ $data_json->nombre_rep }}  <b>(en adelante, el Cliente), con domicilio en</b> {{ $data_json->domicilio_rep }},
                                                        <b>provisto de N.I.F./C.I.F</b> {{ $data_json->nif_rep }}, <b>en calidad de</b> {{ $data_json->calidad_rep }}, <b>según acredita documentalmente.</b>
                                                    </label>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <address>ENCARGA, de forma exclusiva, al Grupo Inmobiliario DIXA (en adelante, la Agencia), que acepta el encargo:
                                        la localización de un arrendatario para el inmueble identificado como sigue: <br><br>
                                        <b>Dirección:</b> {{ $data_json->cont_direccion }}, <b>Datos Registrales:</b> {{ $data_json->cont_regitrales }},
                                        <b>Datos catastrales:</b> {{ $data_json->cont_catastrales }}, <b>Metros cuadrados útiles:</b> {{ $data_json->cont_metros_utiles }},
                                        <b>Metros cuadrados construidos:</b> {{ $data_json->cont_metros_construidos }}, <b>Metros cuadrados Anexos:</b> {{ $data_json->cont_metros_anexos }},
                                        <b>Otros:</b> {{ $data_json->cont_otros }}.
                                    </address>
                                </div>
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>2)</b> El precio propuesto para la compra del inmueble queda fijado en:
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->precioInmueble, 'EUR') }}</b>
                                            <br>
                                            <b>El pago se hará del siguiente modo:</b>
                                            <br>
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->pago1, 'EUR') }}</b>,
                                            A la firma del presente documeto por el Proponente, como prueba de su voluntad de suscribir un contrato de compraventa
                                            de dicho inmueble. En el supuesto de que la presente propuesta fuese conforme con el Encargo de Venta suscrito por 
                                            el vendedor, dicha cantidad, a cuenta del precio del inmueble, constituirá arras o señal según lo establecido
                                            en el art. 1.454 del Código Civil. En supuesto contrario, dicha cantidad, a la aceptación de la presente propuesta por el vendedor
                                            constituirá arras o señal según lo establecido en el mismo precepto.
                                            <br>
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->pago2, 'EUR') }}</b>,
                                            A la firma del contrato privado o de compraventa y
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->pago3, 'EUR') }}</b>, 
                                            Con ocación del otorgamiento de la escritura pública de compraventa
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>2)</b> El cliente determina que el plazo de duración del arrendamiento será de: <b>{{ $data_json->duracionArendamiento }}</b> 
                                            @if($data_json->timeArrendamiento == 'month') meses, @else años, @endif
                                            destinándose el inmueble a:
                                        </address>
                                        <div class="space-x-2 text-center">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" disabled @if($data_json->usoVivienda == 1) checked @endif>
                                                <label class="form-check-label" for="uso_vivienda1"><b>Vivienda</b></label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" disabled @if($data_json->usoVivienda == 2) checked @endif>
                                                <label class="form-check-label" for="uso_vivienda2"><b>Uso distinto del de vivienda</b></label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>


                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>3)</b> El inmueble en objeto será enregado libre de <b>cargas, gravámenes, vicios y evicciones a excepción de <b>{{ $data_json->carga }}</b>.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>3)</b> El cliente fija el precio mensual de arrendamiento en: 
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->precioAlquiler, 'EUR') }}</b>
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>4)</b> El proponente se compromete a suscribir el contrato privado de compraveta antes del dia
                                            <b>{{ \Carbon\carbon::parse($data_json->fechaAntes1)->format('d/m/Y') }}</b>, Y la escritura pública de compraventa antes del dia
                                            <b> {{ \Carbon\carbon::parse($data_json->fechaAntes2)->format('d/m/Y') }}</b>,
                                            Dicho compromiso, salvo pacto contrario, será asumido del mismo modo por el Vendedor, 
                                            si la presente propuesta hubiera sido formulada por el Proponente  conforme al Encargo de Venta
                                            del inmueble, o si a pesar de no ser conforme al Encargo, el Vendedor la aceptará formalmente.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b></b>4)</b> El Proponente, a la firma del presente documento, y como prueba de su voluntad de 
                                        suscribir un contrato de arrendamiento de dicho inmueble, entrega el importe de 
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->importeInmueble, 'EUR') }}</b>
                                            <br>
                                            Dicha cantidad, a la aceptaciónde la presente propuesta por el Arrendador, constituirá:
                                            <br>
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->fianza, 'EUR') }}</b> Fianza
                                            <br>
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->mensualidadAnticipada, 'EUR') }}</b> Una mensualidad de renta anticipada
                                        </address>
                                    </div>
                                @endif
                            </div>

                            

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>5)</b> En el supuesto e que la presente propuesta fuese conforme con el encargo suscrito por el Vendedor, ésta será
                                            vinculante para el Proponente y el Vendedor, desde la firma del primero. En caso contrario, la presente propuesta
                                            será vinculante para el Proponente y para el Vendedor, una vez que haya sido aceptada por este.
                                            En este último caso, de no ser aceptada en el plazo de 1 días, se reestituirá al Prponente la cantidad
                                            entregada en concepto de arras o señal.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>5)</b> El proponente se compromete a aportar una garantía adicional consistente en 
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->garantiaAdicional, 'EUR') }}</b>
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>6)</b> Habiendo sido aceptada la presente propuesta o habiendo sido formulada conforme con el encargo, 
                                            la falta de suscripción del contrato de compra - venta en los plazos y condiciones establecidos 
                                            en las cláusulas precedentes por causa imputable al Proponente, comportará la pérdida de las sumas 
                                            abonadas por él en concepto de arras en favor del Vendedor. Si la causa de dicha falta de suscripción 
                                            fuera imputable al Vendedor, éste deberá devol - verlas dobladas al Proponente (art. 1.454 del Código Civil).
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>6)</b> La presente propuesta será vinculante para el Proponente y el Arrendador, una vez que haya sido aceptada por éste.
                                            Si la propuesta no fuese aceptada por el Arrendador en el plazo de 15 días, se restituirá al Proponente 
                                            el importe referido en la cláusula cuarta.</b>.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>7)</b> {{ $data_json->textPto7 }}
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>7)</b> La falta de suscripción del contrato de arrendamiento en el plazo indicado en la cláusula primera 
                                            por causa imputable al Proponente, comportará la pérdida del importe referido en la cláusula cuarta, 
                                            en favor del Arrendador. Si la falta de suscripción fuera imputable al Arrendador, éste deberá devolver 
                                            el doble de dicho importe al proponente.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>8)</b> El Proponente declara expresamente conocer y aceptar la situación urbanística, el estado del inmueble, así como las normas de la Comunidad de Vecinos.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-5 offset-md-3 text-center">
                                    <h4>Realizar firma</h4>
                                    <div class="wrapper border border-dark text-center">
                                        <canvas id="signature-pad" class="signature-pad" width=400 height=200></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-5 offset-md-3 text-center">
                                    {{-- <button id="save-png">Save as PNG</button>
                                    <button id="save-jpeg">Save as JPEG</button>
                                    <button id="save-svg">Save as SVG</button>
                                    <button id="draw">Draw</button>
                                    <button id="erase">Erase</button> --}}
                                    <button type="button" class="btn btn-danger" id="clear" >Borrar</button>
                                    <button type="button" class="btn btn-success button_save" id="guardar">Guardar</button>
                                    <a class="btn btn-primary button_loading" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        Guardando...
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <script src="{{ mix('js/dashmix.app.js') }}"></script>
        <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
        <script src="{{ asset('js/signature_pad.js') }}"></script>
        <script>

            var canvas = document.getElementById('signature-pad');
            
            $(document).ready(function() {
                hideLoading();
                signaturePad.clear();
            });

            function resizeCanvas() {
                var ratio =  Math.max(window.devicePixelRatio || 1, 1);
                canvas.width = canvas.offsetWidth * ratio;
                canvas.height = canvas.offsetHeight * ratio;
                canvas.getContext("2d").scale(ratio, ratio);
            }

            window.onresize = resizeCanvas;
            resizeCanvas();

            var signaturePad = new SignaturePad(canvas, {
                backgroundColor: 'rgb(255, 255, 255)'
            });

            document.getElementById('clear').addEventListener('click', function () {
                signaturePad.clear();
            });

            document.getElementById('guardar').addEventListener('click', async function () {
                var data = {
                    firma : signaturePad.toDataURL('image/png')
                }

                if(signaturePad.isEmpty()){
                    Swal.fire("Alerta!",`Debe indicar la firma`,'warning');
                    return false;
                }
                let id = '{{ $id }}';
                let uuid = '{{ $uuid }}';
                try{
                    //showLoading();
                    hideLoading();
                    let resp = await request(`/propuesta/${id}/${uuid}`,'post',data);

                    if(resp.status = 'success'){
                        //location.reload();
                        Swal.fire(resp.title,resp.msg,resp.status);
                    }

                }catch (error) {
                    hideLoading();
                    Swal.fire(error.title,error.msg,error.status);
                }
            });

            async function request(url,type,params = null){
                return new Promise((resolve,reject)=> {
                    $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                    $.ajax({
                        type: type,
                        url: url,
                        data: params,
                        success: function(response){
                            resolve(response);
                        },
                        error: function(xhr) {
                            var obj = JSON.parse(xhr.responseText);
                            reject(obj);
                        }
                    });
                });
            }

            function showLoading() {
                $('.button_loading').show();
                $('.button_save').hide();
            }

            function hideLoading() {
                $('.button_loading').hide();
                $('.button_save').show();
            }

            /* document.getElementById('save-png').addEventListener('click', function () {
              if (signaturePad.isEmpty()) {
                return alert("Please provide a signature first.");
              }
              
              var data = signaturePad.toDataURL('image/png');
              console.log(data);
              window.open(data);
            }); */

            /* document.getElementById('save-jpeg').addEventListener('click', function () {
              if (signaturePad.isEmpty()) {
                return alert("Please provide a signature first.");
              }

              var data = signaturePad.toDataURL('image/jpeg');
              console.log(data);
              window.open(data);
            }); */

            /* document.getElementById('save-svg').addEventListener('click', function () {
              if (signaturePad.isEmpty()) {
                return alert("Please provide a signature first.");
              }

              var data = signaturePad.toDataURL('image/svg+xml');
              console.log(data);
              console.log(atob(data.split(',')[1]));
              window.open(data);
            }); */

            /* document.getElementById('draw').addEventListener('click', function () {
              var ctx = canvas.getContext('2d');
              console.log(ctx.globalCompositeOperation);
              ctx.globalCompositeOperation = 'source-over'; // default value
            });

            document.getElementById('erase').addEventListener('click', function () {
              var ctx = canvas.getContext('2d');
              ctx.globalCompositeOperation = 'destination-out';
            }); */
        </script>
    </body>
</html>
