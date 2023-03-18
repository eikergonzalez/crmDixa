<!doctype html>
    <html lang="{{ config('app.locale') }}" style="font-size: 13px !important">

        <head>
            <meta charset="utf-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

            <title>Dixa</title>

            <meta name="description" content="Diza">
            <meta name="author" content="inmobiliaria Dixa">
            <meta name="robots" content="noindex, nofollow">


            <meta name="csrf-token" content="{{ csrf_token() }}">

            <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
            <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
            <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

            @yield('css_before')

            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
            
            <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
            <link rel="stylesheet" href="{{ asset('js/plugins/select2/css/select2.css') }}">
            <link rel="stylesheet" href="{{ asset('js/plugins/fullcalendar/main.min.css') }}">
            <link rel="stylesheet" href="{{ asset('js/plugins/flatpickr/flatpickr.min.css') }}">
            <link rel="stylesheet" href="{{ asset('js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
            <link rel="stylesheet" href="{{ asset('js/plugins/magnific-popup/magnific-popup.css') }}">


            <link rel="stylesheet" id="css-main" href="{{ mix('css/dashmix.css') }}">
            <script src="{{ asset('js/plugins/jquery320/jquery3.2.0.js') }}" ></script>

            {{-- <style>
                .popper,
                .tooltip {
                  position: absolute;
                  z-index: 9999;
                  background: #0863eb;
                  /* color: black; */
                  width: 150px;
                  border-radius: 3px;
                  /* box-shadow: 0 0 2px rgba(0,0,0,0.5); */
                  padding: 10px;
                  text-align: center;
                }
                .style5 .tooltip {
                  /* background: #1E252B; */
                  color: #FFFFFF;
                  max-width: 200px;
                  width: auto;
                  font-size: .8rem;
                  padding: .5em 1em;
                }
                .popper .popper__arrow,
                .tooltip .tooltip-arrow {
                  width: 0;
                  height: 0;
                  border-style: solid;
                  position: absolute;
                  margin: 5px;
                }

                .tooltip .tooltip-arrow,
                .popper .popper__arrow {
                  border-color: #0863eb;
                }
                .style5 .tooltip .tooltip-arrow {
                  /* border-color: #1E252B; */
                }
                .popper[x-placement^="top"],
                .tooltip[x-placement^="top"] {
                  margin-bottom: 5px;
                }
                .popper[x-placement^="top"] .popper__arrow,
                .tooltip[x-placement^="top"] .tooltip-arrow {
                  border-width: 5px 5px 0 5px;
                  border-left-color: transparent;
                  border-right-color: transparent;
                  border-bottom-color: transparent;
                  bottom: -5px;
                  left: calc(50% - 5px);
                  margin-top: 0;
                  margin-bottom: 0;
                }
                .popper[x-placement^="bottom"],
                .tooltip[x-placement^="bottom"] {
                  margin-top: 5px;
                }
                .tooltip[x-placement^="bottom"] .tooltip-arrow,
                .popper[x-placement^="bottom"] .popper__arrow {
                  border-width: 0 5px 5px 5px;
                  border-left-color: transparent;
                  border-right-color: transparent;
                  border-top-color: transparent;
                  top: -5px;
                  left: calc(50% - 5px);
                  margin-top: 0;
                  margin-bottom: 0;
                }
                .tooltip[x-placement^="right"],
                .popper[x-placement^="right"] {
                  margin-left: 5px;
                }
                .popper[x-placement^="right"] .popper__arrow,
                .tooltip[x-placement^="right"] .tooltip-arrow {
                  border-width: 5px 5px 5px 0;
                  border-left-color: transparent;
                  border-top-color: transparent;
                  border-bottom-color: transparent;
                  left: -5px;
                  top: calc(50% - 5px);
                  margin-left: 0;
                  margin-right: 0;
                }
                .popper[x-placement^="left"],
                .tooltip[x-placement^="left"] {
                  margin-right: 5px;
                }
                .popper[x-placement^="left"] .popper__arrow,
                .tooltip[x-placement^="left"] .tooltip-arrow {
                  border-width: 5px 0 5px 5px;
                  border-top-color: transparent;
                  border-right-color: transparent;
                  border-bottom-color: transparent;
                  right: -5px;
                  top: calc(50% - 5px);
                  margin-left: 0;
                  margin-right: 0;
                }

            </style> --}}

            @yield('css_after')

            <script>
                window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
            </script>

         
        </head>
        <body>

            <div id="page-container" class="sidebar-o enable-page-overlay page-header-dark side-scroll page-header-fixed main-content-narrow">
                @include('layouts.navbar')
                @include('layouts.header')

                <main id="main-container">
                    @yield('content')
                </main>

                @include('layouts.footer')
            </div>

            <script src="{{ mix('js/dashmix.app.js') }}"></script>
            <script src="{{ asset('js/plugins/fullcalendar/main.min.js') }}"></script>
            <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.js') }}"></script>
            <script src="{{ asset('js/plugins/select2/js/select2.full.js') }}"></script>
            <script src="{{ asset('js/plugins/lodash.js') }}"></script>
            <script src="{{ asset('js/plugins/moment.js') }}"></script>
            <script src="{{ asset('js/plugins/tooltip.js') }}"></script>
            <script src="{{ asset('js/plugins/popper.js') }}"></script>
            <script src="{{ asset('js/plugins/flatpickr/flatpickr.min.js') }}"></script>
            <script src="{{ asset('js/plugins/flatpickr/l10n/es.js') }}"></script>
            <script src="{{ asset('js/plugins/maskmoney/jquery.maskMoney.js') }}"></script>
            <script src="{{ asset('js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
            <script src="{{ asset('js/plugins/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

            <script>Dashmix.helpersOnLoad(['jq-select2','js-flatpickr', 'jq-datepicker', 'jq-magnific-popup']);</script>

            @yield('js_after')

            <script>
                $(document).ready(function() {
                    @if(session()->has('status'))
                        @php
                            $status = session('status');
                        @endphp
                        Swal.fire('{{ $status['title'] }}', '{{ $status['msg'] }}', '{{ $status['status'] }}');
                    @endif
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

                async function requestFile(url,type,params = null){
                    return new Promise((resolve,reject)=> {
                        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
                        $.ajax({
                            type: type,
                            url: url,
                            cache: false,
                            contentType: false,
                            processData: false,
                            enctype: 'multipart/form-data',
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

                function amountFormat(amount) {
                    return parseFloat(amount).toLocaleString('es-ES', {style: 'currency', currency: 'EUR'});
                }
            </script>

          {{-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyANhZX_i0lpjin5oaGV52po4kYbyQoqz10&libraries=places&language=es"></script>

          <script>

              function extractFromAddress(components, type) {
                  return components.filter((component) => component.types.indexOf(type) === 0).map((item) => item.long_name).pop() || null;
              }
              
              function initialize() {
                  var options = {
                      componentRestrictions: {country: "es"}
                  };
                  var input = document.getElementById('searchTextField');
                  var autocomplete = new google.maps.places.Autocomplete(input, options);

                  google.maps.event.addListener(autocomplete, 'place_changed', function () {
                      var place = autocomplete.getPlace();
                      document.getElementById('calle').value = extractFromAddress(place.address_components, "route");
                      document.getElementById('ciudad').value = extractFromAddress(place.address_components, "locality");
                      document.getElementById('cp').value = extractFromAddress(place.address_components, "postal_code");
                      document.getElementById('pais').value = "España";
                  });
              }

              google.maps.event.addDomListener(window, 'load', initialize);

          </script> --}}

</body>

</html>
