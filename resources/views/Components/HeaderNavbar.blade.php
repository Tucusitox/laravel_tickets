@php
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;
    $DataUser = User::find(Auth::id());
@endphp
<!-- NAVBAR -->
<header>
    <nav class="navbar navbar-expand px-3">
        <!-- BUTTONS COLLAPSED SIDEBAR -->
        <div id="cajaBtnSidebar" class="sidebar-btn-navbar marginDefault">
            <button class="btn" id="sidebar-toggle-1" type="button">
                <span class="fs-4">&#9776</span>
            </button>

            <button class="btn d-none" id="sidebar-toggle-2" type="button">
                <span class="fs-4">&#9776</span>
            </button>
        </div>

        <div class="navbar-collapse navbar nav-btns">

            <ul class="navbar-nav align-items-center">
                <!-- BUTTONS DARK MODE -->
                <x-ButtonDarkMode />

                {{-- BOTON DE NOTIFICACIONES --}}
                <x-Notifications />

                <li class="nav-item dropdown mx-2">

                    <a class="avatar dropdown-toggle" data-bs-toggle="dropdown">
                        <span>{{ $DataUser->user_name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <a href="{{route('profile')}}" class="dropdown-item">
                            <i class='bx bxs-user-detail'></i>
                            Mi Perfil
                        </a>
                        <form action="{{ route('logout.index') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class='bx bx-log-out-circle'></i>
                                Cerrar sesión
                            </button>
                        </form>
                    </div>
                </li>

            </ul>
        </div>
    </nav>
</header>
