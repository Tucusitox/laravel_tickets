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
        Schema::table('requests', function (Blueprint $table) {
            $table->foreign(['fk_statusRequest'], 'fk_requests_status_requests1')->references(['id_statusRequest'])->on('status_requests')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['fk_user_prime'], 'fk_requests_users1')->references(['user_id'])->on('users')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('requests', function (Blueprint $table) {
            $table->dropForeign('fk_requests_status_requests1');
            $table->dropForeign('fk_requests_users1');
        });
    }
};
