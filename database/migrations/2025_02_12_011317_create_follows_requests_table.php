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
        Schema::create('follows_requests', function (Blueprint $table) {
            $table->integer('id_followRequest', true);
            $table->integer('fk_UserProjectRequest')->index('fk_follows_requests_users_projects_request1_idx');
            $table->string('follow_userRegister', 100);
            $table->string('follow_description', 1000);
            $table->date('date_register');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('follows_requests');
    }
};
