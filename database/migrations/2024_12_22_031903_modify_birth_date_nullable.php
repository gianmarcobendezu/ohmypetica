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
        Schema::table('clinical_histories', function (Blueprint $table) {
            $table->date('birth_date')->nullable()->change(); // Permitir valores nulos
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_histories', function (Blueprint $table) {
            $table->date('birth_date')->nullable(false)->change(); // Revertir a no nulo
        });
    }
};
