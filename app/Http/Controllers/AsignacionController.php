<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Project;
use App\Models\Request;
use App\Models\RequestsXAttachment;
use App\Models\User;
use App\Models\UsersProjectsRequest;
use Illuminate\Support\Str;
use App\Notifications\UserNotification;
use App\Http\Controllers\EmailController;


class AsignacionController
{
    public $IdUserAsig;

    public function getIdUserAsig(array $DataEmails)
    {
        foreach ($DataEmails as $item) {

            // TRAER EL ID DEL USUARIO A ASIGNAR
            $this->getIdUser();

            $requestCode = strtoupper(Str::random(6));

            Project::insert(
                [
                    'project_name' => $item['subject'],
                ],
            );

            Request::insert(
                [
                    'fk_user_prime' => $this->IdUserAsig,
                    'fk_statusRequest' => 1,
                    'request_code' => $requestCode,
                    'request_applicantName' => $item['from_name'],
                    'request_applicantEmail' => $item['from_email'],
                    'request_tittle' => $item['subject'],
                    'request_description' => $item['body'],
                    'request_date_start' => now()->setTimezone('America/Caracas'),
                ],
            );

            $ForeansRecents = $this->findNewId();

            UsersProjectsRequest::insert(
                [
                    'fk_user' => $this->IdUserAsig,
                    'fk_project' => $ForeansRecents['idProject'],
                    'fk_request' => $ForeansRecents['idRequest'],
                ],
            );

            if ($item['attachments_count'] > 0) {

                foreach ($item['attachments_route'] as $DocsRoute) {

                    $attachmentId = Attachment::insertGetId([
                        'attachment_route' => $DocsRoute,
                    ]);

                    RequestsXAttachment::insert([
                        'fk_request' => $ForeansRecents['idRequest'],
                        'fk_attachment' => $attachmentId,
                    ]);
                }
            }
            // LLAMAR METODO PARA NOTIFCACIONES
            $this->notifyUser($this->IdUserAsig, $requestCode, $item['from_email']);
        }

        var_dump("completado");
    }

    private function getIdUser()
    {
        $id = UsersProjectsRequest::select('fk_user')
            ->selectRaw('COUNT(*) as cantidad')
            ->groupBy('fk_user')
            ->having('cantidad', '<', 10)
            ->orderBy('cantidad', 'asc')
            ->limit(1)
            ->first();

        $idAdmin = User::select('user_id')
            ->join('rols', 'rols.id_rol', '=', 'users.fk_rol')
            ->where('rol_name', 'Administrador')
            ->first();

        empty($id) ? $this->IdUserAsig = $idAdmin->user_id : $this->IdUserAsig = $id->fk_user;
    }

    private function findNewId()
    {
        $ultProjectRegis = Project::orderBy('id_project', 'desc')->first();
        $idProject = $ultProjectRegis ? $ultProjectRegis->id_project : null;

        $ultRequestRegis = Request::orderBy('id_request', 'desc')->first();
        $idRequest = $ultRequestRegis ? $ultRequestRegis->id_request : null;

        return [
            'idProject' => $idProject,
            'idRequest' => $idRequest,
        ];
    }

    // METODO PARA ENVIAR NOTIFICACIONES
    private function notifyUser($userId, $requestCode, $destinatario)
    {
        // CARGAR NOTIFICACION EN LA BD
        $user = User::find($userId);
        $user->notify(new UserNotification($requestCode));

        // ENVIAR NOTIFICACION POR CORREO
        $EmailController = new EmailController;
        $EmailController->emailNotify(true,$destinatario);
        var_dump('notificacion enviada');
    }
}
