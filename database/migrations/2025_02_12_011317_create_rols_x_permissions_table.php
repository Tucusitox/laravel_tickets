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
        Schema::create('rols_x_permissions', function (Blueprint $table) {
            $table->integer('id_rolXpermission', true);
            $table->integer('fk_rol')->index('fk_rols_has_permissions_rols1_idx');
            $table->integer('fk_permission')->index('fk_rols_has_permissions_permissions1_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rols_x_permissions');
    }
};
