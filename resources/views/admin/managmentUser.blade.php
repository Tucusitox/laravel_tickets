@extends('layouts/layoutDashboard')
@section('Laravel', 'Gestión usuarios')

@php
    use App\Models\User;
    if (!$UserFind) {
        $AllUsers = User::join('rols', 'users.fk_rol', '=', 'rols.id_rol')->get();
    }
    else {
        $AllUsers = User::join('rols', 'users.fk_rol', '=', 'rols.id_rol')
        ->where('user_id', $UserFind)
        ->get();
    }
@endphp

@section('contenido')

    <section class="container p-3 mt-5">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-3">
                    <div class="card-tools row justify-content-between align-items-center">

                        <div class="col-lg-6 my-2">
                            <h4 class="card-title">Gestión de usuarios del sistema</h4>
                        </div>

                        <div class="d-flex justify-content-end col-lg-6 my-2">

                            <a href="{{ route('managment.users') }}" title="Todos los usuarios"
                                class="btn btn-outline-primary me-2">
                                <i class='bx bx-refresh mt-1'></i>
                            </a>
                            <div class="input-group input-group-sm" style="width: 220px;">
                                <form class="input-group" action="{{ route('user.show') }}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control border border-primary" name="UserCode"
                                        placeholder="Buscar por código" id="inputTicketCodigo">
                                    <button class="btn btn-primary" type="submit">
                                        <i class='bx bx-search'></i>
                                    </button>
                                </form>
                            </div>

                        </div>

                    </div>
                    {{-- ALERTA PARA MENSAJE --}}
                    @if (session('success'))
                        <x-AlertaMensaje mensaje="{{ session('success') }}" />
                    @endif

                </div>
                <!-- /.card-header -->
                <div class="card-body table-responsive p-0" style="height: 350px;">
                    <table class="table table-head-fixed text-nowrap">
                        <thead style="backdrop-filter: blur(5px);">
                            <tr>
                                <th>Código</th>
                                <th>Rol</th>
                                <th>Identificación</th>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Estatus</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($AllUsers as $item)
                                <tr>
                                    <td>{{ $item->user_code }}</td>
                                    <td>{{ $item->rol_name }}</td>
                                    <td>{{ $item->user_identification }}</td>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->user_status }}</td>
                                    <td>
                                        <a class="btn btn-info me-2" title="Cambiar rol"
                                            data-bs-toggle="modal" data-bs-target="#FormChangeRol-{{ $item->user_id }}">
                                            <i class='bx bx-refresh'></i>
                                        </a>
                                        @if ($item->user_status === 'bloqueado')
                                        <a href="{{ route('user.DesBlock', ['user_id' => $item->user_id, 'bolean' => true]) }}"
                                                class="btn btn-outline-success me-2" title="Desbloquear">
                                                <i class='bx bx-check-circle'></i>
                                            </a>
                                        @else
                                            <a class="btn btn-warning me-2" title="Bloquear"
                                                data-bs-toggle="modal" data-bs-target="#FormBlockUser-{{ $item->user_id }}">
                                                <i class='bx bx-block'></i>
                                            </a>
                                        @endif
                                        <a href="#" class="btn btn-danger me-2" title="Eliminar"
                                        data-bs-toggle="modal" data-bs-target="#FormDeleteUser-{{ $item->user_id }}">
                                            <i class='bx bx-trash' ></i>
                                        </a>
                                    </td>
                                </tr>

                                {{-- FORMUALRIO PARA CAMBIAR EL ROL --}}
                                <x-ModalChangeRol userId="{{ $item->user_id }}" />
                                {{-- FORMUALRIO PARA BLOQUEAR USUARIO --}}
                                <x-ModalBlockUser userId="{{ $item->user_id }}" />
                                {{-- FORMUALRIO PARA ELIMINAR USUARIO (SOFTDELETE) --}}
                                <x-ModalDeleteUser userId="{{ $item->user_id }}" />
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.card-body -->
        </div>

    </section>

    {{-- DAR FORMATO AL CODIGO DEL TICKET --}}
    <script src="{{ asset('js/formatoCodigoTicket.js') }}"></script>
@endsection
