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
        Schema::table('request_solutions', function (Blueprint $table) {
            $table->foreign(['fk_request'], 'fk_request_solutions_requests1')->references(['id_request'])->on('requests')->onUpdate('no action')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('request_solutions', function (Blueprint $table) {
            $table->dropForeign('fk_request_solutions_requests1');
        });
    }
};
