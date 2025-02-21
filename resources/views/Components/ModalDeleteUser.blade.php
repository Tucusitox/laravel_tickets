@php
    use App\Models\User;
    $FindUser = User::select('user_id','user_code', 'user_name')
    ->where('user_id', $userId)
    ->first();
@endphp

{{-- FORMULARIO PARA CAMBIAR EL ROL DE UN USUARIO --}}

<div class="modal fade" id="FormDeleteUser-{{ $FindUser->user_id }}">
    <div class="modal-dialog modal-dialog-centered p-2">
        <div class="modal-content border border-2 border-primary rounded form-signin">
            <form action="{{ route('user.delete', $FindUser->user_id) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5">
                        ¿ Eliminar al usuario: 
                        <b class="text-danger">{{ $FindUser->user_name }}</b> ?
                    </h1>
                </div>
                <div class="modal-body border-2 border-top border-bottom border-success">
                    <div class="form-floating mb-3 bg-body-tertiary">
                        
                        <input type="password" class="form-control" id="clave-admin{{$FindUser->user_id}}" 
                        placeholder="Password" name="AdminPassword" aria-autocomplete="list">

                        <label for="clave-admin{{$FindUser->user_id}}">Indique su contraseña de administrador</label>

                        <i onclick="ocultarContraseña('clave-admin{{$FindUser->user_id}}', 'claveAdmin-Icono{{$FindUser->user_id}}')" 
                            id="claveAdmin-Icono{{$FindUser->user_id}}" class="bx bx-low-vision fs-4">
                        </i>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn">Eliminar</button>
                </div>
            </form>
        </div>
    </div>
</div>