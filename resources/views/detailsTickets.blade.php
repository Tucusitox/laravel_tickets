@extends('layouts/layoutDashboard')
@section('Laravel', 'Detalles del ticket')

@php
    use Carbon\Carbon;
    use App\Models\UsersProjectsRequest;
    use App\Models\FollowsRequest;
    use App\Models\RequestSolution;

    $TicketData = UsersProjectsRequest::join('requests','requests.id_request','=','users_projects_request.fk_request')
        ->leftJoin('status_requests', 'status_requests.id_statusRequest', '=', 'requests.fk_statusRequest')
        ->leftJoin('requests_x_attachments', 'requests_x_attachments.fk_request', '=', 'requests.id_request')
        ->leftJoin('attachments', 'attachments.id_attachment', '=', 'requests_x_attachments.fk_attachment')
        ->where('users_projects_request.fk_request', $id_request)
        ->get();

    $FollowTickets = FollowsRequest::select('follow_description', 'date_register', 'follow_userRegister')
        ->where('fk_UserProjectRequest', $TicketData->first()->id_userProjectRequest)
        ->get();

    $TicketSolutionData = RequestSolution::where('fk_request', $id_request)->first();
@endphp

@section('contenido')

    <section class="container p-3 mt-3">

        <div class="container-fluid">

            <div class="card">
                <div class="card-header border-2 border-bottom border-primary py-3">
                    <div class="row justify-content-between align-items-center">

                        <div class="col-md-8">
                            <h3 class="card-title">
                                Detalles del ticket:
                                <b class="text-primary">{{ $TicketData->first()->request_code }}</b>
                            </h3>
                        </div>

                        @if (!$TicketData->first()->request_date_finish)
                            <div class="col-lg-4 text-end" id="buttonsDetails">
                                <a href="{{ route('ticket.follow', $TicketData->first()->id_request) }}" 
                                    class="btn btn-info me-2" title="Dar seguimiento">
                                    <i class='bx bxs-edit'></i>
                                </a>
                                <a href="{{ route('ticket.solution', $TicketData->first()->id_request) }}" 
                                    class="btn btn-success" title="Dar solución">
                                    <i class='bx bx-check-circle'></i>
                                </a>
                            </div>                                           
                        @endif

                    </div>
                    {{-- ALERTA PARA MENSAJE AL BUSCAR NUEVOS CORRES --}}
                    @if (session('success'))
                        <x-AlertaMensaje mensaje="{{ session('success') }}" />
                    @endif
                </div>
                <!-- /.card-header -->
                <div class="card-body">

                    <div class="card-body">

                        <div class="row justifi-content-center">
                            <h3>{{ $TicketData->first()->request_tittle }}</h3>

                            {{-- INICIO DE INFORMACION BASICA --}}
                            <div class="col-md-4 mt-2">

                                <h5 class="text-primary">Cliente solicitante:</h5>
                                <p>{{ $TicketData->first()->request_applicantName }}</p>

                                <h5 class="text-primary">Correo del solicitante:</h5>
                                <p>{{ $TicketData->first()->request_applicantEmail }}</p>

                                <h5 class="text-primary">Estatus del ticket:</h5>
                                <p>{{ $TicketData->first()->status_name }}</p>

                            </div>

                            <div class="col-md-4 mt-2">
                                <h5 class="text-primary">Descripción del ticket:</h5>
                                <p>{{ $TicketData->first()->request_description }}</p>
                            </div>

                            <div class="col-md-4 mt-2">
                                <h5 class="text-primary">Fecha de creación:</h5>
                                <p>{{ Carbon::parse($TicketData->first()->request_date_start)->format('d/m/Y') }}</p>

                                <h5 class="text-primary">Fecha de solución:</h5>
                                @if ($TicketData->first()->request_date_finish)
                                    <p>{{ Carbon::parse($TicketData->first()->request_date_finish)->format('d/m/Y') }}</p>
                                @else
                                    <p>¡Por definir!</p>
                                @endif

                                <h5 class="text-primary">Tiempo de solución:</h5>
                                @if ($TicketSolutionData != null)
                                    <p>{{ Carbon::parse($TicketSolutionData->solution_time)->format('i:s') }} minutos</p>
                                @else
                                    <p>¡Por definir!</p>
                                @endif

                            </div>
                            {{-- FIN INFORMACION BASICA --}}
                            <div class="line-sidebar my-4"></div>

                            {{-- INICIO ARCHIVOS DEL TICKET --}}
                            <h3>Archivos del ticket</h3>
                            <div class="col-md-6 d-flex w-100">
                                @foreach ($TicketData as $item)
                                    @if ($item->attachment_route !== null)
                                        <div class="card m-2 shadow-sm" style="width: 200px; text-align: center;">
                                            <div class="card-body card-details p-2">
                                                <i class='bx bx-file' style="font-size: 50px;"></i>
                                                <p class="small text-truncate"
                                                    title="{{ basename($item->attachment_route) }}">
                                                    {{ basename($item->attachment_route) }}
                                                </p>
                                                <a href="{{ asset($item->attachment_route) }}" target="_blank"
                                                    class="btn">
                                                    <i class='bx bx-download'></i> Descargar
                                                </a>
                                            </div>
                                        </div>
                                    @else
                                        <h4 class="w-100 text-danger">¡Este ticket no tiene archivos adjuntos!</h4>
                                    @endif
                                @endforeach
                            </div>
                            {{-- FIN ARCHIVOS DEL TICKET --}}
                            <div class="line-sidebar my-4"></div>

                            {{-- INICIO DE SEGUIMIENTOS --}}
                            <h3 class="mb-3">Seguimientos del ticket</h3>

                            @if ($FollowTickets->isEmpty())
                                <h4 class="w-100 text-danger">¡Este ticket no tiene seguimientos!</h4>
                            @endif

                            <div id="CajaFollow">
                                @foreach ($FollowTickets as $key => $item)
                                    <div class="card w-100 p-2">
                                        <li class="sidebar-item">
                                            <a class="sidebar-link collapsed fs-5"
                                                data-bs-target="#VitacoraTickets{{ $key }}"
                                                data-bs-toggle="collapse" aria-expanded="false">
                                                <i class='bx bx-calendar'></i>
                                                {{ Carbon::parse($item->date_register)->format('d/m/Y') }}
                                                {{ $item->follow_userRegister }}
                                            </a>
                                            <ul id="VitacoraTickets{{ $key }}"
                                                class="sidebar-dropdown list-unstyled collapse"
                                                data-bs-parent="#CajaFollow">
                                                <li class="sidebar-item p-3">
                                                    <p>{{ $item->follow_description }}</p>
                                                </li>
                                            </ul>
                                        </li>
                                    </div>
                                @endforeach
                            </div>

                            {{-- FIN DE SEGUIMIENTOS --}}
                            <div class="line-sidebar my-4"></div>

                            {{-- INICIO DE SOLUCION --}}
                            <h3 class="mb-3">Información de la solución del ticket</h3>

                            @if ($TicketSolutionData == null)
                                <h4 class="w-100 text-danger">¡Este ticket no ha sido solucionado!</h4>
                            @else
                                <div class="px-3">
                                    <h5 class="text-primary">Título:</h5>
                                    <p>{{ $TicketSolutionData->solution_tittle }}</p>                     

                                    <h5 class="text-primary">Descripción:</h5>
                                    <p>{{ $TicketSolutionData->solution_description }}</p>                     

                                    <h5 class="text-primary">Solucionado por:</h5>
                                    <p>{{ $TicketSolutionData->solution_userName }}</p>                     
                                </div>
                            @endif
                            {{-- FIN DE SOLUCION --}}
                        </div>

                    </div>

                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </section>

    <script>
        const element = document.getElementById('buttonsDetails');

        function checkWindowSize() {
            if (window.innerWidth < 768) {
                element.classList.remove('text-end');
            } else {
                element.classList.add('text-end');
            }
        }
        window.addEventListener('resize', checkWindowSize);
        checkWindowSize();
    </script>

@endsection
