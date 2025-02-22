@extends('layouts/layoutDashboard')
@section('Laravel', 'Crear usuario')

@php
    use App\Models\Rol;
    use App\Models\Group;

    $AllRols = Rol::all();
    $AllGroups = Group::all();
@endphp

@section('contenido')
    <section class="container-fluid p-4">

        {{-- ALERTA PARA MENSAJES DE EXITO --}}
        @if (session('success'))
            <x-AlertaMensaje mensaje="{{ session('success') }}" />
        @endif

        <!-- FORMULARIO PARA ACTUALIZAR DATOS -->
        <div class="card bg-body-tertiary p-4">

            <form action="{{ route('user.store') }}" method="POST" class="form-signin">
                @csrf
                <div class="text-center">
                    <h3 class="text-success my-3">
                        <b>Registrar</b>
                        <b class="text-primary">nuevo usuario</b>
                    </h3>
                </div>
                {{-- INICIO INPUTS DEL FORMULARIO --}}
                <div class="d-flex w-100">
                    {{-- PARTE 1 --}}
                    <div class="w-50 me-2">
    
                        <div class="form-floating mb-3 bg-body-tertiary">
                            <input type="number" class="form-control" id="floatingInput1" placeholder="12345678"
                                name="UserIdentification" />
                            <label for="floatingInput1">Identificación</label>
                            <i class='bx bx-id-card fs-4'></i>
                        </div>
        
                        <div class="bg-body-tertiary mb-3">
                            <select class="form-select py-3" name="UserGender">
                                <option>Selecciona un género</option>
                                <option value="Masculino">Masculino</option>
                                <option value="Femenino">Femenino</option>
                            </select>
                        </div>
        
                        <div class="form-floating mb-3 bg-body-tertiary">
                            <input type="text" class="form-control" id="floatingInput2" placeholder="name" name="UserName" />
                            <label for="floatingInput2">Nombre</label>
                            <i class='bx bx-rename fs-4'></i>
                        </div>
        
                        <div class="form-floating mb-3 bg-body-tertiary">
                            <input type="text" class="form-control" id="floatingInput3" placeholder="lastname" name="UserLastName"/>
                            <label for="floatingInput3">Apellido</label>
                            <i class='bx bx-rename fs-4'></i>
                        </div>
        
                    </div>
                    {{-- PARTE 2 --}}
                    <div class="w-50">
        
                        <div class="form-floating mb-3 bg-body-tertiary">
                            <input type="email" class="form-control" id="floatingInput4" placeholder="example@gmail.com"
                                name="UserEmail" />
                            <label for="floatingInput4">Correo electrónico</label>
                            <i class='bx bx-id-card fs-4'></i>
                        </div>
        
                        <div class="bg-body-tertiary mb-3">
                            <select class="form-select py-3" name="UserRol">
                                <option value="">Selecciona un rol</option>
                                @foreach ($AllRols as $item)
                                    <option value="{{$item->id_rol}}">{{$item->rol_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-body-tertiary mb-3">
                            <select class="form-select py-3" name="UserGroup">
                                <option value="">Selecciona un grupo</option>
                                @foreach ($AllGroups as $item)
                                    <option value="{{$item->id_group}}">{{$item->group_name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-floating mb-3 bg-body-tertiary">
                            <input type="date" class="form-control" name="UserDateOfBirth"/>
                            <label for="floatingInput5">Fecha de nacimiento</label>
                        </div>

                    </div>
                </div>
                {{-- FIN INPUTS DEL FORMULARIO --}}
                <button class="btn mb-3" type="submit">
                    <b class="fs-5">Registrar</b>
                </button>
            </form>
        </div>

    </section>

@endsection
