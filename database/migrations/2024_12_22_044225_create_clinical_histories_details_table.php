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
        Schema::create('clinical_history_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('clinical_history_id'); // Relación con la historia clínica
            $table->string('service');
            $table->decimal('rate', 8, 2);
            $table->string('payment_method');
            $table->dateTime('service_datetime');
            $table->text('observation')->nullable();
            $table->timestamps();
    
            // Clave foránea
            $table->foreign('clinical_history_id')
                  ->references('id')
                  ->on('clinical_histories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_histories_details');
    }
};
