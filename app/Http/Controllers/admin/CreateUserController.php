<?php

namespace App\Http\Controllers\admin;

use App\Http\Requests\ValidateCreateUser;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CreateUserController
{
    // METODO PARA CREAR UN NUEVO USUARIO EN EL SISTEMA
    public function store(ValidateCreateUser $request)
    {
        if ($request->validated()) {

            User::insert([
                'fk_rol' => $request->post('UserRol'),
                'fk_group' => $request->post('UserGroup'),
                'user_code' => strtoupper(Str::random(6)),
                'user_identification' => $request->post('UserIdentification'),
                'user_gender' => $request->post('UserGender'),
                'user_name' => $request->post('UserName'),
                'user_lastName' => $request->post('UserLastName'),
                'email' => $request->post('UserEmail'),
                'password' => Hash::make('12345678'),
                'user_dateOfBirth' => $request->post('UserDateOfBirth'),
                'user_status' => 'no verificado',
            ]);

            return redirect()->route('user.new')->with('success','Usuario creado con éxito');
        }
    }

    // METODO PARA VERIFICAR AL USAURIO RECIEN CREADO
    public function verifyUser(Request $request, int $user_id)
    {
        $request->validate([
            'BeforePassword' => 'required|string|min:8',
            'NewPassword' => 'required|string|min:8',
            'ConfirmPassword' => 'required|string|min:8',
        ], [
            'BeforePassword.required' => 'Por favor, ingresa tu contraseña anterior.',
            'BeforePassword.min' => 'La contraseña anterior debe tener al menos 8 caracteres.',
        
            'NewPassword.required' => 'Por favor, ingresa una nueva contraseña.',
            'NewPassword.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
        
            'ConfirmPassword.required' => 'Por favor, confirma tu nueva contraseña.',
            'ConfirmPassword.min' => 'La confirmación de la contraseña debe tener al menos 8 caracteres.',
        ]);

        $UserFind = User::find($user_id);

        // CASO 2: CONTRASEÑA ANTERIOR ES ICORRECTA
        if (!Hash::check($request->post('BeforePassword'), $UserFind->password)) {
            return redirect()->route('user.verification', ['user_id'=>$user_id])->withErrors('La contraseña anterior es incorrecta');
        }
        // CASO 1: CONTRASEÑA NUEVA Y DE CONFIRMACION NO COINCIDEN
        if ($request->post('ConfirmPassword') !== $request->post('NewPassword')) {
            return redirect()->route('user.verification', ['user_id'=>$user_id])->withErrors('Las contraseñas no coinciden');
        }

        // CASO IDEAL: ACTUALIZAR LA CONTRAE Y ESTATUS DEL USUARIO
        $UserFind->password = Hash::make($request->post('NewPassword'));
        $UserFind->user_status = 'verificado';
        $UserFind->save();

        return redirect()->route('login')->with('success','Contraseña cambiada con éxito');
    }
}
