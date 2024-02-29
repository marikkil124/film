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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('amount')->nullable();
            $table->text('currency')->nullable();
            $table->integer('type');
            $table->integer('status')->default(1);
            $table->text('error_message')->nullable();
            $table->foreignId('user_id')->index()->constrained('users');
            $table->foreignId('order_id')->index()->nullable()->constrained('orders');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
