<?php

namespace App\Http\Controllers\auth;

use App\Models\SessionsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LogoutController;

class AutenticationController
{
    // METODO DE AUTENTICACION
    public function autenticar(Request $request)
    {
        // OBTENER LAS CREDENCIALES DE ACCESO Y VALIDARLAS
        $credentials = $request->validate([
            'email' => 'required|string|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/',
            'password' => 'required|string|min:8',
        ]);

        // CASO 1: SI LAS CREDENCIALES SON INCORRECTAS REDIRIGIR AL USUARIO AL LOGIN
        if (!Auth::attempt($credentials)) {
            return redirect()->route('login')->withErrors('Correo o contraseña incorrectos');
        }

        // CASO 2: EL USUARIO ESTA BLOQUEADO
        if (Auth::user()->user_status == 'bloqueado') {
            $LogoutController = new LogoutController;
            $LogoutController->logoutAndRedirect();
            return redirect()->route('login')->withErrors('Este usuario se encuentra bloqueado del sistema');
        }

        // CASO 3: EL USUARIO NO ESTA VERIFICADO AUN
        if (Auth::user()->user_status == 'no verificado') {
            $UserId = Auth::id();
            $LogoutController = new LogoutController;
            $LogoutController->logoutAndRedirect();
            return redirect()->route('user.verification', ['user_id' => $UserId]);
        }

        // CASO 4: VALIDAR SI YA TIENE UNA SESION ACTIVA
        $SessionExist = SessionsUser::where('fk_user', Auth::id())
        ->where('session_status', 'activo')
        ->exists();

        if ($SessionExist) {
            $LogoutController = new LogoutController;
            $LogoutController->logoutAndRedirect();
            return redirect()->route('login')->withErrors('Este usuario tiene una sesión activa en el sistema');
        }
        
        // CASO IDEAL: INICIAR LA SESION DEL USUARIO
        $this->crearSession();
        $request->session()->regenerate();
        return redirect()->route('dashboard');
    }

    // METODO PARA REGISTRAR LA SESION DEL USUARIO
    public function crearSession()
    {
        SessionsUser::create([
            'fk_user' => Auth::id(),
            'session_date' => now()->setTimezone('America/Caracas')->format('Y-m-d'),
            'session_time_start' => now()->setTimezone('America/Caracas')->format('H:i:s'),
            'session_time_closing' => null,
            'session_duration' => null,
            'session_status' => 'activo',
        ]);
    }
}
