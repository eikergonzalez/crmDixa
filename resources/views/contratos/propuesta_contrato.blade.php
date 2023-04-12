<!doctype html>
<html lang="en">
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
                                            <b>2)</b> El cliente fija el precio del inmueble en:
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->precioInmueble, 'EUR') }}</b>
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>4)</b> El cliente determina que el plazo de duración del arrendamiento será de: <b>{{ $data_json->duracionArendamiento }}</b> 
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
                                            <b>2)</b> El cliente afirma que el citado inmueble se encuentra libre de cargas, gravámenes, vicios y evicciones a excepción de <b>{{ $data_json->carga }}</b>.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>2)</b> La Agencia se obliga a realizar las gestiones de mediación oportunas para la 
                                            localización de un arrendatario, y a mantener informado de tales gestiones al Cliente.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>3)</b> El cliente declara tener la total y exclusiva disponibilidad del 
                                            inmueble en objeto, en su afirmada condición de propietario, según deberá 
                                            acreditar documentalmente.
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
                                            <b>5)</b> La agencia se obliga a realizar las gestiones de mediación 
                                            oportunas para la localización de un comprador, y a mantener informado al Cliente de tales gestiones.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>5)</b> El importe que el arrendatario deberá entregar en concepto de Fianza corresponderá (art. 36 LAU) a:
                                        </address>
                                        <div class="space-y-2">
                                            <div class="form-check form-check">
                                                <input class="form-check-input" type="radio" value="1" disabled @if($data_json->importeArrendamiento == 1) checked @endif>
                                                <label class="form-check-label" for="check_pto51"><b>una mensualidad (arrendamiento de vivienda)</b></label>
                                            </div>
                                            <div class="form-check form-check">
                                                <input class="form-check-input" type="radio" value="2" disabled @if($data_json->importeArrendamiento == 2) checked @endif>
                                                <label class="form-check-label" for="check_pto52"><b>dos mensualidades (arrendamiento para uso distinto del de vivienda)</b></label>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>6)</b> Los honorarios a percibir por la Agencia del Cliente serán del <b>{{ $data_json->honorariosCliente }}</b>, que se abonarán a la firma del contrato privado de compraventa, 
                                            en caso de que no tuviera lugar la firma del contrato privado de
                                            compraventa, formalizándose esta directamente en escritura pública, 
                                            dichos honorarios serán satisfechos por Cliente con ocasión 
                                            del otorgamiento de esta.
                                        </address>
                                        <address>
                                            Los honorarios a percibir por la Agencia del Comprador serán de <b>{{ $data_json->honorarioAgenciaComprador }}</b>.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>6)</b> El Cliente requiere que el arrendatario aporte una garantía adicional consistente en <b>{{ $data_json->garantia }}</b>.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>7)</b> El encargo tendrá validez desde el día <b>{{ \Carbon\carbon::parse($data_json->fechaValidezDesdeCompra)->format('d/m/Y') }}</b> hasta el <b>{{ \Carbon\carbon::parse($data_json->fechaValidezHastaCompra)->format('d/m/Y') }}</b>, 
                                            Este plazo se presumirá tácitamente renovado, de forma sucesiva, por
                                            idénticos períodos de tiempo, salvo que cualquiera de las dos partes 
                                            notifique por escrito a la otra su voluntad en contrario con, al menos,
                                            7 días de antelación respecto a la finalización del plazo o de cualquiera
                                            de sus prórrogas.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>7)</b> Los honorarios a percibir por la Agencia serán equivalentes a <b>{{ $data_json->honoraiosAgencia }}</b> mensualidad de renta + I.V.A.
                                            que se abonarán a la firma del contrato de
                                            arrendamiento y serán satisfechos por partes iguales por el Cliente y el Arrendatario.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>8)</b> El Cliente autoriza la Agencia a solicitar y recibir arras o señal del Comprador por un importe máximo de
                                            <b>{{ numfmt_format_currency(numfmt_create('es_ES', NumberFormatter::CURRENCY), $data_json->importeComprador, 'EUR') }}</b> 
                                            y a retenerlas como depositario de las mismas hasta la firma del contrato de compraventa.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>8)</b> El encargo tendrá validez desde el día <b>{{ \Carbon\carbon::parse($data_json->fechaValidezDesdeArrenda)->format('d/m/Y') }}</b> hasta el <b>{{ \Carbon\carbon::parse($data_json->fechaValidezHastaArrenda)->format('d/m/Y') }}</b>,
                                            Este plazo se presumirá tácitamente renovado, de forma sucesiva, por
                                            idénticos períodos de tiempo, si el Cliente no manifiesta por escrito 
                                            a la Agencia su voluntad en contrario con, al menos, 7 días de antelación respecto de la finalización
                                            del plazo o de cualquiera de sus prórrogas.<br>
                                            Expirado el plazo antes citado o cualquiera de sus prórrogas sin que la Agencia 
                                            haya localizado un arrendatario conforme con el presente encargo, éste no tendrá derecho
                                            a percibir cantidad alguna en concepto de honorarios.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>9)</b> El Cliente autoriza, asimismo, a la Agencia a ofertar y publicitar el inmueble. 
                                            Del mismo modo, el Cliente autoriza que la Agencia realice visitas
                                            comerciales al inmueble acompañado de potenciales compradores.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>9)</b> El Cliente autoriza a la Agencia a solicitar y recibir los importes 
                                            correspondientes a la Fianza y a una mensualidad de renta anticipada, y a retenerlas como depositaria
                                            de las mismas hasta la firma del contrato de arrendamiento.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>10)</b> En los siguientes supuestos, el Cliente abonará a la Agencia la totalidad de los 
                                            gastos en los que éste haya incurrido hasta el momento con ocasión de las gestiones 
                                            objeto del presente encargo, así como los honorarios que proporcionalmente le correspondan 
                                            atendiendo a las gestiones realizadas y, en su caso, al tiempo transcurrido:
                                        </address>
                                        <ul>
                                            <li>La venta se lleve a cabo por ter ceros durante el plazo de vigencia del presente en cargo.</li>
                                            <li>En el transcurso de un año desde la fecha de finalización del encargo, se realizase la venta a favor de personas presentadas al Cliente por la Agencia.</li>
                                            <li>El Cliente revoca el encargo antes de su caducidad.</li>
                                        </ul>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>10)</b> El Cliente autoriza, asimismo, a la Agencia a ofertar y publicitar el inmueble.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>11)</b> Los honorarios convenidos deberán ser abonados por el Cliente en su totalidad en el supuesto de que: 
                                        </address>
                                        <ul>
                                            <li>sin mediar justa y adecuada causa el Cliente se negara a suscribir un contrato de compraventa 
                                                que trajera causa de una propuesta de compra conforme con el presente encargo o, 
                                                no siendo conforme con éste, el Cliente la hubiese aceptado.
                                            </li>
                                        </ul>
                                        <p>
                                            Para determinar los honorarios a satisfacer en los casos previstos en esta cláusula y en la precedente, 
                                            se aplicará al precio del inmueble determinado en la clausula 4, el porcentaje a satisfacer por el Cliente estipulado en la cláusula 7
                                        </p>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>11)</b> El Cliente declara tener la total y exclusiva disponibilidad del inmueble, en su afirmada condición de propietario, según deberá acreditar documentalmente.
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    <div class="col-12">
                                        <address>
                                            <b>12)</b> La agencia se obliga a indemnizar al CLiente ante la injustificada renuncia del encargo por su parte o ante la manifiesta 
                                            y probada falta de realización de las gestiones de mediación propias ara la locaclización de un comprador,
                                            de haber causado éstas un daño.
                                        </address>
                                    </div>
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>12)</b> El Cliente efectuará la entrega del inmueble en el momento/ fecha {{ \Carbon\carbon::parse($data_json->fechaEntregaArrendamiento)->format('d/m/Y') }}
                                        </address>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                @if($contrato->tipo_contrato == 'PROPUESTA_CONTRATO_COMPRAVENTA')
                                    @if(!empty($data_json->condicionCompra))
                                        <div class="col-12">
                                            <address>
                                                <b>13)</b> {{ $data_json->condicionCompra }}
                                            </address>
                                        </div>
                                    @endif
                                @else
                                    <div class="col-12">
                                        <address>
                                            <b>13)</b> En los siguientes supuestos, el Cliente abonará a la Agencia la totalidad de los 
                                            gastos en los que ésta haya incurrido con ocasión de las gestiones objeto del presente
                                            encargo, y los honorarios correspondientes:
                                        </address>
                                        <ul>
                                            <li>
                                                El arrendamiento se lleva a cabo por el Cliente o terceros durante el plazo de vigencia del presente encargo.
                                            </li>
                                            <li>
                                                En el transcurso de un año desde la fecha de finalización del encargo, se realizase el arrendamiento a favor de personas presentadas al Cliente por la Agencia.
                                            </li>
                                            <li>
                                                Revoca el encargo antes de su caducidad.
                                            </li>
                                        </ul>
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
                    let resp = await request(`/contrato/${id}/${uuid}`,'post',data);

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
