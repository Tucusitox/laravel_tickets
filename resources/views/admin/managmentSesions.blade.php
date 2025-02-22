@extends('layouts/layoutDashboard')
@section('Laravel', 'Gestión de sesiones')

@php
    use Carbon\Carbon;
    use App\Models\SessionsUser;
    if (!$bolean) {
        $AllSessions = SessionsUser::join('users', 'sessions_users.fk_user', '=', 'users.user_id')
                        ->orderBy('session_date','desc')->get();
    }
    else {
        $AllSessions = $FindSession;
    }
@endphp

@section('contenido')

    <section class="container p-3 mt-5">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header py-3">
                    <div class="card-tools row justify-content-between align-items-center">

                        <div class="col-lg-6 my-2">
                            <h4 class="card-title">Gestión de sesiones del sistema</h4>
                        </div>

                        <div class="d-flex justify-content-end col-lg-6 my-2">

                            <a href="{{ route('managment.sesions') }}" title="Todas las sesiones"
                                class="btn btn-outline-primary me-2">
                                <i class='bx bx-refresh mt-1'></i>
                            </a>

                            <div class="input-group input-group-sm" >
                                <form class="input-group" action="{{ route('session.find') }}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control border border-primary" name="UserCode"
                                    placeholder="Usuario código" id="inputTicketCodigo">

                                    <input type="date" class="form-control border border-primary" name="SessionDate"
                                        placeholder="Buscar por código">
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
                                <th>Nombre</th>
                                <th>Fecha de conexión</th>
                                <th>Inicio de conexión</th>
                                <th>Fin de conexión</th>
                                <th>Tiempo de conexión</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($AllSessions as $item)
                            
                                <tr>
                                    <td>{{ $item->user_code }}</td>
                                    <td>{{ $item->user_name }}</td>
                                    <td>{{ Carbon::parse($item->session_date)->format('d/m/Y') }}</td>
                                    <td>{{ Carbon::parse($item->session_time_start)->format('H:i A') }}</td>
                                    @if ($item->session_time_closing)
                                        <td>{{ Carbon::parse($item->session_time_closing)->format('H:i A') }}</td>
                                        <td>{{ Carbon::parse($item->session_duration)->format('H:i:s') }}</td>
                                        <td>Ninguna</td>
                                    @else
                                        <td>Por definir</td>
                                        <td>Por definir</td>
                                        <td>
                                            <a href="{{ route('session.close', $item->user_id) }}"
                                                class="btn btn-danger me-2" title="Cerrar sesión">
                                                <i class='bx bx-block'></i>
                                            </a>
                                        </td>
                                    @endif
                                </tr>

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
