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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->string('firstname')->nullable();
            $table->string('surname')->nullable();
            $table->string('nickname')->unique()->nullable();
            $table->integer('gender')->nullable();
            $table->integer('balance')->nullable();
            $table->text('phone')->nullable();;
            $table->date('PremiumStatus')->nullable();
            $table->softDeletes();
            $table->foreignId('user_id')->index()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
