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
        Schema::create('films', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_eng')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('video_content_id')->index()->constrained('video_contents');
            $table->double('rating')->nullable();
            $table->year('year')->nullable();
            $table->unsignedBigInteger('film_id_api')->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('films');
    }
};
