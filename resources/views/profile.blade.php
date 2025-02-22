@extends('layouts/layoutDashboard')
@section('Laravel', 'Dashboard')

@php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    $UserData = User::join('rols', 'rols.id_rol', '=', 'users.fk_rol')
        ->join('rols_x_permissions', 'rols.id_rol', '=', 'rols_x_permissions.fk_rol')
        ->join('permissions', 'permissions.id_permission', '=', 'rols_x_permissions.fk_permission')
        ->where('user_id', Auth::id())
        ->get();
@endphp

@section('contenido')
    <section class="container-fluid px-4 py-5">

        {{-- ALERTA PARA MENSAJES DE EXITO --}}
        @if (session('success'))
            <x-AlertaMensaje mensaje="{{ session('success') }}" />
        @endif

        <div class="row mt-4">
            <!-- CARD CON INFORMACION DEL USUARIO -->
            <div class="col-lg-4 mb-5">
                <div class="card bg-body-tertiary h-100">
                    <div class="card-body rounded text-center">
                        <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                            class="rounded-circle border border-2 border-primary img-fluid mb-2" style="width: 150px;">
                        <p class="my-1">{{ $UserData->first()->user_code }}</p>
                        <p class="my-1">{{ $UserData->first()->user_identification }}</p>
                        <p class="my-1">{{ $UserData->first()->user_name . ' ' . $UserData->first()->user_lastName }}</p>
                        <p class="mb-4">{{ $UserData->first()->email }}</p>
                        <div class="dropdown-center mb-2">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Permisos del usuario
                            </button>
                            <ul class="dropdown-menu bg-body-tertiary">
                                @foreach ($UserData as $item)
                                    <li class="dropdown-item">{{ $item->permission_name }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FORMULARIO PARA ACTUALIZAR CONTRASEÑA -->
            <div class="col-lg-8 mb-5">
                <div class="card bg-body-tertiary p-4 h-100">

                    <form action="{{ route('profile.password') }}" method="POST" class="form-signin">
                        @csrf
                        <div class="text-center mt-4 mb-5">
                            <h3 class="text-success">
                                <b>Actualizar</b>
                                <b class="text-primary">contraseña</b>
                            </h3>
                        </div>

                        <div class="form-floating mb-3 bg-body-tertiary">
                            <input type="password" class="form-control" id="clave-login" placeholder="Password" name="newPassword"/>
                            <label for="clave-login">Nueva contraseña</label>
                            <i onclick="ocultarContraseña('clave-login', 'loginClave-Icono')" id="loginClave-Icono"
                                class="bx bx-low-vision fs-4"></i>
                        </div>

                        <div class="form-floating mb-3 bg-body-tertiary">
                            <input type="password" class="form-control" id="clave-login-confirm" placeholder="Password" name="confirmPassword"/>
                            <label for="clave-login">Confirmar contraseña</label>
                            <i onclick="ocultarContraseña('clave-login-confirm', 'loginClave-Icono-confirm')"
                                id="loginClave-Icono-confirm" class="bx bx-low-vision fs-4"></i>
                        </div>

                        <button class="btn mb-3" type="submit">
                            <b>Guardar</b>
                        </button>
                    </form>

                </div>
            </div>

        </div>

        <!-- FORMULARIO PARA ACTUALIZAR DATOS -->
        <div class="card bg-body-tertiary p-4">

            <form action="{{ route('profile.update') }}" method="POST" class="form-signin">
                @csrf

                <div class="text-center">
                    <h3 class="text-success my-3">
                        <b>Actualizar</b>
                        <b class="text-primary">información</b>
                    </h3>
                </div>

                <div class="form-floating mb-3 bg-body-tertiary">
                    <input type="number" class="form-control" id="floatingInput1" placeholder="12345678"
                        name="UserIdentification" value="{{ $UserData->first()->user_identification }}" />
                    <label for="floatingInput1">Identificación</label>
                    <i class='bx bx-id-card fs-4'></i>
                </div>

                <div class="bg-body-tertiary mb-3">
                    <select class="form-select py-3" name="UserGender">
                        <option>Selecciona un género</option>
                        <option value="Masculino" @selected($UserData->first()->user_gender == 'Masculino')>Masculino</option>
                        <option value="Femenino" @selected($UserData->first()->user_gender == 'Femenino')>Femenino</option>
                    </select>
                </div>

                <div class="form-floating mb-3 bg-body-tertiary">
                    <input type="text" class="form-control" id="floatingInput2" placeholder="name" name="UserName"
                        value="{{ $UserData->first()->user_name }}" />
                    <label for="floatingInput2">Nombre</label>
                    <i class='bx bx-rename fs-4'></i>
                </div>

                <div class="form-floating mb-3 bg-body-tertiary">
                    <input type="text" class="form-control" id="floatingInput3" placeholder="lastname" name="UserLastName"
                        value="{{ $UserData->first()->user_lastName }}" />
                    <label for="floatingInput3">Apellido</label>
                    <i class='bx bx-rename fs-4'></i>
                </div>

                <div class="form-floating mb-3 bg-body-tertiary">
                    <input type="date" class="form-control" name="UserDateOfBirth"
                        value="{{ $UserData->first()->user_dateOfBirth->format('Y-m-d') }}" />
                    <label for="floatingInput4">Fecha de nacimiento</label>
                </div>

                <button class="btn mb-3" type="submit">
                    <b>Guardar</b>
                </button>
            </form>
        </div>

    </section>

@endsection
