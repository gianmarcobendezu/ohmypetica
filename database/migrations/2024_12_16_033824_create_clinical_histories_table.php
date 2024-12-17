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
        Schema::create('clinical_histories', function (Blueprint $table) {
            $table->id();
            $table->string('pet_name');
            $table->string('breed');
            $table->date('birth_date');
            $table->string('service');
            $table->text('observation')->nullable();
            $table->string('owner_name');
            $table->string('phone1');
            $table->string('phone2')->nullable();
            $table->decimal('rate', 8, 2);
            $table->string('payment_method');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_histories');
    }
};
