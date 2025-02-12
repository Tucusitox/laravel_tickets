@extends('layouts/layoutIndex')
@section('Laravel', 'Recuperar contraseña')

@section('contenido')

    <form action="{{ route('new.password', $id_user) }}" method="POST" id="formLogin">
        @csrf
        <div class="container text-center">
            <img class="mb-4 rounded" src="{{ asset('img/logo-megaSoftt.png') }}" alt="" width="100"
                height="100">
            <h5 class=" text-center mb-3">
                ¡Ingrese el código de recuperación enviado a su correo electrónico!
            </h5>
        </div>

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="text" class="form-control " name="codeConfirm" id="inputCodigo"
                placeholder="name@example.com">
            <label for="floatingInput">Código de recuperación</label>
        </div>

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="password" class="form-control" id="clave-new" placeholder="Password" name="newPassword"/>
            <label for="floatingPassword">Nueva contraseña</label>
            <i onclick="ocultarContraseña('clave-new', 'new-Icono')" id="new-Icono"
                class="bx bx-low-vision fs-4"></i>
        </div>

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="password" class="form-control " id="confirm-password" name="confirmPassword"
                placeholder="Password">
            <label for="floatingPassword">Confirmar contraseña</label>
            <i onclick="ocultarContraseña('confirm-password', 'confirm-Icono')" id="confirm-Icono"
            class="bx bx-low-vision fs-4"></i>
        </div>

        <button class="btn w-100 py-2" type="submit">Cambiar contraseña</button>

    </form>

    {{-- DAR FORMATO AL CODIGO DE CONFIRMACION --}}
    <script src="{{asset('js/formatoCodigoPassword.js')}}"></script>

@endsection
