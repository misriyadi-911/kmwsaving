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
        Schema::create('transactional_savings', function (Blueprint $table) {
            $table->id('transactional_savings_id');
            $table->bigInteger('pilgrims_id')->unsigned();
            $table->bigInteger('nominal');
            $table->enum('type', array('debit','kredit'));
            $table->timestamps();
        });

        Schema::table('transactional_savings', function (Blueprint $table) {
            $table->foreign('pilgrims_id')->references('pilgrims_id')->on('pilgrims')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactional_savings');
    }
};
