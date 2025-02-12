<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValidateUpdateProfile;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileUpdateController
{
    // ACTUALIZAR INFORMACION DE PERFIL
    public function updateProfile(ValidateUpdateProfile $request)
    {
        if ($request->validated()) {

            User::find(Auth::id())
            ->update([
                'user_identification' => $request->post('UserIdentification'),
                'user_gender' => $request->post('UserGender'),
                'user_name' => $request->post('UserName'),
                'user_lastName' => $request->post('UserLastName'),
                'user_dateOfBirth' => $request->post('UserDateOfBirth'),
            ]);

            return redirect()->route('profile')->with('success','Información actualizada con éxito');
        }    
    }

    // ACTUALIZAR CONTRASEÑA DEL USUARIO AUTENTICADO
    public function updatePassword(Request $request)
    {
        $request->validate([
            'newPassword' => 'required|string|min:8',
            'confirmPassword' => 'required|string|min:8',
        ], [
            'newPassword.required' => 'Por favor ingresa una nueva contraseña.',
            'newPassword.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'confirmPassword.required' => 'Por favor confirma tu nueva contraseña.',
            'confirmPassword.min' => 'La contraseña de confirmación debe tener al menos 8 caracteres.',
        ]);

        // VALIDAR QUE COINCIDAN LAS CONTRASEÑAS
        if ($request->post('newPassword') !== $request->post('confirmPassword')) {
            return redirect()->route('profile')->withErrors('Las contraseñas con coinciden');
        }

        // ACTULIZAR CONTRASEÑA
        User::where('user_id', Auth::id())
        ->update([ 'password' => Hash::make($request->post('newPassword')) ]);

        return redirect()->route('profile')->with('success','Contraseña actualizada con éxito');
    }
}
