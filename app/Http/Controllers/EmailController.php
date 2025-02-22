<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmailController
{
    // ENIVAR CORREO DE SOLICITUD RECIBIDA, SEGUIMIENTO Y CONFIRMACION DE SOLUCIONADO
    public function emailNotify($cliente, $destinatario, $mensaje)
    {
        $asunto = "MorianSoft Computación mensaje";
        // LAMAMOS A LA CLASE CONSTRUCTORA PARA ENVIAR EL CORREO
        dispatch(new SendEmailJob([
            'asunto' => $asunto,
            'mensaje' => $mensaje,
            'destinatario' => $destinatario,
            'cliente' => $cliente,
        ]));
    }

    // ENIVAR CORREO DE CONFIRMACION AL USUARIO CON UN CODIGO ALEATORIO
    public function recoverPassword($id_user, $destinatario)
    {
        // GENERAR EL CODIGO ALEATORIO Y LOS DATOS A ENVIAR
        $asunto = "Codigo de recuperación";
        $mensaje = "Estimado usuario recupere su contraseña con el siguiente código";
        $codigo = strtoupper(Str::random(8));

        // ACTUALIZAMOS LA CONTRASEÑA DEL USUARIO
        User::where('user_id', $id_user)
            ->update(['password' => Hash::make($codigo)]);

        // ENVIAR CORREO AL USUARIO MEDIANTE UN JOB EN SEGUNDO PLANO
        dispatch(new SendEmailJob([
            'asunto' => $asunto,
            'codigo' => $codigo,
            'mensaje' => $mensaje,
            'destinatario' => $destinatario,
        ]));
    }
}
