<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FindRolController
{
    // METODO AUXILIAR PARA PROTEGER LAS RUTAS DEPENDIENDO DE LOS ROLES
    // ESTE METODO PUEDE SER INVOCADO SIN NINGUN PARAMETRO
    // ESTE METODO ES PARA SER APLICADO EN LOS COMPONENTES DE LIVEWIRE DE LA RUTA DASHBOARD
    // NO MANIPULAR SIN CONSULTARME

    public $RolUser;

    public function findRol()
    {
        $this->RolUser = User::join('rols', 'users.fk_rol', '=', 'rols.id_rol')
        ->where('user_id', Auth::id())
        ->first();

        if ($this->RolUser->rol_name !== "Publicador" && $this->RolUser->rol_name !== "Administrador") {
            return redirect()->route('dashboard', ['vista' => 'profile']);
        }
    }

    public function adminRol()
    {
        $this->RolUser = User::join('rols', 'users.fk_rol', '=', 'rols.id_rol')
        ->where('user_id', Auth::id())
        ->first();
    
        if ($this->RolUser->rol_name !== "Administrador") {
            return redirect()->route('dashboard', ['vista' => 'profile']);
        }
    }
}