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
        Schema::create('registrations', function (Blueprint $table) {
            $table->unsignedInteger("id")->autoIncrement();
            $table->date("input_type");
            $table->string("calculated_value");
            $table->string("purchase_date");
            $table->string("promotional code");
            $table->unsignedSmallInteger('user_id');
            $table->unsignedInteger('assitant_id');
            $table->unsignedInteger('event_id');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('assitant_id')->references('id')->on('assistants');
            $table->foreign('event_id')->references('id')->on('events');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
