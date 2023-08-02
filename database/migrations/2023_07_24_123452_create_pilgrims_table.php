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
        Schema::create('pilgrims', function (Blueprint $table) {
            $table->id('pilgrims_id');
            $table->string('kode', 100);
            $table->bigInteger('user_account_id')->unsigned();
            $table->bigInteger('saving_category_id')->unsigned();
            $table->string('bank_name', 100);
            $table->string('no_rekening', 70);
            $table->string('nik', 20);
            $table->string('no_kk', 20);
            $table->date('birth_date');
            $table->enum('gender', array('laki-laki', 'perempuan'));
            $table->string('phone', 13);
            $table->text('address');
            $table->timestamps();
        });

        Schema::table('pilgrims', function (Blueprint $table) {
            $table->foreign('user_account_id')->references('user_account_id')->on('user_account')
            ->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::table('pilgrims', function (Blueprint $table) {
            $table->foreign('saving_category_id')->references('saving_category_id')->on('saving_categories')
            ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pilgrims');
    }
};
