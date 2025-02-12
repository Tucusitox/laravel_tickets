<?php

namespace App\Jobs;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class BackupDatabaseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // EJECUTAMOS EL COMANDO ARTISAN PARA EL BACKUP
            Artisan::call('backup:run --only-db');
            
            // VALIDAMOS QUE NO HAYA HABIDO NINGUN ERROR
            if (Artisan::output()) {
                throw new Exception(Artisan::output());
            }
            
        } catch (Exception $e) {
            return 'Error al realizar el backup: ' . $e->getMessage();
        }
    }
}
