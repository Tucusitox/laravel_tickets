@php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    $RolUser = User::select('rol_name')
        ->join('rols', 'rols.id_rol', '=', 'users.fk_rol')
        ->where('user_id', Auth::id())
        ->first();
@endphp
<!-- SIDEBAR -->
<aside id="sidebar" class="js-sidebar">

    <div class="h-100">
        <div class="sidebar-logo">
            <div class="d-flex align-items-center">
                <img src="{{asset('img/logo-m.png')}}" class="img-fluid me-2" style="width: 50px; height: 50px;">
                <a href="{{route('dashboard')}}">SGPI</a>
            </div>
            <!-- BTN CLOSE SIDEBAR RESPONSIVE -->
            <button class="btn sidebar-btn d-none" id="btn-sibedar-responsive">
                <span>
                    <i class='bx bx-x fs-3 mt-1'></i>
                </span>
            </button>
        </div>
        <ul class="sidebar-nav">

            <div class="line-sidebar"></div>

            <li class="sidebar-header">
                Opciones de {{ $RolUser->rol_name }}
            </li>

            <li class="sidebar-item">
                <a href="{{asset('profile')}}" class="sidebar-link">
                    <i class='bx bxs-user-detail'></i>
                    Mi perfil
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link collapsed" data-bs-target="#tickets" data-bs-toggle="collapse"
                    aria-expanded="false">
                    <i class='bx bxs-crop'></i>
                    Tickets
                </a>
                <ul id="tickets" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                    <li class="sidebar-item">
                        <a href="{{route('dashboard')}}" class="sidebar-link">
                            <i class='bx bx-circle'></i>
                            Asignados a mi
                        </a>
                    </li>
                    <li class="sidebar-item">
                        <a href="{{route('groupTickets')}}" class="sidebar-link">
                            <i class='bx bx-circle'></i>
                            Asignados a mi grupo
                        </a>
                    </li>
                </ul>
            </li>

            <div class="line-sidebar"></div>

            @if ($RolUser->rol_name === 'Administrador')
                <li class="sidebar-header">
                    Opciones avanzadas
                </li>

                <li class="sidebar-item">
                    <a class="sidebar-link collapsed" data-bs-target="#gestionUsers" data-bs-toggle="collapse"
                        aria-expanded="false">
                        <i class='bx bx-folder-open'></i>
                        Gestionar
                    </a>
                    <ul id="gestionUsers" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="{{route('managment.users')}}" class="sidebar-link">
                                <i class='bx bx-circle'></i>
                                Usuarios
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="{{ route('managment.sesions') }}" class="sidebar-link">
                                <i class='bx bx-circle'></i>
                                Sesiones de usuarios
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class='bx bx-user-plus'></i>
                        Nuevo usuario
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class='bx bx-save'></i>
                        Respaldo
                    </a>
                </li>
            @endif

            <div class="line-sidebar"></div>

            <li class="sidebar-item p-3 text-end">
                <form action="{{ route('logout.index') }}" method="POST">
                    @csrf
                    <button type="submit" class="nav-link">
                        <i class='bx bx-log-out-circle'></i>
                        Cerrar sesión
                    </button>
                </form>
            </li>

        </ul>

    </div>
</aside>
