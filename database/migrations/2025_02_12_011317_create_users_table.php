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
        Schema::create('users', function (Blueprint $table) {
            $table->integer('user_id', true);
            $table->integer('fk_rol')->index('fk_users_rols1_idx');
            $table->integer('fk_group')->index('fk_users_groups1_idx');
            $table->string('user_code', 100)->unique('user_code_unique');
            $table->integer('user_identification')->unique('user_identificadion_unique');
            $table->string('user_gender', 100);
            $table->string('user_name', 100);
            $table->string('user_lastName', 100);
            $table->string('email', 100)->unique('user_email_unique');
            $table->string('password', 100);
            $table->date('user_dateOfBirth');
            $table->string('user_status', 100);
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};
