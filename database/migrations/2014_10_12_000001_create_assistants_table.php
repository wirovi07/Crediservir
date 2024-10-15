<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assistants', function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birthdate');
            $table->string('email');
            $table->string('phone');
            $table->unsignedSmallInteger('user_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assistants');
    }
};
