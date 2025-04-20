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
        Schema::create('visits', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('patient_id')->nullable();
                $table->foreign('patient_id')->references('id')->on('patients');
                $table->enum('visit_type', ['baru', 'lama']);
                $table->timestamp('visit_date')->useCurrent();
                $table->unsignedBigInteger('treatment_id')->nullable();
                $table->foreign('treatment_id')->references('id')->on('treatments');
                $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
