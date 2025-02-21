@extends('layouts/layoutIndex')
@section('Laravel', 'Iniciar sesión')

@section('contenido')

    <form action="{{ route('user.auth') }}" method="POST">
        @csrf

        <div class="text-center">
            {{-- <img class="img-fluid" src="{{asset('img/logo-m.png')}}"/> --}}
            <h1 class="text-success mb-4"><b>Iniciar</b> <b class="text-primary">sesión</b></h1>
        </div>

        {{-- ALERTA PARA MENSAJES DE EXITO --}}
        @if (session('success'))
            <x-AlertaMensaje mensaje="{{ session('success') }}" />
        @endif

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com" name="email" />
            <label for="floatingInput">Correo electrónico</label>
            <i class="bx bx-envelope fs-4"></i>
        </div>

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="password" class="form-control" id="clave-login" placeholder="Password" name="password" />
            <label for="clave-login">Contraseña</label>
            <i onclick="ocultarContraseña('clave-login', 'loginClave-Icono')" id="loginClave-Icono"
                class="bx bx-low-vision fs-4"></i>
        </div>

        <button class="btn mb-3" type="submit">
            <b>Iniciar</b>
        </button>

        <div class="nav-container" data-bs-toggle="modal" data-bs-target="#FormRecoverPassword">
            <a class="nav-link"><b>¿Olvidaste tú contraseña?</b></a>
        </div>

    </form>
    
    {{-- MODAL PARA RECUPERAR LA CONTRASEÑA --}}
    <x-ModalRecoverPassword />


@endsection
