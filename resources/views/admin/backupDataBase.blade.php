@extends('layouts/layoutDashboard')
@section('Laravel', 'Generar respaldo')

@section('contenido')
    <section class="container-fluid p-5">

        {{-- ALERTA PARA MENSAJES DE EXITO --}}
        @if (session('success'))
            <x-AlertaMensaje mensaje="{{ session('success') }}" />
        @endif

        <!-- FORMULARIO PARA ACTUALIZAR DATOS -->
        <div class="card bg-body-tertiary p-4">

            <form action="{{ route('backup.store') }}" method="POST" class="form-signin">
                @csrf
                <div class="text-center">
                    <h3 class="text-success my-3">
                        <b>Generar</b>
                        <b class="text-primary">respaldo</b>
                    </h3>
                </div>

                <div class="form-floating mb-3 bg-body-tertiary">
                    <input type="password" class="form-control" id="clave-login" placeholder="Password" name="AdminPassword"/>
                    <label for="clave-login">Contraseña administrador</label>
                    <i onclick="ocultarContraseña('clave-login', 'loginClave-Icono')" id="loginClave-Icono"
                        class="bx bx-low-vision fs-4"></i>
                </div>

                <button class="btn mb-3" type="submit">
                    <b>Guardar</b>
                </button>
            </form>
        </div>

    </section>

@endsection
