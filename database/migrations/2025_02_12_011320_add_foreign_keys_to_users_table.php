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
        Schema::table('users', function (Blueprint $table) {
            $table->foreign(['fk_group'], 'fk_users_groups1')->references(['id_group'])->on('groups')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['fk_rol'], 'fk_users_rols1')->references(['id_rol'])->on('rols')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('fk_users_groups1');
            $table->dropForeign('fk_users_rols1');
        });
    }
};
