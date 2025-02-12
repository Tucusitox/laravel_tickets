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
        Schema::table('users_projects_request', function (Blueprint $table) {
            $table->foreign(['fk_user'], 'fk_users_groups_projects_users1')->references(['user_id'])->on('users')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['fk_project'], 'fk_users_projects_request_projects1')->references(['id_project'])->on('projects')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['fk_request'], 'fk_users_projects_request_requests1')->references(['id_request'])->on('requests')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users_projects_request', function (Blueprint $table) {
            $table->dropForeign('fk_users_groups_projects_users1');
            $table->dropForeign('fk_users_projects_request_projects1');
            $table->dropForeign('fk_users_projects_request_requests1');
        });
    }
};
