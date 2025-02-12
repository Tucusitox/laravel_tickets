@extends('layouts/layoutDashboard')
@section('Laravel', 'Dar solución a un ticket')

@php
    use App\Models\Request;
    $Ticket = Request::find($id_request);
@endphp

@section('contenido')

    <section class="container p-3 mt-3">

        <div class="container-fluid">
            {{-- FORMULARIO PARA GUARDAR SEGUIMIENTO --}}
            <form class="form-signin" action="{{ route('ticektSolution.save', $Ticket->id_request) }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header border-2 border-bottom border-primary py-3">
                        <div class="row align-items-center">

                            <div class="col-lg-6 my-2">
                                <h4 class="card-title">
                                    Dar solución al ticket:
                                    <b class="text-primary">{{ $Ticket->request_code }}</b>
                                </h4>
                            </div>

                            <div class="col-lg-6 my-2 card-details text-end" id="buttonSaveFollow">

                                <button type="submit" class="btn me-2" style="width: 30%">
                                    <i class='bx bx-check'></i>
                                    Solucionar
                                </button>

                            </div>

                        </div>

                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">

                        <div class="p-3">

                            <div class="form-floating mb-3 bg-body-tertiary">
                                <input type="text" class="form-control" id="floatingInput" placeholder="nameSolution" name="SolutionTittle" />
                                <label for="floatingInput">Título de la solución</label>
                            </div>

                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" name="SolutionDescription"
                                id="floatingTextarea2" style="height: 300px"></textarea>
                                <label for="floatingTextarea2" class="fs-5">Describa la solución del ticket</label>
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
