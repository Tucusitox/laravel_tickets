<?php

namespace App\Jobs;

use App\Http\Controllers\AsignacionController;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Webklex\IMAP\Facades\Client;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class GetEmails implements ShouldQueue
{
    use Queueable;

    public $emailsData = [];
    public $routesFiles = [];
    public $DataValidate;

    public function handle(): void
    {
        $this->DataValidate = json_decode(File::get(storage_path('app/public/PalabrasClave.json')), true);

        try {
            $client = Client::account('gmail');
            $folder = $client->getFolder('INBOX');
            $messages = $folder->messages()->unseen()->since(Carbon::now()->setTimezone('America/Caracas'))->get();

            foreach ($messages as $message) {
                // MARCAR EL CORREO COMO LEIDO
                $message->setFlag('Seen');

                // SEPARAMOS EL NOMBRE Y EL CORREO
                $result = [];
                $from = $message->getFrom();
                foreach ($from->get() as $sender) {
                    if (preg_match('/^(.*)\s<([^>]+)>$/', $sender, $matches)) {
                        $result = [
                            'personal' => $matches[1],
                            'mail' => $matches[2],
                        ];
                    }
                }
                
                // GUARDAR ARCHIVOS ADJUNTOS
                $attachments = $message->getAttachments();
                $this->procesFiles($attachments, $result["mail"]);

                $subject = $message->getSubject();
                $body = $message->getTextBody();

                // Validar que subject y body no estén vacíos
                if (!empty($subject) && !empty($body)) {

                    // Convertir a minúsculas para la comparación
                    $subjectLower = strtolower($subject);
                    $bodyLower = strtolower($body);

                    // Verificar si hay coincidencias con DataValidate
                    $subjectContainsValidWord = $this->containsValidWord($subjectLower);
                    $bodyContainsValidWord = $this->containsValidWord($bodyLower);

                    // Si hay coincidencias, agregar a emailsData
                    if ($subjectContainsValidWord && $bodyContainsValidWord) {
                        $this->emailsData[] = [
                            'from_name' => $result["personal"],
                            'from_email' => $result["mail"],
                            'subject' => $subject,
                            'body' => $body,
                            'attachments_count' => count($attachments),
                            'attachments_route' => $this->routesFiles,
                        ];
                    }
                }
            }

            // VALIDAR SI HAY NUEVOS MENSAJES SIN LEER
            if (empty($this->emailsData)) {
                var_dump("No existen mensajes actualemente");
            } else {
                //Log::info('Emails procesados:', $this->emailsData);
                app(AsignacionController::class)->getIdUserAsig($this->emailsData);
            }
        } catch (\Throwable $e) {
            // Log::error('Error al leer correos: ' . $e->getMessage());
            // Log::error('Trace: ' . $e->getTraceAsString());
            var_dump('Error al leer correos: ' . $e->getMessage());
            var_dump('Trace: ' . $e->getTraceAsString());
        }
    }

    private function containsValidWord($text)
    {
        foreach ($this->DataValidate as $word) {
            if (strpos($text, $word) !== false) {
                return true;
            }
        }
        return false;
    }

    // METODO PARA PROCESAR LOS ARCHIVOS
    private function procesFiles(object $files, string $email)
    {
        foreach ($files as $file) {

            $destinationPath = public_path('attachments');
            $fileName = date('YmdHis') . '-' . $email . '.' . $file->getAttributes()["name"];
            $file->save($destinationPath, $fileName);
            $this->routesFiles[] = 'attachments/' . $fileName;
        }
    }
}
