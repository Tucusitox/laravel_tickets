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
        Schema::create('users_projects_request', function (Blueprint $table) {
            $table->integer('id_userProjectRequest', true);
            $table->integer('fk_user')->index('fk_users_groups_projects_users1_idx');
            $table->integer('fk_project')->index('fk_users_projects_request_projects1_idx');
            $table->integer('fk_request')->index('fk_users_projects_request_requests1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users_projects_request');
    }
};
