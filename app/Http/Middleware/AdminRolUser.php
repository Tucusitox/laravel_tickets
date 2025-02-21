<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminRolUser
{
    // PARA PROTEGER LAS RUTAS QUE SON SOLO DE ADMINISTRADOR
    public function handle($request, Closure $next)
    {
        $user = User::join('rols', 'users.fk_rol', '=', 'rols.id_rol')
            ->where('user_id', Auth::id())
            ->first();

        if ($user && $user->rol_name !== "Administrador") {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
