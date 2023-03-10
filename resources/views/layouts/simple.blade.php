<!doctype html>
    <html lang="{{ config('app.locale') }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Dixa</title>

        <meta name="description" content="Diza">
        <meta name="author" content="Inmobiliaria">
        <meta name="robots" content="noindex, nofollow">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <link rel="shortcut icon" href="{{ asset('media/favicons/favicon.png') }}">
        <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('media/favicons/favicon-192x192.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('media/favicons/apple-touch-icon-180x180.png') }}">

        @yield('css_before')

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">
        <link rel="stylesheet" href="{{ asset('js/plugins/sweetalert2/sweetalert2.min.css') }}">
        <link rel="stylesheet" id="css-main" href="{{ mix('css/dashmix.css') }}">

        @yield('css_after')

        <script>
            window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
        </script>
        <script src="{{ asset('js/plugins/jquery320/jquery3.2.0.js') }}" ></script>
    </head>

    <body>
        <div id="page-container">
            <main id="main-container">
                @yield('content')
            </main>
        </div>
        <script src="{{ asset('js/plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
        <script src="{{ mix('/js/dashmix.app.js') }}"></script>

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
        </script>
    </body>
</html>
