<?php

namespace App\Http\Controllers\auth;

use App\Models\Session;
use App\Models\SessionsUser;
use Illuminate\Support\Facades\Auth;
use DateTime;

class LogoutController
{
    // METODO DE CIERRE DE SESIÓN
    public function logout()
    {
        // CAPTURAR EL TIEMPO DE INICIO DE LA SESION
        $sessionInicio = SessionsUser::select('session_time_start')
            ->where('fk_user', Auth::id())
            ->whereNull('session_time_closing')
            ->first();

        // CALCULAR LA DIFERENCIA ENTRE EL INICIO Y FINAL DE LA SESION
        $inicio = new DateTime($sessionInicio->session_time_start);
        $actual = new DateTime(now()->setTimezone('America/Caracas')->format('H:i:s'));
        $diferencia = $inicio->diff($actual);

        // ACTUALIZAR LA TABLA CON LOS NUEVOS DATOS
        SessionsUser::where('fk_user', Auth::id())
            ->whereNull('session_time_closing')
            ->update([
                'session_time_closing' => now()->setTimezone('America/Caracas')->format('H:i:s'),
                'session_status' => 'inactivo',
                'session_duration' => $diferencia->format('%h:%i:%s'),
            ]);

        // CERRAR LA SESION DEL USUARIO
        $this->logoutAndRedirect();
        session()->forget('ultimaActividad');
        return redirect()->route('login');
    }

    // METODO AUXILIAR PARA MANEJAR PARA EL CIERRE DE SESION DEL NAVEGADOR
    public function logoutAndRedirect()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
    }

    // METODO PARA CERRAR SESION DE UN USUARIO DESDE UNA VISTA (ADMINISTRADOR)
    public function closeSession($user_id)
    {
        // CERRAR LA SESION DEL USUARIO BLOCKEADO
        Session::where('user_id', $user_id)->delete();
        
        // CAPTURAR EL TIEMPO DE INICIO DE LA SESION
        $sessionInicio = SessionsUser::select('session_time_start')
            ->where('fk_user', $user_id)
            ->whereNull('session_time_closing')
            ->first();

        // CALCULAR LA DIFERENCIA ENTRE EL INICIO Y FINAL DE LA SESION
        $inicio = new DateTime($sessionInicio->session_time_start);
        $actual = new DateTime(now()->setTimezone('America/Caracas')->format('H:i:s'));
        $diferencia = $inicio->diff($actual);

        // ACTUALIZAR LA TABLA CON LOS NUEVOS DATOS
        SessionsUser::where('fk_user', $user_id)
            ->whereNull('session_time_closing')
            ->update([
                'session_time_closing' => now()->setTimezone('America/Caracas')->format('H:i:s'),
                'session_status' => 'inactivo',
                'session_duration' => $diferencia->format('%h:%i:%s'),
            ]);
    }
}
