<?php

use App\Http\Controllers\admin\ManagmentSessionsController;
use App\Http\Controllers\admin\ManagmentUsersController;
use App\Http\Controllers\auth\AutenticationController;
use App\Http\Controllers\auth\LogoutController;
use App\Http\Controllers\auth\RecuperarContrasena;
use App\Http\Controllers\FindTicketController;
use App\Http\Controllers\FollowTicketController;
use App\Http\Controllers\ProfileUpdateController;
use App\Http\Controllers\SolutionTicketController;
use App\Http\Middleware\AdminRolUser;
use App\Http\Middleware\sessionInactiva;
use App\Jobs\GetEmails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// RUTA PARA INICIAR SESION
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.singIn');
})->name('login');

// RUTAS PARA LA AUTENTICACION Y RECUPERACION DE CONTRASEÑAS DE USUARIOS  ---------------------------------------
Route::post('/AuthUser', [AutenticationController::class, 'autenticar'])->name('user.auth');
Route::post('/RecoverPassword', [RecuperarContrasena::class, 'store'])->name('recuperar.store');
Route::get('/ViewRecover/{id_user}', [RecuperarContrasena::class, 'recoverIndex'])->name('recuperar.index');
Route::post('/ValidateCode/{id_user}', [RecuperarContrasena::class, 'newPassword'])->name('new.password');

// RUTAS PROTEGIDAS POR MIDDELEWARE (AUTH, CIERRE DE SESION POR INACTIVIDAD) --------------------------------------------------
Route::middleware(['auth', sessionInactiva::class])->group(function () {
    // RUTA PARA ACTUALIZAR LA SESION CUANDO EL USUARIO INTERACTUE CON LA APP
    Route::post('/actualizarSesion', function () {
        session()->put('ultimaActividad', time());
        return response()->json(['ultimaActividad' => session('ultimaActividad')]);
    });

    // DASHBOARD MIS TICKETS
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // DASHBOARD TICKETS DE MI GRUPO
    Route::get('/GroupTickets', function () {
        return view('groupTickets');
    })->name('groupTickets');

    // DASHBOARD PROFILE
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    // DASHBOARD DETAILS TICKETS
    Route::get('/DetailTicket/{id_request}', function (int $id_request) {
        return view('detailsTickets', compact('id_request'));
    })->name('details.tickets');

    // CERRAR SESION
    Route::post('/cerrar', [LogoutController::class, 'logout'])->name('logout.index');

    // RUTA PARA LLAMAR AL JOB PARA CARGAR MAS CORREOS LOS CORREOS
    Route::get('/JobEmails', function () {
        GetEmails::dispatch();
        return redirect()->route('dashboard')->with('success', 'Solicitud enviada, refresque en 10 segundos');
    })->name('tickets.refresh');

    // RUTAS PARA ACTUALIZAR INFORMACION DE PERFIL O LA CONTRASEÑA
    Route::post('/UpdateProfile', [ProfileUpdateController::class, 'updateProfile'])->name('profile.update');
    Route::post('/UpdatePassword', [ProfileUpdateController::class, 'updatePassword'])->name('profile.password');

    // RUTAS PARA BUSCAR UN TICKET EN ESPECIFICO Y MARCARLO COMO LEIDO
    Route::post('/FindTicket', [FindTicketController::class, 'findTicket'])->name('ticket.find');
    // RUTA PARA BUSCAR TICKET DESDE NOTIFICACIONES
    Route::get('/NotifyCheck/{CodeRequest}', [FindTicketController::class, 'notifyCheck'])->name('notify.check');

    // RUTA PARA CAPTURA EL CODIGO DE LA NOTIFICACIÓN Y DESPUES PROCESARLO
    Route::get('/CodeTicket/{CodeRequest}', function (string $CodeRequest) {
        return redirect()->route('notify.check', ['CodeRequest' => $CodeRequest]);
    })->name('notify.code');

    // RUTA PARA DARLE SEGUIMIENTO A UN TICKET
    Route::get('/FollowTicket/{id_request}', function (int $id_request) {
        return view('followTicket', compact('id_request'));
    })->name('ticket.follow');
    Route::post('/StoreFollowTicket/{id_userProjectRequest}/{id_request}', [FollowTicketController::class, 'saveFollow'])->name('ticketFollow.save');

    // RUTA PARA SOLUCIONAR UN TICKET
    Route::get('/SolutionTicket/{id_request}', function (int $id_request) {
        return view('solutionTicket', compact('id_request'));
    })->name('ticket.solution');
    Route::post('/SaveSolutionTicket/{id_request}', [SolutionTicketController::class, 'saveSolution'])->name('ticektSolution.save');
});

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
});
