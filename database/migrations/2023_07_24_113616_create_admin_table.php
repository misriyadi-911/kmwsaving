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
        Schema::create('admin', function (Blueprint $table) {
            $table->id('employe_id');
            $table->bigInteger('user_account_id')->unsigned();
            $table->integer('role_id');
            $table->text('address');
            $table->string('phone', 13);
            $table->enum('gender', array('laki-laki','perempuan'));
            $table->timestamps();
        });

        Schema::table('admin', function (Blueprint $table) {
            $table->foreign('user_account_id')->references('user_account_id')->on('user_account')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
