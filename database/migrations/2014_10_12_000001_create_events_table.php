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
        Schema::create('events', function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->string('title');
            $table->string('description');
            $table->string('hour');
            $table->string('place');
            $table->string('availabl_space');
            $table->string('type');
            $table->string('base_value');
            $table->date('opening_date');
            $table->date('closing_date');
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
        Schema::dropIfExists('events');
    }
};
