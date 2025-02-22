@extends('layouts/layoutIndex')
@section('Laravel', 'Verificar usuario')

@section('contenido')

    <form action="{{ route('user.verify', $user_id) }}" method="POST" id="formLogin">
        @csrf
        @method('PUT')
        <div class="container text-center">
            <h5 class=" text-center mb-3">
                ¡Por favor, cambie su contraseña para iniciar sesión!
            </h5>
        </div>

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="password" class="form-control" id="clave-before" placeholder="Password" name="BeforePassword"/>
            <label for="floatingPassword">Contraseña anterior</label>
            <i onclick="ocultarContraseña('clave-before', 'before-Icono')" id="before-Icono"
                class="bx bx-low-vision fs-4"></i>
        </div>

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="password" class="form-control" id="clave-new" placeholder="Password" name="NewPassword"/>
            <label for="floatingPassword">Nueva contraseña</label>
            <i onclick="ocultarContraseña('clave-new', 'new-Icono')" id="new-Icono"
                class="bx bx-low-vision fs-4"></i>
        </div>

        <div class="form-floating mb-3 bg-body-tertiary">
            <input type="password" class="form-control " id="confirm-password" name="ConfirmPassword"
                placeholder="Password">
            <label for="floatingPassword">Confirmar contraseña</label>
            <i onclick="ocultarContraseña('confirm-password', 'confirm-Icono')" id="confirm-Icono"
            class="bx bx-low-vision fs-4"></i>
        </div>

        <button class="btn w-100 py-2" type="submit">Cambiar contraseña</button>

    </form>

@endsection
