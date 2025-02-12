<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo-megaSoftt.png') }}">

    <!-- BOOSTRAP CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- BOXICON CDN -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <!-- FORM STYLES -->
    <link href="{{ asset('css/sing-in.css') }}" rel="stylesheet" />
    <!-- SWEETAlert2 ERRORS STYLES -->
    <link href="{{ asset('css/sweet-alert2.css') }}" rel="stylesheet" />
    <!-- SWEETALERT2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <title>@yield('Laravel')</title>
</head>

<body>

    <main class="d-flex align-items-center justify-content-center min-vh-100">

        <!-- BUTTONS DARK MODE INDEX-LOGIN -->
        <div class="d-flex justify-content-end fixed-top p-2">
            <a class="btn change-theme" id="change-theme" title="Cambiar tema">
                <i class="bx bxs-moon text-dark fs-4"></i>
                <i class="bx bxs-sun text-white fs-4"></i>
            </a>
        </div>
    
        <div class="form-signin shadow-lg bg-body-tertiary">
            @yield('contenido')
        </div>
        
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

    <!-- OCULTAR CONTRASEÑA -->
    <script src="{{ asset('js/ocultarContraseña.js') }}"></script>
    <!-- MODO OSCURO -->
    <script src="{{ asset('js/darkMode.js') }}"></script>
    <!-- BOOOSTRAP SCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

</body>

</html>
