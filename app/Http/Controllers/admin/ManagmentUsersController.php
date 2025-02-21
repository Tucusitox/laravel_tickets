<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManagmentUsersController
{
    // METODO PARA BUSCAR UN USUARIO POR CODIGO
    public function showUser(Request $request)
    {
        $request->validate([
            'UserCode' => 'required|regex:/^[A-Z0-9]{6}$/',
        ],[
            'UserCode.required' => 'Por favor, ingrese un código para buscar.',
            'UserCode.regex' => 'El código no cumple con el formato esperado.',
        ]);

        $UserFind = User::where('user_code', $request->post('UserCode'))->first();

        if (empty($UserFind)) {
            return redirect()->route('managment.users')->withErrors('¡Este usuario no existe en el sistema!');
        }

        return redirect()->route('managment.users',$UserFind->user_id);
    }

    // METODO PARA CAMBIAR EL ROL DE UN USUARIO
    public function changeRol(Request $request, int $user_id)
    {
        User::find($user_id)->update(['fk_rol' => $request->post('UserNewRol')]);
        return redirect()->route('managment.users')->with('success','Rol del usuario cambiado con éxito');
    }

    // METODO PARA BLOQUEAR Y DESBLOQUEAR A UN USUARIO DEL SISTEMA
    public function blockUser(int $user_id, bool $bolean=false)
    {
        // PARA DESBLOQUEAR
        if ($bolean == true) {
            User::find($user_id)->update(['user_status' => 'verificado']);
            return redirect()->route('managment.users')->with('success','Usuario desbloqueado con éxito');
        }
        // PARA BLOQUEAR
        User::find($user_id)->update(['user_status' => 'bloqueado']);
        return redirect()->route('managment.users')->with('success','Usuario bloqueado con éxito');
    }

    // METODO PARA ELIMINAR A UN USUARIO DEL SISTEMA
    public function softDeleteUser(Request $request, int $user_id)
    {
        $request->validate([
            'AdminPassword' => 'required|string|min:8',
        ],[
            'AdminPassword.required' => 'Por favor, ingrese la contraseña de administrador.',
            'AdminPassword.min' => 'La contraseña debe ser de 8 caracteres como mínimo.',
        ]);   

        // VALIDAR LA CONTRASEÑA
        $UserAuth = User::find(Auth::id());
        if ( !Hash::check( $request->post('AdminPassword'), $UserAuth->password ) ) {
            return redirect()->route('managment.users')->withErrors('La contraseña de administrador es inválida');
        }

        User::find($user_id)->delete();
        return redirect()->route('managment.users')->with('success','Usuario eliminado con éxito');
    }
}
