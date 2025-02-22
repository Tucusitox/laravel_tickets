<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\CreateUserController;
use App\Http\Controllers\auth\AutenticationController;
use App\Http\Controllers\auth\RecuperarContrasena;
use Illuminate\Support\Facades\Auth;

// RUTA PARA INICIAR SESION ----------------------------------
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.singIn');
})->name('login');

// RUTA PARA MOSTRAR VISTA PARA VERIFICAR UN NUEVO USUARIO ----------------------------------
Route::get('/VerificationNewUser/{user_id}', function ($user_id) {
    return view('auth.verificationNewUser', compact('user_id'));
})->name('user.verification');
Route::put('/VerifyUser/{user_id}', [CreateUserController::class, 'verifyUser'])->name('user.verify');

// RUTAS PARA LA AUTENTICACION, RECUPERACION DE CONTRASEÑAS, VERIFICACION DE USUARIOS DE USUARIOS  ---------------
Route::post('/AuthUser', [AutenticationController::class, 'autenticar'])->name('user.auth');
Route::post('/RecoverPassword', [RecuperarContrasena::class, 'store'])->name('recuperar.store');
Route::get('/ViewRecover/{id_user}', [RecuperarContrasena::class, 'recoverIndex'])->name('recuperar.index');
Route::post('/ValidateCode/{id_user}', [RecuperarContrasena::class, 'newPassword'])->name('new.password');


