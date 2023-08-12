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
        Schema::create('notification', function (Blueprint $table) {
            $table->id('notification_id');
            $table->foreignId('user_account_id')->references('user_account_id')->on('user_account')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('transactional_savings_id')->references('transactional_savings_id')->on('transactional_savings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('message', 255);
            $table->enum ('status', ['read', 'unread'])->default('unread');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification');
    }
};
