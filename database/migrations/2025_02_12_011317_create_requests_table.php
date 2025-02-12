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
        Schema::create('requests', function (Blueprint $table) {
            $table->integer('id_request', true);
            $table->integer('fk_user_prime')->index('fk_requests_users1_idx');
            $table->integer('fk_statusRequest')->index('fk_requests_status_requests1_idx');
            $table->string('request_code', 100)->unique('ticket_code_unique');
            $table->string('request_applicantName', 100);
            $table->string('request_applicantEmail', 100);
            $table->string('request_tittle', 100);
            $table->string('request_description', 500);
            $table->date('request_date_start');
            $table->date('request_date_finish')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
