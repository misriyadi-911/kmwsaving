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
        Schema::create('departure_informations', function (Blueprint $table) {
            $table->id('departure_information_id');
            $table->bigInteger('pilgrims_id')->unsigned();
            $table->dateTime('time');
            $table->timestamps();
        });

        Schema::table('departure_informations', function (Blueprint $table) {
            $table->foreign('pilgrims_id')->references('pilgrims_id')->on('pilgrims')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('departure_informations');
    }
};
