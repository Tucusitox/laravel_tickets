<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $asunto;
    protected $codigo;
    protected $token;
    protected $nombre;
    protected $correoContact;
    protected $mensaje;
    protected $cliente;

    /**
     * Create a new message instance.
     */
    public function __construct(array $data)
    {
        $this->asunto = $data['asunto'];
        $this->codigo = $data['codigo'] ?? null;
        $this->token = $data['token'] ?? null;
        $this->nombre = $data['nombre'] ?? null;
        $this->correoContact = $data['correoContact'] ?? null;
        $this->mensaje = $data['mensaje'];
        $this->cliente = $data['cliente'] ?? null;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->asunto,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'mails.contact-form',
            with: [
                'codigo' => $this->codigo,
                'token' => $this->token,
                'nombre' => $this->nombre,
                'correoContact' => $this->correoContact,
                'mensaje' => $this->mensaje,
                'cliente' => $this->cliente,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
