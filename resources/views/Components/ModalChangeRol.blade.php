@php
    use App\Models\User;
    use App\Models\Rol;

    $FindUser = User::select('user_id','user_name','id_rol')
    ->join('rols', 'users.fk_rol', '=', 'rols.id_rol')
    ->where('user_id', $userId)
    ->first();

    $AllRols = Rol::all();
@endphp

{{-- FORMULARIO PARA CAMBIAR EL ROL DE UN USUARIO --}}

<div class="modal fade" id="FormChangeRol-{{ $FindUser->user_id }}">
    <div class="modal-dialog modal-dialog-centered p-2">
        <div class="modal-content border border-2 border-primary rounded form-signin">
            <form action="{{ route('userChange.rol', $FindUser->user_id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header text-center">
                    <h1 class="modal-title fs-5">
                        Cambiar rol del usuario: 
                        <b class="text-danger">{{ $FindUser->user_name }}</b>
                    </h1>
                </div>
                <div class="modal-body border-2 border-top border-bottom border-success">
                    <select class="form-select py-3" name="UserNewRol">
                        @foreach ($AllRols as $item)
                            <option value="{{$item->id_rol}}" 
                                @selected($item->id_rol == $FindUser->id_rol)>
                                {{$item->rol_name}}
                            </option> 
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn">Cambiar rol</button>
                </div>
            </form>
        </div>
    </div>
</div>
