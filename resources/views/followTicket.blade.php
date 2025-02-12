@extends('layouts/layoutDashboard')
@section('Laravel', 'Dar seguimiento a un ticket')

@php
    use App\Models\UsersProjectsRequest;
    $Ticket = UsersProjectsRequest::join('requests','requests.id_request','=','users_projects_request.fk_request',)
    ->where('users_projects_request.fk_request', $id_request)
    ->first();
@endphp

@section('contenido')

    <section class="container p-3 mt-3">

        <div class="container-fluid">
            {{-- FORMULARIO PARA GUARDAR SEGUIMIENTO --}}
            <form class="form-signin" action="{{ 
                route('ticketFollow.save',
                    ['id_userProjectRequest' => $Ticket->id_userProjectRequest,
                    'id_request' => $Ticket->id_request]
                ) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header border-2 border-bottom border-primary py-3">
                        <div class="row align-items-center">

                            <div class="col-lg-6 my-2">
                                <h4 class="card-title">
                                    Dar seguimiento al ticket:
                                    <b class="text-primary">{{ $Ticket->request_code }}</b>
                                </h4>
                            </div>

                            <div class="col-lg-6 my-2 card-details text-end" id="buttonSaveFollow">

                                <button type="submit" class="btn w-50 me-2">
                                    <i class='bx bx-save'></i>
                                    Guardar seguimiento
                                </button>

                            </div>

                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="p-3">

                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="FollowDescription"
                                id="floatingTextarea2" style="height: 300px"></textarea>
                                <label for="floatingTextarea2" class="fs-5">Indique el seguimiento del ticket</label>
                            </div>

                        </div>

                    </div>
                <!-- /.card-body -->
                </div>
            {{-- FIN FORMULARIO --}}
            </form>

        </div>

    </section>

    <script>
        const element = document.getElementById('buttonSaveFollow');
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
