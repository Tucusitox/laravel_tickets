<?php

use App\Http\Controllers\admin\BackupSistemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\ManagmentSessionsController;
use App\Http\Controllers\admin\ManagmentUsersController;
use App\Http\Controllers\admin\CreateUserController;
use App\Http\Middleware\AdminRolUser;
use App\Http\Middleware\sessionInactiva;

// RUTAS DE ADMINISTRADOR DEL SISTEMA  ----------------------------------------

Route::middleware(['auth', sessionInactiva::class, AdminRolUser::class])->group(function () {

    // RUTA PARA GESTIONAR USUARIOS (ADMINISTRADOR)
    Route::get('/ManagmentUsers/{UserFind?}', function ($UserFind=null) {
        return view('admin.managmentUser', compact('UserFind'));
    })->name('managment.users');

    // RUTAS PARA CAMBIAR ROL, BLOQUEAR, DESBLOQUEAR Y ELIMINAR USUARIOS (SOFT DELETE)
    Route::post('/ShowUser', [ManagmentUsersController::class, 'showUser'])->name('user.show');
    Route::put('/ChangeRol/{user_id}', [ManagmentUsersController::class, 'changeRol'])->name('userChange.rol');
    Route::put('/BlockUser/{user_id}', [ManagmentUsersController::class, 'blockUser'])->name('user.block');
    Route::get('/DesBlockUser/{user_id}/{bolean}', [ManagmentUsersController::class, 'blockUser'])->name('user.DesBlock');
    Route::delete('/DeleteUser/{user_id}', [ManagmentUsersController::class, 'softDeleteUser'])->name('user.delete');

    // RUTA PARA GESTIONAR LAS SESIONES DE USUARIOS (ADMINISTRADOR)
    Route::get('/ManagmentSesions/{bolean?}', function ($bolean=false) {
        $FindSession = session('FindSession');
        return view('admin.managmentSesions', compact('FindSession','bolean'));
    })->name('managment.sesions');

    // RUTAS PARA CERRAR SESION Y BUSCAR POR CODIGO Y FECHA
    Route::get('/SessionCloseUser/{user_id}', [ManagmentSessionsController::class, 'closeSessionUser'])->name('session.close');
    Route::post('/SessionFindUser', [ManagmentSessionsController::class, 'findSessionUser'])->name('session.find');

    // RUTA PARA CREAR UN NUEVO USUARIO (ADMINISTRADOR)
    Route::get('/NewUser', function () {
        return view('admin.newUser');
    })->name('user.new');
    Route::post('/StoreUser', [CreateUserController::class, 'store'])->name('user.store');

    // RUTA PARA GENERAR RESPALDO DE LA BASE DE DATOS (ADMINISTRADOR)
    Route::get('/BackupSistem', function () {
        return view('admin.backupDataBase');
    })->name('backup.index');
    Route::post('/StoreBackup', [BackupSistemController::class, 'store'])->name('backup.store');
});