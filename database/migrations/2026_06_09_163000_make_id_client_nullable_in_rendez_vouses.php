<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rendez_vouses', function (Blueprint $table) {
            $table->dropForeign(['id_client']);
            $table->unsignedBigInteger('id_client')->nullable()->change();
            $table->foreign('id_client')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('rendez_vouses', function (Blueprint $table) {
            $table->dropForeign(['id_client']);
            $table->unsignedBigInteger('id_client')->nullable(false)->change();
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
