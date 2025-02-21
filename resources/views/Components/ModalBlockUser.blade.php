@php
    use App\Models\User;
    $FindUser = User::select('user_id','user_code','user_name')
    ->where('user_id', $userId)
    ->first();
@endphp

{{-- FORMULARIO PARA BLOQUEAR A UN USUARIO --}}

<div class="modal fade" id="FormBlockUser-{{ $FindUser->user_id }}">
    <div class="modal-dialog modal-dialog-centered p-2">
        <div class="modal-content border border-2 border-primary rounded form-signin">
            <form action="{{ route('user.block', $FindUser->user_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5">
                        ¿ Bloquear al usuario: 
                        <b class="text-danger">{{ $FindUser->user_name }}</b> ?
                    </h1>
                </div>
                <div class="modal-body border-2 border-top border-bottom border-success">
                    <p class="fs-5 text-start">
                        Esta apunto de blockear del sistema al usuario con el código:
                        <b class="text-danger">{{ $FindUser->user_code }}</b>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn">Bloquear</button>
                </div>
            </form>
        </div>
    </div>
</div>