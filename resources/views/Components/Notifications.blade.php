@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\Notification;

    $datos = Notification::select('data')
    ->where('notifiable_id',Auth::id())
    ->where('read_at', NULL)
    ->orderBy('created_at','desc')
    ->get(['data']);
    $dataNotify = $datos->map(function ($dato) {
        return json_decode($dato->data, true);
    });

    $notifyCount = $datos->count();
@endphp

<li class="nav-item dropdown">
    <a data-bs-toggle="dropdown" class="btn">
        @if ($notifyCount > 0)
            <span>{{ $notifyCount }}</span>
        @endif
        <i class='bx bx-bell fs-4'></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end">

        @if ($dataNotify->isEmpty())
            <div class="dropdown-item d-flex">
                <i class='bx bx-x-circle text-danger fs-4 me-2'></i>
                <p>¡Sin notificaciones!</p>
            </div>
        @endif

        @foreach ($dataNotify as $notify)

            <div class="dropdown-item d-flex">
                <i class='bx bx-info-circle text-info fs-4 mt-3 me-3'></i>
                <a class="dropdown-item-title nav-link" href="{{ route('notify.code',['CodeRequest' => $notify['codigo'] ]) }}">
                    Se te ha asignado un nuevo ticket<br>
                    bajo el código:
                    <b>{{ $notify['codigo'] }}</b>
                </a>
            </div>

        @endforeach

    </div>
</li>
