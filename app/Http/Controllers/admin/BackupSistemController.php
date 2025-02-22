<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Jobs\BackupDatabaseJob;

class BackupSistemController
{
    // METODO PARA VALIDAR CONTRASEÑA E INVOCAR EL JOB APRA EL BACKUP DE LA BASE DE DATOS
    public function store(Request $request)
    {
        $request->validate([
            'AdminPassword' => 'required|string|min:8',
        ], [
            'AdminPassword.required' => 'Por favor, ingresa tu contraseña de administrador',
            'AdminPassword.min' => 'La contraseña de administrador debe tener al menos 8 caracteres',
        ]);    

        $UserFind = User::find(Auth::id());

        // CASO 1: CONTRASEÑA NO COINCIDE
        if (!Hash::check($request->post('AdminPassword'), $UserFind->password)) {
            return redirect()->route('backup.index')->withErrors('La contraseña de administrador es incorrecta');
        }

        // INVOCAMOS EL BACKUP
        BackupDatabaseJob::dispatch();
        return redirect()->route('backup.index')->with('success','Respaldo generado con éxito');
    }
}
