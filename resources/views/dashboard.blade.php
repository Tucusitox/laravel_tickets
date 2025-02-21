@extends('layouts/layoutDashboard')
@section('Laravel', 'Mis tickets')

@php
    use Carbon\Carbon;
    use App\Models\UsersProjectsRequest;
    use Illuminate\Support\Facades\Auth;
    $Tickets = UsersProjectsRequest::join('requests', 'requests.id_request', '=', 'users_projects_request.fk_request')
        ->join('status_requests', 'status_requests.id_statusRequest', '=', 'requests.fk_statusRequest')
        ->where('fk_user', Auth::id())
        ->orderBy('id_request', 'desc')
        ->get();
@endphp

@section('contenido')

    <section class="container p-3 mt-5">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header py-3">
                    <div class="card-tools row justify-content-between align-items-center">

                        <div class="col-lg-6 my-2">
                            <h4 class="card-title"><b>Tickets asignados a mi -> {{ $Tickets->count() }}</b></h4>
                        </div>

                        <div class="d-flex justify-content-end col-lg-6 my-2">

                            <a href="{{ route('tickets.refresh') }}" title="Refrescar tickets"
                                class="btn btn-outline-primary me-2">
                                <i class='bx bx-refresh mt-1'></i>
                            </a>

                            <div class="input-group input-group-sm" style="width: 220px;">
                                <form class="input-group" action="{{ route('ticket.find') }}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control border border-primary" name="FindTicket"
                                        placeholder="Buscar por código" id="inputTicketCodigo">
                                    <button class="btn btn-primary" type="submit">
                                        <i class='bx bx-search'></i>
                                    </button>
                                </form>
                            </div>

                        </div>

                    </div>
                    {{-- ALERTA PARA MENSAJE AL BUSCAR NUEVOS CORRES --}}
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
                                <th>Título</th>
                                <th>Estatus</th>
                                <th>Fecha</th>
                                <th>Opciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($Tickets as $item)
                                <tr>
                                    <td>{{ $item->request_code }}</td>
                                    <td>{{ $item->request_tittle }}</td>
                                    <td>{{ $item->status_name }}</td>
                                    <td>{{ Carbon::parse($item->request_date_start)->format('d/m/Y') }}</td>
                                    <td>
                                        <a href="{{ route('details.tickets', $item->fk_request) }}"
                                            class="btn btn-warning me-2" title="Detalles">
                                            <i class='bx bx-detail'></i>
                                        </a>
                                        @if ($item->status_name !== "Solucionado")
                                            <a href="{{ route('ticket.follow', $item->fk_request) }}"
                                                class="btn btn-info me-2" title="Seguimiento">
                                                <i class='bx bx-edit'></i>
                                            </a>
                                            <a href="{{ route('ticket.solution', $item->fk_request) }}"
                                                class="btn btn-success" title="Solucionar">
                                                <i class='bx bx-check-circle'></i>
                                            </a>
                                        @endif
                                    </td>
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
