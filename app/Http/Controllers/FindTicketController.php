<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\Request as TicketsRequest;
use Illuminate\Http\Request;

class FindTicketController
{
    public $TicketId;
    public $RegexError;
    public $TicketEmpty;

    // METODO PARA VALIDAR EL FORMATO DEL CODIGO Y BUSCAR SU ID
    public function findTicket(Request $request)
    {
        // INVOCAMOS EL METODO PARA DEVOLVER EL ID DEL TICKET
        $this->returnTicket($request->post('FindTicket'));

        if ($this->RegexError == true) {
            return redirect()->route('dashboard')->withErrors('El formato del código ingresado no es valido');
        }
        else if ($this->TicketEmpty == true) {
            return redirect()->route('dashboard')->withErrors('¡El código ingresado no existe en el sistema!');
        }

        // SI NO EXISTEN ERRORES DE VALIDACION ENVIAMOS EL ID A LA VISTA "detailsTickets"
        return redirect()->route('details.tickets', ['id_request' => $this->TicketId]);
    }

    // METODO PARA MARCAR NOTIFCACION COMO LEIDA
    public function notifyCheck(string $CodeRequest)
    {
        // INVOCAMOS EL METODO PARA DEVOLVER EL ID DEL TICKET
        $this->returnTicket($CodeRequest);

        if ($this->RegexError == true) {
            return redirect()->route('dashboard')->withErrors('El formato del código ingresado no es valido');
        }
        else if ($this->TicketEmpty == true) {
            return redirect()->route('dashboard')->withErrors('¡El código ingresado no existe en el sistema!');
        }

        // MARCAMOS LA NOTIFICACION COM LEIDA
        Notification::whereRaw("JSON_UNQUOTE(JSON_EXTRACT(data, '$.codigo')) = ?", [$CodeRequest])
        ->update(['read_at' => now()]);

        // SI NO EXISTEN ERRORES DE VALIDACION ENVIAMOS EL ID A LA VISTA "detailsTickets"
        return redirect()->route('details.tickets', ['id_request' => $this->TicketId]);
    }

    public function returnTicket($param)
    {
        //VALIDAMOS EL FORMATO DEL CODIGO
        $regexCode = '/^[A-Z0-9]{6}$/';
        if (!preg_match($regexCode, $param)) {
            $this->RegexError = true;
        }
        // BUSCAMOS EL ID DEL TICKET Y VALIDAMOS SI EXISTE
        $IdTicket = TicketsRequest::where('request_code', $param)->first();
        empty($IdTicket) ? $this->TicketEmpty = true : $this->TicketId = $IdTicket->id_request;
    }
}
