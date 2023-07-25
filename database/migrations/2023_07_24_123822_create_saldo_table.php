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
        Schema::create('saldo', function (Blueprint $table) {
            $table->id('saldo_id');
            $table->bigInteger('pilgrims_id')->unsigned();
            $table->double('nominal');
            $table->timestamps();
        });

        Schema::table('saldo', function (Blueprint $table) {
            $table->foreign('pilgrims_id')->references('pilgrims_id')->on('pilgrims')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saldo');
    }
};
