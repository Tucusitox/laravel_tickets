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
        Schema::table('requests_x_attachments', function (Blueprint $table) {
            $table->foreign(['fk_attachment'], 'fk_requests_has_attachments_attachments1')->references(['id_attachment'])->on('attachments')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['fk_request'], 'fk_requests_has_attachments_requests1')->references(['id_request'])->on('requests')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests_x_attachments', function (Blueprint $table) {
            $table->dropForeign('fk_requests_has_attachments_attachments1');
            $table->dropForeign('fk_requests_has_attachments_requests1');
        });
    }
};
