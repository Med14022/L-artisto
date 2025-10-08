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
    Schema::create('rendez_vouses', function (Blueprint $table) {
        $table->id();

        // date et heure
        $table->date('date');
        $table->time('heure');

        // état du rendez-vous (ex : en attente, confirmé, annulé...)
        $table->string('etat')->default('en attente');

        // relation avec user (client)
        $table->unsignedBigInteger('id_client');
        $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');

        // relation avec user (coiffeur)
        $table->unsignedBigInteger('id_coiffeur');
        $table->foreign('id_coiffeur')->references('id')->on('users')->onDelete('cascade');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rendez_vouses');
    }
};
