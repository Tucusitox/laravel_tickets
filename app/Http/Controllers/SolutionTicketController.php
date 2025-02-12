<?php

namespace App\Http\Controllers;

use App\Models\Request as TicketRequest;
use App\Models\RequestSolution;
use App\Models\User;
use Illuminate\Http\Request;
use DateTime;
use Illuminate\Support\Facades\Auth;

class SolutionTicketController
{
    public $SolutionTime;

    public function saveSolution(Request $request, int $id_request)
    {
        $request->validate([
            'SolutionTittle' => 'required|string|min:5',
            'SolutionDescription' => 'required|string|min:10'
        ], [
            'SolutionTittle.required' => 'El título de la solución es obligatorio.',
            'SolutionTittle.min' => 'El título de la solución debe tener al menos 5 caracteres.',

            'SolutionDescription.required' => 'La descripción de la solución es obligatoria.',
        ]);

        // INVOCAMOS METODO PARA CALCULO DE TIEMPO
        $this->calculatorSolution($id_request);

        $UserName = User::select('user_name')->where('user_id', Auth::id())->first();

        // GUARDAMOS LA SOLUCION EL LA BASE DE DATOS
        RequestSolution::insert([
            [
                'fk_request' => $id_request,
                'solution_userName' => $UserName->user_name,
                'solution_tittle' => $request->post('SolutionTittle'),
                'solution_description' => $request->post('SolutionDescription'),
                'solution_time' => $this->SolutionTime,
            ],
        ]);

        return redirect()->route('details.tickets', ['id_request' => $id_request])->with('success', 'Ticket solucionado con éxito');
    }

    private function calculatorSolution($id_request)
    {       
        $TicketSolution = TicketRequest::find($id_request);
        $TicketSolution->fk_statusRequest = 3; // MARCAR TIPO DE ESTATUS COMO SOLUCIONADO
        $TicketSolution->request_date_finish = now()->setTimezone('America/Caracas');
    
        // CALCULAMOS EL TIEMPO DE SOLUCIÓN
        $inicio = new DateTime($TicketSolution->request_date_start->format('H:i:s'));
        $actual = new DateTime(now()->setTimezone('America/Caracas')->format('H:i:s'));
        $interval = $inicio->diff($actual);
    
        // FORMATEAMOS EL INTERVALO A UNA CADENA DE TEXTO
        $this->SolutionTime = $interval->format('%H:%I:%S'); //->Formato: Horas:Minutos:Segundos
    
        $TicketSolution->save();
    }
}
