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
        Schema::create('scan_histories', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // Menyimpan target, misal: dinkes.hsu.go.id
            $table->integer('score'); // Menyimpan nilai keamanan (0-100)
            $table->json('header_results')->nullable(); // Menyimpan data scan header
            $table->json('file_results')->nullable();   // Menyimpan data file bocor
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scan_histories');
    }
};