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
        Schema::table('follows_requests', function (Blueprint $table) {
            $table->foreign(['fk_UserProjectRequest'], 'fk_follows_requests_users_projects_request1')->references(['id_userProjectRequest'])->on('users_projects_request')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('follows_requests', function (Blueprint $table) {
            $table->dropForeign('fk_follows_requests_users_projects_request1');
        });
    }
};
