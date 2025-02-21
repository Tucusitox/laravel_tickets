<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo-m.png') }}">

    <!-- BOOSTRAP CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- BOXICON CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!-- DASHBOARD ADMIN STYLES -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-admin.css') }}">
    <!-- DASHBOARD ADMIN SIDEBAR STYLES -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-sidebar.css') }}">
    <!-- DASHBOARD ADMIN NAVBAR STYLES -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-navbar.css') }}">
    <!-- DASHBOARD ADMIN CARDS STYLES -->
    <link rel="stylesheet" href="{{ asset('css/dashboard-cards.css') }}">
    <!-- SWEETAlert2 ERRORS STYLES -->
    <link href="{{ asset('css/sweet-alert2.css') }}" rel="stylesheet" />
    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- AXIOS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <title>@yield('Laravel')</title>
</head>

<body>

    <x-Sidebar />

    <x-HeaderNavbar />

    <x-AlertaPorInactividad />

    <main class="main marginDefault" id="cajaMain">
        @yield('contenido')
    </main>

    {{-- INICIO DE ALERTAS PARA ERRORES DE VALIDACION --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: "error",
                html: "@foreach ($errors->all() as $error) <h5>{{ $error }}</h5> @endforeach",
                confirmButtonText: "¡Entendido!",
            });
        </script>
    @endif
    {{-- FIN DE ALERTAS PARA ERRORES DE VALIDACION --}}

    <!-- BOOOSTRAP SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    
    <!-- OCULTAR CONTRASEÑA -->
    <script src="{{ asset('js/ocultarContraseña.js') }}"></script>
    <!-- SIDEBAR ANIMATION -->
    <script src="{{ asset('js/sidebar-animation.js') }}"></script>
    <!-- MODO OSCURO -->
    <script src="{{ asset('js/darkMode.js') }}"></script>
    <!-- CERRAR SESION POR INACTIVIDAD -->
    {{-- <script src="{{ asset('js/cierrePorInactividad.js') }}"></script> --}}

</body>

</html>
