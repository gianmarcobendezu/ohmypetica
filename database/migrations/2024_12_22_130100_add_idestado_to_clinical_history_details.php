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
        Schema::table('clinical_history_details', function (Blueprint $table) {
            $table->boolean('idestado')->default(1); // Estado 1 por defecto
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('clinical_history_details', function (Blueprint $table) {
            $table->dropColumn('idestado');
        });
    }
};
