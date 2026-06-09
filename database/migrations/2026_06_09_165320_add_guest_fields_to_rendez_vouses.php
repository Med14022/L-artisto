<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rendez_vouses', function (Blueprint $table) {
            $table->string('nom_client')->nullable()->after('id_coiffeur');
            $table->string('telephone_client')->nullable()->after('nom_client');
        });
    }

    public function down(): void
    {
        Schema::table('rendez_vouses', function (Blueprint $table) {
            $table->dropColumn(['nom_client', 'telephone_client']);
        });
    }
};
