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
        Schema::create('user_account', function (Blueprint $table) {
            $table->id('user_account_id');
            $table->string('username',255);
            $table->string('password',100);
            $table->enum('type',array('admin','pengguna','jamaah'));
            $table->string('thumbnail', 255);
            $table->timestamps();
        });

        Schema::table('user_account', function (Blueprint $table){
            $table->string('email',100);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_account');
    }
};
