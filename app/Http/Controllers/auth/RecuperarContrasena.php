<?php

namespace App\Http\Controllers\auth;

use Illuminate\Http\Request;
use App\Http\Controllers\EmailController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RecuperarContrasena
{
    // METODO PARA ENVIARLE EL CODIGO DE RECUPERACION POR CORREO
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|string|regex:/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/',
        ]);

        $contrasUser = User::where('email', $request->post('email'))->first();

        if (!$contrasUser) {
            return redirect()->back()->withErrors('Esté correo no existe en el sistema');
        }

        $EmailController = new EmailController;
        $EmailController->recoverPassword($contrasUser->user_id, $contrasUser->email);
        return redirect()->route('recuperar.index',['id_user'=>$contrasUser->user_id]);
    }
    // DEVOLVER VISTA PARA CAMBIAR LA CONTRASEÑA
    public function recoverIndex($id_user)
    {
        return view('auth.passwordRecover', compact('id_user'));
    }

    // METODO PARA CAMBIAR LA CONTRASEÑA DEL USUARIO
    public function newPassword(Request $request, $id_user)
    {
        $request->validate([
            'codeConfirm'=>'required|regex:/^[A-Z0-9]{8}$/',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|min:8',
        ],
        [
            'codeConfirm.required' => 'El código es obligatorio',
            'codeConfirm.regex' => 'El formato del código es invalido',
            'newPassword.required' => 'La nueva contraseña es obligatoria',
            'newPassword.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'confirmPassword.required' => 'La confirmación de la contraseña es obligatoria',
            'confirmPassword.min' => 'La confirmación de la contraseña debe tener al menos 8 caracteres.',
        ]);

        // SI LAS CONTRASEÑA NO COINCIDEN
        if ($request->post('newPassword') !== $request->post('confirmPassword')) {
            return redirect()->back()->withErrors('Las contraseñas no coinciden');
        }

        // CAPTURAMOS EL LA INFORMACION DEL USUARIO
        $user = User::find($id_user);
        
        // GENERAMOS EL UPDATE DE LA CONTRASEÑA
        if (Hash::check($request->post('codeConfirm'), $user->password)) {
            $user->password = Hash::make($request->post('newPassword'));
            $user->save();
            return redirect()->route('login')->with('success','Contraseña cambiada con éxito');
        } 
        else {
            return redirect()->back()->withErrors('El código de confirmación es incorrecto');
        }
    }
}
