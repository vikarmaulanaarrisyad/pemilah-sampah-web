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
        Schema::create('sampahs', function (Blueprint $table) {
            $table->id();
            $table->float('kapasitas_logam');
            $table->float('kapasitas_organik');
            $table->float('kapasitas_anorganik');
            $table->integer('tinggi_logam');
            $table->integer('tinggi_organik');
            $table->integer('tinggi_anorganik');
            $table->dateTime('data_waktu');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampahs');
    }
};
