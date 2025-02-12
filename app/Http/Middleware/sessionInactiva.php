<?php

namespace App\Http\Middleware;

use App\Http\Controllers\auth\LogoutController;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class sessionInactiva
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //EVALUAR EL METODO HTTP Y SI EL USUARIO ESTA AUTENTICADO
        if ($request->isMethod('GET') && Auth::check()) {

            // OBTENER EL TIEMPO DE INACTIVIDAD
            if (session()->has('ultimaActividad')) {
                $lastActivity = session()->get('ultimaActividad');
                if (time() - $lastActivity > 1200) { // -> 20 MINUTOS
                    return app(LogoutController::class)->logout();
                }
            }
            // ACTUALIZAR LA SESION CADA VEZ QUE SE EJECUTE UNA SOLICITUD HTTP
            session()->put('ultimaActividad', time());
        }
        return $next($request);
    }
}
