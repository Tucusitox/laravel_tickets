<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\auth\LogoutController;
use App\Models\SessionsUser;

class ManagmentSessionsController
{
    // METODO PARA CERRAR LA SESION DE UN USUARIO
    public function closeSessionUser($user_id)
    {
        $CloseSession = new LogoutController;
        $CloseSession->closeSession($user_id);
        return redirect()->route('managment.sesions')->with('success', 'Sesión del usuario cerrada con éxito');
    }

    // METODO PARA BUSCAR SESIONES POR FECHA O CODIGO DE USUARIO
    public function findSessionUser(Request $request)
    {
        $request->validate([
            'UserCode' => 'required|regex:/^[A-Z0-9]{6}$/',
            'SessionDate' => 'required|regex:/^\d{4}\-\d{2}\-\d{2}$/',
        ],[
            'UserCode.required' => '',
            'UserCode.regex' => 'El código no cumple con el formato esperado.',
            'SessionDate.required' => 'Por favor, ingrese una fecha para buscar.',
            'SessionDate.regex' => 'La fecha no cumple con el formato esperado.',
        ]);

        $FindSession = SessionsUser::join('users', 'sessions_users.fk_user', '=', 'users.user_id')
        ->where('user_code',$request->post('UserCode'))
        ->where('session_date', $request->post('SessionDate'))
        ->get();

        // SI LA CONSULTA ES VACIA
        if ($FindSession->isEmpty()) {
            return redirect()->route('managment.sesions')->withErrors('No se encontraron sesiones en la busqueda indicada');
        }

        // SI NO ES VACIA
        session(['FindSession' => $FindSession]);
        return redirect()->route('managment.sesions', ['bolean' => true]);
    }
}
