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
        Schema::create('genre_films', function (Blueprint $table) {
            $table->id();
            $table->foreignId('genre_id')->index()->constrained('genres');
            $table->foreignId('film_id')->index()->constrained('films');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('genre_films');
    }
};
