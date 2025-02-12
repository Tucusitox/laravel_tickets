<?php

namespace App\Jobs;

use App\Mail\SendEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $asunto;
    protected $codigo;
    protected $token;
    protected $nombre;
    protected $correoContact;
    protected $mensaje;
    protected $destinatario;
    protected $cliente;

    public function __construct(array $data)
    {
        $this->asunto = $data['asunto'];
        $this->codigo = $data['codigo'] ?? null;
        $this->token = $data['token'] ?? null;
        $this->nombre = $data['nombre'] ?? null;
        $this->correoContact = $data['correoContact'] ?? null;
        $this->mensaje = $data['mensaje'];
        $this->destinatario = $data['destinatario'];
        $this->cliente = $data['cliente'] ?? null;
    }

    public function handle()
    {
        try {
            Mail::to($this->destinatario)->send(new SendEmail(
                [
                    'asunto' => $this->asunto,
                    'codigo' => $this->codigo,
                    'token' => $this->token,
                    'nombre' => $this->nombre,
                    'correoContact' => $this->correoContact,
                    'mensaje' =>  $this->mensaje,
                    'destinatario' => $this->destinatario,
                    'cliente' => $this->cliente,
                ]
            ));
        } catch (\Exception $e) {
            error_log('Error al enviar el correo: ' . $e->getMessage());
        }
    }
}
