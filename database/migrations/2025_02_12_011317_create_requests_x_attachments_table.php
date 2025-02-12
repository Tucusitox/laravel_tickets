<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requests_x_attachments', function (Blueprint $table) {
            $table->integer('id_requestXattachmentl', true);
            $table->integer('fk_request')->index('fk_requests_has_attachments_requests1_idx');
            $table->integer('fk_attachment')->index('fk_requests_has_attachments_attachments1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests_x_attachments');
    }
};
