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
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rendez_vous_id');
            $table->unsignedBigInteger('id_client');
            $table->unsignedBigInteger('id_coiffeur');
            $table->tinyInteger('note');               // 1 à 5
            $table->text('commentaire')->nullable();
            $table->foreign('rendez_vous_id')->references('id')->on('rendez_vouses')->onDelete('cascade');
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_coiffeur')->references('id')->on('users')->onDelete('cascade');
            $table->unique('rendez_vous_id');          // un seul avis par RDV
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
