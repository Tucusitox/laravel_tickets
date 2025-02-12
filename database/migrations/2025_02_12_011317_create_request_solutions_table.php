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
        Schema::create('request_solutions', function (Blueprint $table) {
            $table->integer('id_requestSolution', true);
            $table->integer('fk_request')->index('fk_request_solutions_requests1_idx');
            $table->string('solution_userName', 100);
            $table->string('solution_tittle', 100);
            $table->string('solution_description', 1000);
            $table->time('solution_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_solutions');
    }
};
