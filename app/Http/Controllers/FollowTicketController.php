<?php

namespace App\Http\Controllers;

use App\Models\FollowsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FollowTicketController
{
    public function saveFollow(Request $request, int $id_userProjectRequest, int $id_request)
    {
        $request->validate(
            [
                'FollowDescription' => 'required|string|min:20|max:900',
            ],
            [
                'FollowDescription.required' => 'La descripción es obligatoria. Por favor, ingrésala.',
                'FollowDescription.min' => 'La descripción debe tener al menos :min caracteres.',
                'FollowDescription.max' => 'La descripción no puede exceder los :max caracteres.',
            ]
        );

        $UserName = User::select('user_name')
        ->where('user_id',Auth::id())
        ->first();

        FollowsRequest::insert([
            'fk_UserProjectRequest' => $id_userProjectRequest,
            'follow_userRegister' => $UserName->user_name,
            'follow_description' => $request->post('FollowDescription'),
            'date_register' => now()->setTimezone('America/Caracas'),
        ]);

        return redirect()->route('details.tickets', ['id_request' => $id_request])->with('success','Seguimiento realizado con éxito');
    }
}
