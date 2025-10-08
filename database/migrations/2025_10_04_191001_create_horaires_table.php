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
        Schema::create('horaires', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_coiffeur');
            $table->date('date');
            $table->foreign('id_coiffeur')->references('id')->on('users')->onDelete('cascade');
            $table->string('horaire_jour')->default('10:00-14:00/15:00-21:00');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horaires');
    }
};
